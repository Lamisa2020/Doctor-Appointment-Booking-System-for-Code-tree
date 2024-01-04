<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body>
   <div class="container-scroller">
    @include('admin.sidebar')
    <div class="container-fluid page-body-wrapper">
        @include('admin.navbar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Appointment Details</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Doctor Name</th>
                                                <th>Date</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Payment Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $appoint)
                                            <tr>
                                                <td>{{$appoint->name}}</td>
                                                <td>{{$appoint->email}}</td>
                                                <td>{{$appoint->phone}}</td>
                                                <td>{{$appoint->doctor}}</td>
                                                <td>{{$appoint->date}}</td>
                                                <td>{{$appoint->message}}</td>
                                                <td>{{$appoint->status}}</td>
                                                <td>
                                                    @if($appoint->paid == 'Paid')
                                                        <button type="button" class="btn btn-success">Paid</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger">Not Paid</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{url('approved',$appoint->id)}}" class="btn btn-success">Approved</a>
                                                        <a href="{{url('canceled',$appoint->id)}}" class="btn btn-danger">Canceled</a>
                                                        <a href="{{url('emailview',$appoint->id)}}" class="btn btn-info">Send Mail</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @include('admin.script')
</body>

</html>