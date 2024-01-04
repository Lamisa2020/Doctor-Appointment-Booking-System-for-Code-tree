<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 56px;
            /* Adjusted padding to accommodate fixed navbar */
        }

        .prescription-container {
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Prescription </a>
    </nav>
    <!-- Main Content -->
    <div class="container prescription-container">
        <div class="row card" style="height: 61vh;width: 95vh;">
            <div class="col-md-12">
                <h1 class="text-center" style="font-size: 52px;margin-top: 30px;font-weight: bolder;font-style: italic;">{{$data->doctor}}</h1>
                <p class="text-center" style="font-size: 22px;">Healing Lives, Every Day</p>


                <div class="d-flex justify-content-between">
                    <h3 class="mb-4">Patient Name : <span style="border-bottom: dotted black;">{{$data->name}}</span></h3>
                    <h3 class="mb-4">Date : <span style="border-bottom: dotted black;">
                            <?php
                // Assuming $data->created_at contains the timestamp
                
                $timestamp = $data->created_at;
                $date = date("Y-m-d", strtotime($timestamp));
                
                echo $date;
                ?>

                        </span>
                    </h3>
                </div>



                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Instructions:</h5>
                        <p>
                            {{$data->prescription}}
                        </p>
                    </div>
                </div>
                <br />
                <div class='d-flex pb-3'>
                    <strong class="mt-4" style="font-size: 23px;">Signature: <img height="300" width="300" src="{{ asset('signature/' . $data->signature) }}" alt="" style="height: 106px;width: 151px;border-radius: 100%;"></strong>

                </div>
                <br />

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
