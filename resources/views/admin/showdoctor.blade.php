<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <style>
        .table th,
        .jsgrid .jsgrid-table th,
        .table td,
        .jsgrid .jsgrid-table td {
            vertical-align: middle;
            font-size: 23px;
            line-height: 1;
            white-space: nowrap;
            padding: 0.9375rem;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            @include('admin.navbar')
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <div align="center" style="padding: 70px;">
                    <table class="table table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Doctor Name</th>
                                <th>Phone</th>
                                <th>Speciality</th>
                                <th>Room No</th>
                                <th>From - To</th>
                                <th>Image</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $doctor)
                            <tr>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->phone }}</td>
                                <td>{{ $doctor->speciality }}</td>
                                <td>{{ $doctor->room }}</td>
                                <td>
                                    @php
                                        $timeSlots = unserialize($doctor->timeSlots);
                                    @endphp
                            
                                    @foreach($timeSlots as $slot)
                                        From: {{ $slot['from'] }} - To: {{ $slot['to'] }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <img height="300" width="300" src="{{ asset('doctorimage/' . $doctor->image) }}" alt="" style="height: 104px;width: 88px;border-radius: 100%;">
                                </td>
                                <td><a href="{{ url('deletedoctor', $doctor->id) }}" class="btn btn-danger">Delete</a></td>
                                <td><a href="{{ url('updatedoctor', $doctor->id) }}" class="btn btn-primary">Update</a></td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div> <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @include('admin.script')
</body>

</html>
