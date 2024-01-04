<!DOCTYPE html>
<html lang="en">

<head>
<base href="/public">

    @include('admin.css')
    <style>
        label {
            display: inline-block;
            width: 200px;
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
                <h1>Add Doctor</h1>

                <div class="container" style="padding-top: 100px;">

                @if(session()->has('message'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session()->get('message')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif

                    <form action="{{ url('sendemail',$data->id) }}" method="POST" >
                        @csrf
                        <div style="padding: 15px;">
                            <label for="name">Greeting</label>
                            <input type="text" style="color: black;" name="greeting"  placeholder="Write the name" require>
                        </div>

                        <div style="padding: 15px;">
                            <label for="number">Body</label>
                            <input type="text" style="color: black;" name="body" placeholder="Write the number" require>
                        </div>


                        <div style="padding: 15px;">
                            <label for="number">Action Text</label>
                            <input type="text" style="color: black;" name="actiontext" placeholder="Write the number" require>
                        </div>

                        <div style="padding: 15px;">
                            <label for="number">Action Url</label>
                            <input type="text" style="color: black;" name="actionurl" placeholder="Write the number" require>
                        </div>

                        

                        <div style="padding: 15px;">
                            <label for="number">End Part</label>
                            <input type="text" style="color: black;" name="endpart" placeholder="Write the number" require>
                        </div>

                        <div style="padding: 15px;">
                            <input type="submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @include('admin.script')
</body>

</html>