<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="copyright" content="MACode ID, https://macodeid.com/">

    <title>One Health - Medical Center HTML5 Template</title>

    <link rel="stylesheet" href="../assets/css/maicons.css">

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">

    <link rel="stylesheet" href="../assets/vendor/animate/animate.css">

    <link rel="stylesheet" href="../assets/css/theme.css">
</head>

<body>

    <!-- Back to top button -->
    <div class="back-to-top"></div>

    <header>
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 text-sm">
                        <div class="site-info">
                            <a href="#"><span class="mai-call text-primary"></span> +00 123 4455 6666</a>
                            <span class="divider">|</span>
                            <a href="#"><span class="mai-mail text-primary"></span> mail@gmail.com</a>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right text-sm">
                        <div class="social-mini-button">
                            <a href="#"><span class="mai-logo-facebook-f"></span></a>
                            <a href="#"><span class="mai-logo-twitter"></span></a>
                            <a href="#"><span class="mai-logo-dribbble"></span></a>
                            <a href="#"><span class="mai-logo-instagram"></span></a>
                        </div>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div> <!-- .topbar -->

        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#"><span class="text-primary">Doctor Appoinment </span>Booking
                    System</a>

                {{-- <form action="#">
                    <div class="input-group input-navbar">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="icon-addon1"><span class="mai-search"></span></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter keyword.." aria-label="Username" aria-describedby="icon-addon1">
                    </div>
                </form> --}}

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport"
                    aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupport">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('showdoctorUser') }}">Doctors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.html">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>

                        @if (Route::has('login'))
                            @auth

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('myappoinment') }}">My Appoinment</a>
                                </li>

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <ul style="list-style: none;">
                                            <li class="nav-item">
                                                <a href="{{ route('profile.show') }}">Profile</a>
                                            </li>

                                            <li class="nav-item mr-2">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        Logout
                                                    </a>
                                                </form>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            @else
                                <li class="nav-item">
                                    <a class="btn btn-primary ml-lg-3" href="{{ route('login') }}">Login</a>
                                </li>

                                <li class="nav-item">
                                    <a class="btn btn-primary ml-lg-3" href="{{ route('register') }}">Register</a>
                                </li>

                            @endauth
                        @endif

                    </ul>
                </div> <!-- .navbar-collapse -->
            </div> <!-- .container -->
        </nav>
    </header>



    <div class="page-section">
        <div class="container">
            <h1 class="text-center wow fadeInUp">Make an Appointment</h1>

            <form class="main-form" action="{{ url('appoinment') }}" method="POST">
                @csrf
                <div class="row mt-5">
                    <div class="col-12 col-md-6 py-2 wow fadeInLeft">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Full name" value="">
                    </div>
                    <div class="col-12 col-md-6 py-2 wow fadeInRight">
                        <label for="email">Email Address</label>
                        <input type="text" id="email" class="form-control" placeholder="Email address.."
                            name="email">
                    </div>

                    <div class="col-12 col-md-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
                        <label for="timeSlot">Select Time Slot:</label>
                        <select class="form-control" id="timeSlots" name="timeSlots">
                            @if(count($doctors->timeSlots) > 0)
                                @foreach ($doctors->timeSlots as $slot)
                                    <option value="{{ $slot['from'] }} - {{ $slot['to'] }}">
                                        From: {{ $slot['from'] }} - To: {{ $slot['to'] }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" selected>No available time slots</option>
                            @endif
                        </select>
                    </div>
                    

                    <div class="col-12 col-md-6 py-2 wow fadeInRight" data-wow-delay="300ms">
                        <label for="timeSlot">Doctor:</label>


                            <select name="doctor" id="doctor" id="" class="form-control">
                                <option value="{{ $doctors->id }}" selected>{{ $doctors->name }}</option>
                            </select>

                    </div>

                    <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <label for="number">Phone Number</label>
                        <input type="text" id="number" class="form-control" placeholder="Number.."
                            name="number">
                    </div>

                    <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <label for="number">Fees</label>
                        <input type="number" id="fees" class="form-control" placeholder="Number.."
                            name="fees" value="{{ $doctors->fees }}" readonly>
                    </div>

                    <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <label for="message">Message</label>
                        <textarea id="message" class="form-control" rows="6" placeholder="Enter message.." name="message"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
            </form>
        </div>
    </div>

    <footer class="page-footer">
        <div class="container">
            <div class="row px-md-3">
                <div class="col-sm-6 col-lg-3 py-3">
                    <h5>Company</h5>
                    <ul class="footer-menu">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="#">Editorial Team</a></li>
                        <li><a href="#">Protection</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 py-3">
                    <h5>More</h5>
                    <ul class="footer-menu">
                        <li><a href="#">Terms & Condition</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Advertise</a></li>
                        <li><a href="#">Join as Doctors</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 py-3">
                    <h5>Our partner</h5>
                    <ul class="footer-menu">
                        <li><a href="#">Code Tree</a></li>
                        <li><a href="#">Popular</a></li>
                        <li><a href="#">Squre</a></li>
                        <li><a href="#">Lab Aid</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 py-3">
                    <h5>Contact</h5>
                    <p class="footer-link mt-2">Sector 7 uttara, Dhaka</p>
                    <a href="#" class="footer-link">01923343389</a>
                    <a href="#" class="footer-link">healthcare@gmail.com</a>

                    <h5 class="mt-3">Social Media</h5>
                    <div class="footer-sosmed mt-3">
                        <a href="#" target="_blank"><span class="mai-logo-facebook-f"></span></a>
                        <a href="#" target="_blank"><span class="mai-logo-twitter"></span></a>
                        <a href="#" target="_blank"><span class="mai-logo-google-plus-g"></span></a>
                        <a href="#" target="_blank"><span class="mai-logo-instagram"></span></a>
                        <a href="#" target="_blank"><span class="mai-logo-linkedin"></span></a>
                    </div>
                </div>
            </div>


        </div>
    </footer>

    <script src="../assets/js/jquery-3.5.1.min.js"></script>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

    <script src="../assets/vendor/wow/wow.min.js"></script>

    <script src="../assets/js/theme.js"></script>

</body>

</html>
