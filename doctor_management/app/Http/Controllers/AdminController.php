<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
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
        $doctor->speciality = $request->input('speciality');
    
        $doctor->save();
        return redirect()->back()->with('message','Doctor Added Successfully');
    }

    public function showappointment()
    {
        $data = Appointment::all();

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

        return view('admin.showdoctor',compact('data'));
    }

    public function deletedoctor($id)
    {
        $data = Doctor::find($id);

        $data->delete();

        return redirect()->back();
    }
    
    public function updatedoctor($id)
    {
        $data = Doctor::find($id);

        return view('admin.update_doctor',compact('data'));
    }

    public function editdoctor(Request $request,$id)
    {
        $doctor = Doctor::find($id);

        $doctor->name = $request->name;
        $doctor->phone = $request->number;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;

        $image = $request->file('file');
    
       if($image)
       {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
    
        // Move the uploaded file to the 'doctorimage' directory
        $image->move('doctorimage', $imageName);
    
        $doctor->image = $imageName;
       }

        $doctor->save();

        return redirect()->back()->with('message','Update successfully!!');
    }

    public function emailview($id)
    {
        $data = Appointment::find($id);

        return view('admin.email_view',compact('data'));
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
    
        return redirect()->back()->with('message','Email send is successful');
    }
    
}
