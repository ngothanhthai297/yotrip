@extends('layouts.app')
@section('content')
@if(isset($banner))
@php 
    $photo = $banner->photo;
@endphp
<div class="hero-wrap ftco-degree-bg" style="background-image: url('public/backend/uploads/images/banners/<?= $photo ?>');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
            <div class="col-lg-8 ftco-animate">
                <div class="text w-100 text-center mb-md-5 pb-md-5">
                    <h1 class="mb-4">{{$banner->title}}</h1>
                    <p style="font-size: 18px;">{!!$banner->description!!}</p>
                    <a href="https://vimeo.com/45830194"
                        class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="ion-ios-play"></span>
                        </div>
                        <div class="heading-title ml-5">
                            <span>Easy steps for renting a car</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="hero-wrap ftco-degree-bg" style="background-image: url('public/ui/images/bg_1.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
            <div class="col-lg-8 ftco-animate">
                <div class="text w-100 text-center mb-md-5 pb-md-5">
                    <h1 class="mb-4">Fast &amp; Easy Way To Rent A Car</h1>
                    <p style="font-size: 18px;">A small river named Duden flows by their place and supplies it with the
                        necessary regelialia. It is a paradisematic country, in which roasted parts</p>
                    <a href="https://vimeo.com/45830194"
                        class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="ion-ios-play"></span>
                        </div>
                        <div class="heading-title ml-5">
                            <span>Easy steps for renting a car</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Booking Start-->
@include('partials.booking')
<!-- Booking End -->

<!-- Feature Start -->
@include('partials.feature')
<!-- Feature End -->

<!-- About Start -->
@include('partials.about-us')
<!-- About End -->



<!-- Location Start-->
@include('partials.location')
<!-- Location End-->

<!-- Book car Start -->
@include('partials.list-cars')
<!-- Book car End -->


<!-- Our last services Start-->
@include('partials.server')
<!-- Our last services End-->

<!-- Newspaper Start -->
@include('partials.newspaper')
<!-- Newspaper End -->

<!-- Download Start-->
<section class="ftco-section banner bg-1" id="home">
    <div class="overflow"></div>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Booking</span>
                <h3 class="mb-3" style="font-weight: 600;">Download the free CarBook App</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <!-- Contents -->
                <div class="content-block">
                    <h5>For faster, easier booking and evclusive deals</h5>
                    <!-- App Badge -->
                    <div class="app-badge">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="#" class=" btn-download"><i class="fa fa-android" aria-hidden="true"></i>
                                    <div>Get it on the<span>GOOGLE PLAY</span></div>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class=" btn-download"><i class="fa fa-apple" aria-hidden="true"></i>
                                    <div>Available on the<span>Apple store</span></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
          <div class="image-block">
            <img class="img-fluid phone-thumb" src="images/iphone-banner.png" alt="iphone-banner">
          </div>
        </div> -->
        </div>
    </div>
</section>
<!-- Download End-->

<!--Partner Start-->
<section id="partner" class="ftco-section">
    <div class="container">
        <h3>Our Partners/ Our Clients</h3>
        <section class="customer-logos slider">
            <div class="slide"><img
                    src="https://images02.nicepage.com/a1389d7bc73adea1e1c1fb7e/f152870f5c9d5ab28268fb89/2.png"></div>
            <div class="slide"><img
                    src="https://images02.nicepage.com/a1389d7bc73adea1e1c1fb7e/b26eaa96084b5d63a1b8d98d/5.png"></div>
            <div class="slide"><img src="https://image.freepik.com/free-vector/abstract-cross-logo_23-2147536124.jpg">
            </div>
            <div class="slide"><img src="https://image.freepik.com/free-vector/football-logo-background_1195-244.jpg">
            </div>
            <div class="slide"><img
                    src="https://image.freepik.com/free-vector/background-of-spots-halftone_1035-3847.jpg"></div>
            <div class="slide"><img
                    src="https://image.freepik.com/free-vector/retro-label-on-rustic-background_82147503374.jpg"></div>
            <div class="slide"><img src="https://image.freepik.com/free-vector/football-logo-background_1195-244.jpg">
            </div>
        </section>
        <h2>
    </div>
</section>
<!--Partner End-->
<script src="{{asset('public/ui/js/js.js')}}"></script>
<!-- Total Start -->
@include('partials.total')
<!-- Total Start -->

<!-- Footer -->
@include('partials.footer')

@endsection