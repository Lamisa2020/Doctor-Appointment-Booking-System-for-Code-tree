<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Today's Patients List</title>
</head>

<body>
    <div class="w-100">
        @include('doctor.navbar')

        <div class="m-auto w-75 ">
            <h1 class="text-center mt-4">Write Patients Prescription</h1>
            <form class="main-form" action="{{ url('presciption') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Prescription</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="prescription" >{{ $data->prescription }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Signature</label>
                    <input type="file" class="form-control" name="file" id="file" required>
                </div>
            
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
            

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
