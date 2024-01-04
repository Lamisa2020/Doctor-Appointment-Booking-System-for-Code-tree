<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendEmailNotification;


class AdminController extends Controller
{
    //
    public function addview()
    {
        return view('admin.add_doctor');
    }


    public function upload(Request $request)
    {

        //  return $hashedPassword;
        // Get the array of "from" time values
        $fromTimes = $request->input('time_from');

        // Get the array of "to" time values
        $toTimes = $request->input('time_to');


        // Combine "from" and "to" time values into a single array
        $timeSlots = array_map(function ($from, $to) {
            return ['from' => $from, 'to' => $to];
        }, $fromTimes, $toTimes);

        // Serialize the array before storing it in the database
        $serializedTimeSlots = serialize($timeSlots);

        // dd($serializedTimeSlots);
        // The rest of your code
        $doctor = new Doctor;

        // Get the uploaded file
        $image = $request->file('file');

        // Generate a unique image name
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Move the uploaded file to the 'doctorimage' directory
        $image->move('doctorimage', $imageName);

        $doctor->image = $imageName;
        $doctor->name = $request->input('name');
        $doctor->phone = $request->input('number');
        $doctor->room = $request->input('room');
        $doctor->fees = $request->input('fees');
        $doctor->timeSlots = $serializedTimeSlots;
        $doctor->speciality = $request->input('speciality');

        $doctor->save();

        $user = new User;
        $hashedPassword = bcrypt($request->input('password'));

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('number');
        $user->password = $hashedPassword;
        $user->email_verified_at = now(); // Use the now() function to set the current timestamp
        $user->address = $request->input('address');
        $user->usertype = 2;
        $user->save();

        return redirect()->back()->with('message', 'Doctor Added Successfully');
    }



    public function showappointment()
    {
        $data = Appointment::leftJoin('doctors', 'appointments.doctor', '=', 'doctors.id')
        ->select('appointments.*', 'doctors.name as doctor')
        ->get();
    
        return view('admin.showappointment', compact('data'));
    }

    public function approved($id)
    {
        $data = Appointment::find($id);

        $data->status = 'approved';

        $data->save();

        return redirect()->back();
    }

    public function canceled($id)
    {
        $data = Appointment::find($id);

        $data->status = 'Canceled';

        $data->save();

        return redirect()->back();
    }

    public function showdoctor()
    {
        $data = Doctor::all();

        return view('admin.showdoctor', compact('data'));
    }

    public function showdoctorUser()
    {
        $data = Doctor::all();

        return view('user.allDoctor', compact('data'));
    }
    public function deletedoctor($id)
    {
        $data = Doctor::find($id);

        $data->delete();

        return redirect()->back();
    }
    public function appoint($id)
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

        return view('user\appoinment_page', compact('doctors'));
    }


    public function updatedoctor($id)
    {
        $data = Doctor::find($id);

        return view('admin.update_doctor', compact('data'));
    }

    public function editdoctor(Request $request, $id)
    {
        $doctor = Doctor::find($id);

        $doctor->name = $request->name;
        $doctor->phone = $request->number;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;
        $doctor->fees = $request->fees;


        // Update image if a new one is provided
        $image = $request->file('file');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('doctorimage', $imageName);
            $doctor->image = $imageName;
        }

        // Update time slots
        $timeFrom = $request->input('time_from');
        $timeTo = $request->input('time_to');
        $timeSlots = [];

        foreach ($timeFrom as $index => $from) {
            $to = $timeTo[$index];
            $timeSlots[] = ['from' => $from, 'to' => $to];
        }

        // Serialize the time slots before saving
        $serializedTimeSlots = serialize($timeSlots);
        $doctor->timeSlots = $serializedTimeSlots;

        $doctor->save();

        return redirect()->back()->with('message', 'Update successfully!!');
    }


    public function emailview($id)
    {
        $data = Appointment::find($id);

        return view('admin.email_view', compact('data'));
    }

    public function sendemail(Request $request, $id)
    {
        $data = Appointment::find($id);

        $details = [
            'greeting' => $request->greeting,
            'body' => $request->body,
            'actiontext' => $request->actiontext,
            'actionurl' => $request->actionurl,
            'endpart' => $request->endpart,
        ];

        $data->notify(new SendEmailNotification($details));

        return redirect()->back()->with('message', 'Email send is successful');
    }
}
