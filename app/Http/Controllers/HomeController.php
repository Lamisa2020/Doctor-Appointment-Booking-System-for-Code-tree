<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function redirect()
    {
        if (Auth::id()) {
            if (Auth::user()->usertype == '0') {
                $doctors = Doctor::all();
                return view('user.home', compact('doctors'));
            } else if (Auth::user()->usertype == '1') {
                $data = Doctor::all();

                return view('admin.showdoctor', compact('data'));
            } else if (Auth::user()->usertype == '2') {
                $id = User::leftJoin('doctors', 'users.name', '=', 'doctors.name')->where('users.id', '=', Auth::user()->id)->select('doctors.id')->get();
                $id = $id[0]->id;
                $data = Appointment::where('doctor', '=', $id)->get();
                // return $data;
                return view('doctor.home', compact('data'));
            }
        }
    }



    public function index()
    {
        $doctors = Doctor::all();

        return view('user.home', compact('doctors'));
    }

    public function appoinment(Request $request)
    {
        // return $request->timeSlots . " ". $request->fees;
        $data = new Appointment;

        $data->name = $request->name;
        $data->email = $request->email;
        $data->date = $request->date;
        $data->phone = $request->number;
        $data->message = $request->message;
        $data->doctor = $request->doctor;
        $data->timeSlots = $request->timeSlots;
        $data->fees = $request->fees;
        $data->status = 'approved';
        $data->paid = 'Paid';
        if (Auth::id()) {
            $data->user_id = Auth::user()->id;
        }
        $data->save();


        return view('exampleEasycheckout', compact('data'));

    }

    public function myappoinment()
    {
        if (Auth::id()) {
            $userid = Auth::user()->id;
            $appoint = Appointment::where('user_id', $userid)->get();

            return view('user.my_appoinment', compact('appoint'));
        } else {
            return redirect()->back();
        }
    }

    public function cancel_appoint($id)
    {
        $data = Appointment::find($id);

        $data->delete();

        return redirect()->back();
    }

    public function statusview($id)
    {
        $data =  Appointment::find($id);

        if ($data->view === 0) {
            $data->view = 1;
        } else {
            $data->view = 0;
        }

        $data->save();
        return redirect()->back();
    }

    public function presciption($id)
    {
        $data = Appointment::find($id);
        if (strlen($data->prescription) === 0) {
            return view('doctor.presciption', compact('data'));
        } else {
            return view('doctor.viewpresciption', compact('data'));
        }
    }



    public function presciptionSend(Request $request)
    {
        $data =  Appointment::find($request->id);
        $data->prescription = $request->prescription;

        $image = $request->file('file');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('signature', $imageName);
            $data->signature = $imageName;
        }

        $data->save();

        $data = Appointment::where('doctor', '=', Auth::user()->name)->get();

        return view('doctor.home', compact('data'));
    }
    public function getdoctortime($id)
    {
        $doctors = Doctor::find($id);
        $appointment = Appointment::select('timeSlots')->get();

        // Assuming you've already retrieved a specific doctor and unserialized the timeSlots
        $doctorsTimeSlots = unserialize($doctors->timeSlots);
        $updatedTimeSlots = [];

        foreach ($doctorsTimeSlots as $slotKey => $slot) {
            $stringRepresentation = strval($slot['from'] . " - " . $slot['to']);

            $matchFound = false;

            foreach ($appointment as $singleAppointment) {
                // Check if $singleAppointment is an object
                if (is_object($singleAppointment) && isset($singleAppointment->timeSlots)) {
                    if ($singleAppointment->timeSlots === $stringRepresentation) {
                        $matchFound = true;
                        break; // Exit the inner loop since a match is found
                    }
                } else {
                    // Handle the case where $singleAppointment is not an object with timeSlots property
                    // You might want to log or handle this situation appropriately
                }
            }

            // Add the time slot to the updated array if no match is found
            if (!$matchFound) {
                $updatedTimeSlots[] = $slot;
            }
        }

        // Update the doctor's timeSlots property with the modified array
        $doctors->timeSlots = $updatedTimeSlots;

        return $doctors;
    }

    public function histroy($name)
    {
        // Retrieve the appointment history for the given patient name
        $history = Appointment::where('name', $name)->get();

        // Process the history to categorize based on time
        $processedHistory = $history->map(function ($appointment) {
            // Calculate the time difference using Carbon
            $created_at = Carbon::parse($appointment->created_at);
            $now = Carbon::now();

            $daysAgo = $now->diffInDays($created_at);
            $monthsAgo = $now->diffInMonths($created_at);
            $yearsAgo = $now->diffInYears($created_at);

            // Convert days to months if greater than 30
            if ($daysAgo > 30) {
                $monthsAgo += floor($daysAgo / 30);
                $daysAgo %= 30;
            }

            // Convert months to years if greater than 12
            if ($monthsAgo > 12) {
                $yearsAgo += floor($monthsAgo / 12);
                $monthsAgo %= 12;
            }

            // Create a formatted string
            $timeAgo = ($yearsAgo > 0 ? "$yearsAgo years " : "") .
                ($monthsAgo > 0 ? "$monthsAgo months " : "") .
                ($daysAgo > 0 ? "$daysAgo days" : "");

            // Add the new property to the appointment object
            $appointment->timeAgo = trim($timeAgo);

            return $appointment;
        });



        return view('doctor.history', compact('processedHistory'));
    }

    public function report()
    {
        $today = now()->toDateString(); // Get the current date in 'Y-m-d' format
        $perPage = 3; // Number of items per page
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;

        $report = Appointment::select(
            'appointments.name',
            'appointments.timeSlots',
            \DB::raw('doctors.speciality as doctor_speciality'),
            \DB::raw('doctors.name as doctor_name'),
            \DB::raw('doctors.phone as doctor_phone'),
            \DB::raw('SUM(appointments.fees) as total')
        )
            ->leftJoin('doctors', 'appointments.doctor', '=', 'doctors.id')
            ->whereDate('appointments.created_at', $today) // Filter by today's date
            ->groupBy('appointments.name', 'appointments.timeSlots', 'doctors.speciality', 'doctors.name', 'doctors.phone')
            ->orderBy('appointments.created_at', 'DESC')
            ->simplePaginate($perPage, ['*'], 'page', $currentPage);

            $perPage = 3; // Number of items per page
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
    
        $allreport = Appointment::select(
            'appointments.name',
            'appointments.timeSlots',
            \DB::raw('doctors.speciality as doctor_speciality'),
            \DB::raw('doctors.name as doctor_name'),
            \DB::raw('doctors.phone as doctor_phone'),
            \DB::raw('SUM(appointments.fees) as total')
        )
            ->leftJoin('doctors', 'appointments.doctor', '=', 'doctors.id')
            ->groupBy('appointments.name', 'appointments.timeSlots', 'doctors.speciality', 'doctors.name', 'doctors.phone')
            ->orderBy('appointments.created_at', 'DESC')
            ->simplePaginate($perPage, ['*'], 'page', $currentPage);

        $currentMonth = now()->format('m'); // Get the current month in 'mm' format
        $perPage = 3; // Number of items per page
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;

        $monthreport = Appointment::select(
            'appointments.name',
            'appointments.timeSlots',
            \DB::raw('doctors.speciality as doctor_speciality'),
            \DB::raw('doctors.name as doctor_name'),
            \DB::raw('doctors.phone as doctor_phone'),
            \DB::raw('SUM(appointments.fees) as total')
        )
            ->leftJoin('doctors', 'appointments.doctor', '=', 'doctors.id')
            ->whereMonth('appointments.created_at', $currentMonth) // Filter by the current month
            ->groupBy('appointments.name', 'appointments.timeSlots', 'doctors.speciality', 'doctors.name', 'doctors.phone')
            ->orderBy('appointments.created_at', 'DESC')
            ->simplePaginate($perPage, ['*'], 'page', $currentPage);

            $currentYear = now()->year; // Get the current year

            $perPage = 3; // Number of items per page
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        
            $yearReport = Appointment::select(
                'appointments.name',
                'appointments.timeSlots',
                \DB::raw('doctors.speciality as doctor_speciality'),
                \DB::raw('doctors.name as doctor_name'),
                \DB::raw('doctors.phone as doctor_phone'),
                \DB::raw('SUM(appointments.fees) as total')
            )
                ->leftJoin('doctors', 'appointments.doctor', '=', 'doctors.id')
                ->whereYear('appointments.created_at', $currentYear) // Filter by the current year
                ->groupBy('appointments.name', 'appointments.timeSlots', 'doctors.speciality', 'doctors.name', 'doctors.phone')
                ->orderBy('appointments.created_at', 'DESC')
                ->simplePaginate($perPage, ['*'], 'page', $currentPage);
        

        return view('admin.report', ['report' => $report, 'allreport' => $allreport, 'monthreport' => $monthreport,'yearReport'=>$yearReport]);
    }
}
