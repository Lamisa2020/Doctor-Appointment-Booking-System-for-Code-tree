<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        label {
            display: inline-block;
            width: 200px;
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
                <h1>Add Doctor</h1>

                <div class="container" style="padding-top: 100px;">

                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('message') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ url('upload_doctor') }}" method="POST" enctype="multipart/form-data"
                        class="container mt-4">
                        @csrf

                        <!-- Doctor Information Section -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Doctor Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Write the name" required>
                        </div>

                        <div class="mb-3">
                            <label for="number" class="form-label">Phone</label>
                            <input type="number" class="form-control" name="number" id="number"
                                placeholder="Write the number" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Write the email" required>
                        </div>
                        

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Write the address" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="speciality" class="form-label">Speciality</label>
                            <select class="form-select" name="speciality" id="speciality" required>
                                <option>--Select--</option>
                                <option value="Dermatologist">Dermatologist</option>
                                <option value="Cardiologist">Cardiologist</option>
                                <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>
                                <option value="Pediatrician">Pediatrician</option>
                                <option value="Neurologist">Neurologist</option>
                                <option value="Gastroenterologist">Gastroenterologist</option>
                                <option value="Obstetrician/Gynecologist">Obstetrician/Gynecologist</option>
                                <option value="Psychiatrist">Psychiatrist</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="room" class="form-label">Room No</label>
                            <input type="number" class="form-control" name="room" id="room"
                                placeholder="Write the room number" required>
                        </div>

                        <div class="mb-3">
                            <label for="fees" class="form-label">Fees</label>
                            <input type="number" class="form-control" name="fees" id="fees"
                                placeholder="Write the Fees" required>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Doctor Image</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" id="password"
                                placeholder="Write the password number" required>
                        </div>

                        <!-- Time Slots Section -->
                        <div class="mb-3">
                            <h4>Add Time Slots</h4>

                            <div id="timeSlotsContainer">
                                <div class="time-slot mb-3">
                                    <label for="time_from[]" class="form-label">From:</label>
                                    <select class="form-select" name="time_from[]" required>
                                        @php
                                            $startTime = strtotime('00:00');
                                            $endTime = strtotime('23:00');
                                        @endphp

                                        @while ($startTime <= $endTime)
                                            @php
                                                $formattedTime = date('h:i A', $startTime);
                                            @endphp

                                            <option value="{{ $formattedTime }}">{{ $formattedTime }}</option>

                                            @php
                                                $startTime += 60 * 60; // Increment by 1 hour
                                            @endphp
                                        @endwhile
                                    </select>

                                    <label for="time_to[]" class="form-label">To:</label>
                                    <select class="form-select" name="time_to[]" required>
                                        <!-- Generate options for "to" time using Blade -->
                                        @php
                                            $startTime = strtotime('00:00');
                                            $endTime = strtotime('23:00');
                                        @endphp

                                        @while ($startTime <= $endTime)
                                            @php
                                                $formattedTime = date('h:i A', $startTime);
                                            @endphp

                                            <option value="{{ $formattedTime }}">{{ $formattedTime }}</option>

                                            @php
                                                $startTime += 60 * 60; // Increment by 1 hour
                                            @endphp
                                        @endwhile
                                    </select>

                                </div>
                            </div>

                            <button type="button" id="addMore" class="btn btn-primary">Add More Time Slot</button>
                        </div>

                        <!-- Save Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>


                </div>
            </div>

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @include('admin.script')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Your script -->
    <script>
        // Function to generate time options
        function generateTimeOptions() {
            var startTime = new Date();
            startTime.setHours(0, 0, 0, 0);
            var endTime = new Date();
            endTime.setHours(23, 0, 0, 0);
    
            var options = '';
    
            while (startTime <= endTime) {
                var formattedTime = startTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
                options += '<option value="' + formattedTime + '">' + formattedTime + '</option>';
                startTime.setHours(startTime.getHours() + 1); // Increment by 1 hour
            }
    
            return options;
        }
    
        $(document).ready(function () {
            var timeSlotIndex = 2;
    
            $('#addMore').click(function () {
                var newTimeSlot = `
                    <div class="time-slot mb-3">
                        <label for="time_from[]" class="form-label">From:</label>
                        <select class="form-select" name="time_from[]" required>
                            ${generateTimeOptions()} <!-- Include the generated time options here -->
                        </select>
    
                        <label for="time_to[]" class="form-label">To:</label>
                        <select class="form-select" name="time_to[]" required>
                            ${generateTimeOptions()} <!-- Include the generated time options here -->
                        </select>
                    </div>
                `;
    
                $('#timeSlotsContainer').append(newTimeSlot);
                timeSlotIndex++;
            });
        });
    </script>
    


</body>

</html>
