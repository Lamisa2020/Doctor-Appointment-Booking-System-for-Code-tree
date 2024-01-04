<div class="page-section">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp">Our Doctors</h1>

        <div class="owl-carousel wow fadeInUp" id="doctorSlideshow">
            @foreach ($doctors as $doctors)
                <div class="item">
                    <div class="card-doctor">
                        <div class="header">
                            <img src="doctorimage/{{ $doctors->image }}" alt="">
                            <div class="meta">
                                <a href="#"><span class="mai-call"></span></a>
                                <a href="#"><span class="mai-logo-whatsapp"></span></a>
                            </div>
                        </div>
                        <div class="body">
                            <p class="text-xl mb-0">{{ $doctors->name }}</p>
                            <div>
                                <span class="text-sm text-grey">{{ $doctors->speciality }}</span>
                                <a href="{{ url('appoint', $doctors->id) }}"
                                    class="btn btn-outline-primary btn-sm">Appoint</a>

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
