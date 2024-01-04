<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Today's Patients List</title>
</head>

<body>
    <div class="w-100">
        @include('doctor.navbar')
        
        <div class="m-auto w-75 ">
            <h1 class="text-center mt-4">Today's Patients List</h1>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Time Slots</th>
                        <th>Fees</th>
                        <th>History</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalFees = 0; // Initialize total fees variable
                    ?>
                    @foreach($data as $appointment)
                        <tr>
                            <td>{{ $appointment['id'] }}</td>
                            <td>{{ $appointment['name'] }}</td>
                            <td>{{ $appointment['email'] }}</td>
                            <td>{{ $appointment['phone'] }}</td>
                            <td>{{ $appointment['timeSlots'] }}</td>
                            <td>{{ $appointment['fees'] }}</td>
                            <td><a href="{{ url('histroy', $appointment['name']) }}" class="btn btn-primary">History</a></td>
                            <td>{{ $appointment['paid'] }}</td>
                            <td><a href="{{ url('statusview', $appointment['id']) }}" class="btn {{ $appointment['view'] === 1 ? 'btn-outline-success' : 'btn-outline-danger' }}">{{ $appointment['view'] === 1 ? 'Visited' : 'Not Visited' }}</a></td>
                            <td>
                                <a href="{{ url('presciption', $appointment['id']) }}" class="btn {{ strlen($appointment['prescription']) === 0 ? "btn-success" : "btn-primary" }}">
                                    {{ strlen($appointment['prescription']) === 0 ? "Write" : "View" }}
                                </a>
                            </td>
                        </tr>
                        <?php
                            // Update total fees for each row
                            $totalFees += $appointment['fees'];
                        ?>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Display the total fees outside the table -->
            <p class="bg-success text-white p-4"  style="font-size: 20px;font-weight: bolder;">Total Fees: ${{ $totalFees }}</p>
            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
