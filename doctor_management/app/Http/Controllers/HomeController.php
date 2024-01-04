<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return view('doctor.home');
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
        $data = new Appointment;

        $data->name = $request->name;
        $data->email = $request->email;
        $data->date = $request->date;
        $data->phone = $request->number;
        $data->message = $request->message;
        $data->doctor = $request->doctor;
        $data->status = 'In progress';
        $data->paid = 'Unpaid';
        if (Auth::id()) {
            $data->user_id = Auth::user()->id;
        }

        $data->save();

        return redirect()->back()->with('message', 'Appoinment Request Successful. We will contact with you soon');
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
}
