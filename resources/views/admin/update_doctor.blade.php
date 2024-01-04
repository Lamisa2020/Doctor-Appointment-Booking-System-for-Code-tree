<!DOCTYPE html>
<html lang="en">

<head>

    <base href="/public">

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
                <h1>Update Doctor</h1>

                <div class="container" style="padding-top: 100px;">

                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('message') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ url('editdoctor', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    
                        <div class="form-group">
                            <label for="name" style="font-size: 18px;">Doctor Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter the name" required value="{{ $data->name }}">
                        </div>
                    
                        <div class="form-group">
                            <label for="number" style="font-size: 18px;">Phone</label>
                            <input type="number" class="form-control" name="number" id="number" placeholder="Enter the number" value="{{ $data->phone }}" required>
                        </div>
                    
                       
                        <div class="form-group">
                            <label for="speciality" style="font-size: 18px;">Speciality</label>
                            <select class="form-select" name="speciality" id="speciality" style="font-size: 16px;">
                                <option selected>{{ $data->speciality }}</option>
                                <option value="Dermatologist">Dermatologist</option>
                                <!-- Add other options as needed -->
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="room" style="font-size: 18px;">Room No</label>
                            <input type="text" class="form-control" name="room" id="room" placeholder="Enter the room number" required value="{{ $data->room }}" style="font-size: 16px;">
                        </div>
                    
                        <div class="mb-3">
                            <label for="fees" class="form-label">Fees</label>
                            <input type="number" class="form-control" name="fees" id="fees"
                                placeholder="Write the Fees" required value="{{ $data->fees }}"  >
                        </div>

                        <div id="timeSlotsContainer" class="mb-3">
                            @foreach (unserialize($data->timeSlots) as $index => $slot)
                                <div class="time-slot">
                                    <label for="time_from[]" class="form-label" style="font-size: 18px;">From:</label>
                                    <input type="text" class="form-control" name="time_from[]" id="time_from{{ $index }}" placeholder="12:00 AM" value="{{ $slot['from'] }}" required style="font-size: 16px;">
                    
                                    <label for="time_to[]" class="form-label" style="font-size: 18px;">To:</label>
                                    <input type="text" class="form-control" name="time_to[]" id="time_to{{ $index }}" placeholder="06:00 PM" value="{{ $slot['to'] }}" required style="font-size: 16px;">
                                </div>
                            @endforeach
                            <button type="button" id="addMore" class="btn btn-primary mt-2" style="font-size: 16px;">Add More Time Slot</button>
                        </div>
                    

                        <div class="form-group">
                            <label for="file" style="font-size: 18px;">Old Image</label>
                            <img height="150" width="150" src="doctorimage/{{ $data->image }}" alt="" class="img-thumbnail">
                        </div>
                    
                        <div class="form-group">
                            <label for="file" style="font-size: 18px;">Change Image</label>
                            <input type="file" class="form-control-file" name="file" style="font-size: 16px;">
                        </div>
                    
                        <button type="submit" class="btn btn-success" style="font-size: 18px;">Submit</button>
                    </form>
                    
                    <script>
                        // Your JavaScript code for adding more time slots
                    </script>
                    
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
            // ... (same as in your script)
        }

        $(document).ready(function() {
            var timeSlotIndex = {{ count(unserialize($data->timeSlots)) }}; // Start index from existing count

            $('#addMore').click(function() {
                var newTimeSlot = `
                    <div class="time-slot mb-3">
                        <label for="time_from[]" class="form-label">From:</label>
                        <input type="text" style="color: black;" name="time_from[]"
                            id="time_from${timeSlotIndex}" placeholder="12:00 AM"
                            value="" required>
    
                        <label for="time_to[]" class="form-label">To:</label>
                        <input type="text" style="color: black;" name="time_to[]"
                            id="time_to${timeSlotIndex}" placeholder="06:00 PM"
                            value="" required>
                    </div>
                `;

                $('#timeSlotsContainer').append(newTimeSlot);
                timeSlotIndex++;
            });
        });
    </script>


</body>

</html>
