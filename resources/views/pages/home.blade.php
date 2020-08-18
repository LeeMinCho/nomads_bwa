@extends('layouts.app')

@section('title', 'NOMADS')

@section('content')
<!-- Header -->
<header class="text-center">
    <h1>
        Explore The Beautiful World<br>
        As Easy One Click
    </h1>
    <p class="mt-3">
        You will see beautiful<br>
        moment you never see before
    </p>
    <a href="#popular" class="btn btn-get-started px-4 mt-4">Get Started</a>
</header>

<main>
    <div class="container">
        <!-- Statistic -->
        <section class="section-stats row justify-content-center" id="stat">
            <div class="col-3 col-md-2 stats-detail">
                <h2>20K</h2>
                <p>Members</p>
            </div>
            <div class="col-3 col-md-2 stats-detail">
                <h2>12</h2>
                <p>Countries</p>
            </div>
            <div class="col-3 col-md-2 stats-detail">
                <h2>3K</h2>
                <p>Hotels</p>
            </div>
            <div class="col-3 col-md-2 stats-detail">
                <h2>72</h2>
                <p>Partners</p>
            </div>
        </section>

    </div>

    <!-- Popular -->
    <section class="section-popular" id="popular">
        <div class="container">
            <div class="row">
                <div class="col text-center section-popular-heading">
                    <h2>Wisata Popular</h2>
                    <p>Something that you never try<br>
                        before in this world</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section-popular-content" id="popular-content">
        <div class="container">
            @if ($items)
            <div id="carouselNomads" class="carousel section-popular-travel slide carousel-multi-item" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselNomads" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselNomads" data-slide-to="1"></li>
                    <li data-target="#carouselNomads" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                @foreach ($items as $item)
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-travel text-center d-flex flex-column" style="background-image: url('{{ $item->galleries->count() ? Storage::url($item->galleries->first()->image) : '' }}');">
                                    <div class="travel-country">{{ $item->location }}</div>
                                    <div class="travel-location">{{ $item->title }}</div>
                                    <div class="travel-button mt-auto">
                                        <a href="{{ route('detail', $item->slug) }}" class="btn btn-travel-details px-4">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselNomads" role="button" data-slide="prev">
                    <span class="fas fa-angle-left fa-3x" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselNomads" role="button" data-slide="next">
                    <span class="fas fa-angle-right fa-3x" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="text-center mt-3 mb-3">
                <a href="#" class="btn btn-more-travel">More Travel</a>
            </div>
            @else
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="first-card-travel text-center d-flex flex-column">
                    </div>
                </div>
            </div>    
            @endif
        </div>
    </section>

    <!-- Networks -->
    <section class="section-networks">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Our Networks</h2>
                    <p>Companies are trusted us<br>
                        more than just a trip</p>
                </div>
                <div class="col-md-8 text-center">
                    <img src="frontend/images/Partner.png" alt="" class="img-partner">
                </div>
            </div>
        </div>
    </section>


    <!-- Testimonial -->
    <section class="section-testimonial-heading" id="testimonial-heading">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>They’re Loving Us</h2>
                    <p>Moments are giving them<br>
                        the best experience</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-testimonial-content" id="testimonial-content">
        <div class="container">
            <div class="section-popular-travel row justify-content-center">
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="frontend/images/Testimonial-1.png" alt="User" class="mb-4 rounded-circle">
                            <h3>Eka Yunan</h3>
                            <p class="testimonial">
                                “It was glorious and I could not to stop to say wohoo for every single moment
                                Dankeeeee”
                            </p>
                            <hr>
                            <p class="trip-to mt-2">
                                Trip to Ubud, Bali
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="frontend/images/Testimonial-2.png" alt="User" class="mb-4 rounded-circle">
                            <h3>Ada Wong</h3>
                            <p class="testimonial">
                                “It was glorious and I could not to stop to say wohoo for every single moment
                                Dankeeeee”
                            </p>
                            <hr>
                            <p class="trip-to mt-2">
                                Trip to Ubud, Bali
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="frontend/images/Testimonial-3.png" alt="User" class="mb-4 rounded-circle">
                            <h3>Geiz</h3>
                            <p class="testimonial">
                                “It was glorious and I could not to stop to say wohoo for every single moment
                                Dankeeeee”
                            </p>
                            <hr>
                            <p class="trip-to mt-2">
                                Trip to Ubud, Bali
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="#" class="btn btn-need-help px-4 mt-4 mx-1">
                        I Need Help
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-get-started px-4 mt-4 mx-1">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('addon-style')
    <link rel="stylesheet" href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}">
@endpush

@push('addon-script')
    <script>
        document.querySelectorAll("a[href^='#']").forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    timer: 2500
                });
            });
        });
    </script>
@endpush