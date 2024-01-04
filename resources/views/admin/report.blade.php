<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        label {
            display: inline-block;
            width: 200px;
        }

        a {
            color: black !important;
            text-decoration: none !important;
        }

        span {
            color: black
        }

    </style>
    @include('admin.css')
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

                <div class="container" style="padding-top: 50px;">
                    <div class="container">
                        <h1>Todays Report</h1>

                        @if ($report->isEmpty())
                        <p>No data available.</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Patients</th>
                                    <th>Time Slots</th>
                                    <th>Doctor Speciality</th>
                                    <th>Doctor Phone</th>
                                    <th>Total Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->name }}</td>
                                    <td>{{ $appointment->timeSlots }}</td>
                                    <td>{{ $appointment->doctor_speciality }}</td>
                                    <td>{{ $appointment->doctor_phone }}</td>
                                    <td>{{ $appointment->total }} tk</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="mt-4">Total Fees: {{ $report->sum('total') }} tk</h3>
                        @endif
                    </div>
                    <div class="p-4">
                        {{ $report->links() }}
                    </div>
                    <hr>
                    
                    <div class="container">
                        <h1>All Report</h1>

                        @if ($allreport->isEmpty())
                        <p>No data available.</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Patients</th>
                                    <th>Time Slots</th>
                                    <th>Doctor Speciality</th>
                                    <th>Doctor Phone</th>
                                    <th>Total Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allreport as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->name }}</td>
                                    <td>{{ $appointment->timeSlots }}</td>
                                    <td>{{ $appointment->doctor_speciality }}</td>
                                    <td>{{ $appointment->doctor_phone }}</td>
                                    <td>{{ $appointment->total }} tk</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="mt-4">Total Fees: {{ $allreport->sum('total') }} tk</h3>
                        @endif
                    </div>
                    <div class="p-4">
                        {{ $allreport->links() }}
                    </div>
                    <hr>
                    
                    
                    <div class="container">
                        <h1>Monthly Report</h1>

                        @if ($monthreport->isEmpty())
                        <p>No data available.</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Patients</th>
                                    <th>Time Slots</th>
                                    <th>Doctor Speciality</th>
                                    <th>Doctor Phone</th>
                                    <th>Total Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monthreport as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->name }}</td>
                                    <td>{{ $appointment->timeSlots }}</td>
                                    <td>{{ $appointment->doctor_speciality }}</td>
                                    <td>{{ $appointment->doctor_phone }}</td>
                                    <td>{{ $appointment->total }} tk</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="mt-4">Total Fees: {{ $monthreport->sum('total') }} tk</h3>
                        @endif
                    </div>
                    <div class="p-4">
                        {{ $monthreport->links() }}
                    </div>
                    <hr>
                    
                    <div class="container">
                        <h1>Yearly Report</h1>

                        @if ($yearReport->isEmpty())
                        <p>No data available.</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Patients</th>
                                    <th>Time Slots</th>
                                    <th>Doctor Speciality</th>
                                    <th>Doctor Phone</th>
                                    <th>Total Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yearReport as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->name }}</td>
                                    <td>{{ $appointment->timeSlots }}</td>
                                    <td>{{ $appointment->doctor_speciality }}</td>
                                    <td>{{ $appointment->doctor_phone }}</td>
                                    <td>{{ $appointment->total }} tk</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="mt-4">Total Fees: {{ $yearReport->sum('total') }} tk</h3>

                        @endif
                    </div>
                    <div class="p-4">
                        {{ $yearReport->links() }}
                    </div>

                </div>
            </div>

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @include('admin.script')

</body>

</html>
