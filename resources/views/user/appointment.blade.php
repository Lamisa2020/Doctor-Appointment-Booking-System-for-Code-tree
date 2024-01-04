<div class="page-section">
    <div class="container">
        <h1 class="text-center wow fadeInUp">Make an Appointment</h1>
        {{-- {{$time}} --}}
        <form class="main-form" action="{{ url('appoinment') }}" method="POST">
            @csrf
            <div class="row mt-5">
                <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
                    <input type="text" name="name" class="form-control" placeholder="Full name">
                </div>
                <div class="col-12 col-sm-6 py-2 wow fadeInRight">
                    <input type="text" class="form-control" placeholder="Email address.." name="email">
                </div>
                

                <div class="col-12 col-md-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
                    <select class="form-control" id="timeSlots" name="timeSlots">
                        <option>
                            Select Time Slot
                        </option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 py-2 wow fadeInRight" data-wow-delay="300ms">
                    <select name="doctor" id="doctor" class="custom-select">
                        <option>---select doctor---</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }} --- {{ $doctor->speciality }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                    <input type="text" class="form-control" placeholder="Number.." name="number">
                </div>
                <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                    <label for="number">Fees</label>
                    <input type="number" id="fees" class="form-control" placeholder="Number.." name="fees" value="{{ $doctor->fees }}" readonly>
                </div>
                <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                    <textarea id="message" class="form-control" rows="6" placeholder="Enter message.." name="message"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#doctor').on('change', function() {
            var selectedDoctor = $(this).val();

            // Example: Output to the console
            console.log('Selected Doctor:', selectedDoctor);

            // Example: Send AJAX request
            $.ajax({
            type: 'GET',
            url: `${window.location.origin}/api/getdoctortime/${encodeURIComponent(selectedDoctor)}`,
            success: function(response) {
                console.log(response[0]);
                let time = response.timeSlots;

                console.log(time);
                
                // Assuming you have a reference to your select element
                let selectElement = $('#timeSlots');
                $('#fees').val(response.fees); // Corrected line

                // Clear existing options before appending new ones
                selectElement.empty();

                time.forEach(function(slot, index) {
                    // Create a new option element
                    let option = $('<option>');

                    // Set the text content of the option
                    option.text(`From: ${slot.from} - To: ${slot.to}`);
                    option.val(`${slot.from} - ${slot.to}`);

                    // Optionally, you can set the value attribute of the option if needed
                    // option.val(index);

                    // Append the option to the select element
                    selectElement.append(option);
        });
    },
    error: function(error) {
        console.log(error.responseText);
        // Handle errors
    }
});

        });
    });

</script>
