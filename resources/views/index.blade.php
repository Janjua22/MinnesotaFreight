@extends('layouts.master-site')

@section('styles')
<style>
    .style10{
        background: url({{ asset('site/images/banner/style10/banner.jpg') }});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 100px 0;
    }
    .banner-pane{
        padding: 55px;
        width: fit-content;
        background-color: rgba(0, 0, 0, 0.5);
        color: rgb(255, 255, 255) !important;
        text-shadow: 1px 1px 4px #363636;
        border-radius: 0.475rem;
    }
    .banner-pane > .title{
        font-size: 58px;
        line-height: 70px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 13px;
        letter-spacing: -3px;
    }
    .banner-pane > .sub-title{
        font-size: 22px;
        line-height: 25px;
        font-weight: 500;
        font-family: Roboto;
        color: #ffffff;
        display: inline-block;
        margin-bottom: 20px;
    }
    .banner-pane > .small-title{
        font-size: 22px;
        line-height: 30px;
        font-weight: 600;
        font-family: Poppins;
        color: #ffffff;
        margin-bottom: 0;
    }
    .banner-pane .readon{
        border-radius: 0.475rem;
    }
    .readon:hover{
        background-color: #8dd535;
    }
</style>
@endsection

@section('content')
<!-- Banner Start -->
<div class="rs-banner style10"> 
    <div class="container">
        <div class="banner-pane">
            <span class="sub-title">Trucking Made EASY!</span>
            <h1 class="title">From a few boxes <br> to full truckloads.</h1>
            <h3 class="small-title">Anywhere within the United States. Have Freight?</h3>
            <div class="btn-part mt-33">
                <a class="readon" href="{{ route('site.contact') }}">Get A Quote!</a>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Slider Start -->
{{-- <div id="rs-slider" class="rs-slider slider12">
    <div 
        class="rs-carousel owl-carousel" 
        data-loop="true" 
        data-items="1" 
        data-margin="30" 
        data-autoplay="true" 
        data-hoverpause="true" 
        data-autoplay-timeout="5000" 
        data-smart-speed="800" 
        data-dots="false" 
        data-nav="true" 
        data-nav-speed="false" 
        data-center-mode="false" 
        data-mobile-device="1" 
        data-mobile-device-nav="true" 
        data-mobile-device-dots="false" 
        data-ipad-device="1" 
        data-ipad-device-nav="true" 
        data-ipad-device-dots="false" 
        data-ipad-device2="1" 
        data-ipad-device-nav2="true" 
        data-ipad-device-dots2="false" 
        data-md-device="1" 
        data-lg-device="1" 
        data-md-device-nav="true" 
        data-md-device-dots="false"
    >
        <!-- Slide 1 -->
        <div class="slider slide1 txt-shadow">
            <div class="container">
                <div class="content-part">
                    <div class="slider-des">
                        <div class="sl-subtitle">Your Freight & Logistics Partner</div>
                        <h1 class="sl-title">Enjoy working with one of top companies in the industry</h1>
                    </div>
                    <div class="slider-bottom">
                        <ul>
                            <li><a href="{{ route('site.contact') }}" class="readon2 slide-quote">Get A Quote</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="slider slide2 txt-shadow">
            <div class="container">
                <div class="content-part">
                    <div class="slider-des">
                        <div class="sl-subtitle">IFTA Compliant</div>
                        <h1 class="sl-title">We Are Expert in Trucking Business</h1>
                    </div>
                    <div class="slider-bottom">
                        <ul>
                            <li><a href="{{ route('site.about') }}" class="readon2 slide-quote">Who We Are</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Slider End -->

<!-- Services Start -->
<div class="rs-services style17 pt-100 pb-100 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 md-mb-30">
                <div class="services-item">
                    <div class="services-img">
                        <img src="{{ asset('site/images/services/style12/1.jpg') }}" alt="images">
                    </div>
                    <div class="services-content">
                        <div class="services-title">
                            <h3 class="title">
                                <a href="services-single.html">Safety</a>
                            </h3>
                        </div>
                        <p class="services-txt">
                            Safety is our top priority throughout our organization. All our drivers, operating on the road, are highly
                            trained professionals. We personally train each driver to ensure they are always operating in
                            compliance. Each driver operates as if their family is traveling next to them as they operate. Our goal is
                            to safely deliver the freight to our customers and our fleet of drivers’ home every night to their families.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 md-mb-30">
                <div class="services-item">
                    <div class="services-img">
                        <img src="{{ asset('site/images/services/style12/2.jpg') }}" alt="images">
                    </div>
                    <div class="services-content">
                        <div class="services-title">
                            <h3 class="title">
                                <a href="services-single.html">Policy and Procedure</a>
                            </h3>
                        </div>
                        <p class="services-txt">
                            Each contractor and employee driver are required to attend orientation as a requirement to operate for
                            Minnesota Freight Express Trucking, Inc. Our orientation covers each Minnesota Freight Express
                            Operating Policy, FMCSA Regulation training, Hazardous Cargo Safe Transport with testing to ensure
                            their knowledge. Each driver is required meet FMCSA requirements to operate for Minnesota Freight
                            Express, Inc.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="services-item">
                    <div class="services-img">
                        <img src="{{ asset('site/images/services/style12/3.jpg') }}" alt="images">
                    </div>
                    <div class="services-content">
                        <div class="services-title">
                            <h3 class="title">
                                <a href="services-single.html">Bigger Network</a>
                            </h3>
                        </div>
                        <p class="services-txt">
                            Always aiming to exceed your expectations, we strive to respect deadlines while maximizing efficiency 
                            and reducing costs in the logistics supply chain. You can trust our proactive team, flexible service 
                            and our reliable, efficient network.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services End -->

<!-- Why Choose Section Start -->
<div class="rs-whychooseus bg33 pt-100 pb-100 md-pt-70 md-pb-70 txt-shadow">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 md-mb-50">
                <div class="content-wrap">
                    <div class="sec-title3 mb">
                        <span class="sub-title small">Why We Are best</span>
                        <h2 class="title title4 pb-20">Take a Look Our statistics</h2>
                        <div class="description">
                            <p class="white-color mb-40">As our business grew over the years, we have stayed at the forefront of technology.</p>
                        </div>
                    </div>
                    <a class="button-text" href="{{ route('site.contact') }}"><i class="fa fa-envelope-open"></i>
                        <span class="sub-text">Contact Us</span></a>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Counter Section Start -->
                <div class="rs-counter style1">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-80 md-mb-40">
                                <div class="couter-part plus">
                                    <div class="rs-count">150</div>
                                    <h5 class="title">Trucks</h5>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-80 md-mb-40">
                                <div class="couter-part plus">
                                    <div class="rs-count">50</div>
                                    <h5 class="title">Drivers</h5>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 md-mb-40">
                                <div class="couter-part plus">
                                    <div class="rs-count">100</div>
                                    <h5 class="title">Clients</h5>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="couter-part thousand">
                                    <div class="rs-count">6</div>
                                    <h5 class="title">Loads Delivered</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Counter Section End -->
            </div>
        </div>
    </div>
</div>
<!-- Why Choose Section End -->

<!-- About Section Start -->
<div class="rs-about style9 pt-100 pb-100 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row y-middle">
            <div class="col-lg-7 pr-73 md-pr-15 md-mb-50">
                <div class="sec-title4 mb-50 md-mb-35">
                    <span class="sub-title pb-15">About Us</span>
                    <h2 class="title pb-30 md-pb-20">We are {{ siteSetting('title') }}</h2>
                    <p class="desc">
                        Since 2012, {{ siteSetting('title') }} has been moving freight cross-country, relying on the most advanced technology, 
                        late-model trucks and trailers, and highly proficient and experienced drivers. We have implemented innovative 
                        business practices to stay ahead of industry demands and government regulations, and to ensure the highest 
                        quality service to our customers.
                    </p>
                </div>
                <div class="services-item mb-40">
                    <div class="services-icon">
                        <img src="{{ asset('site/images/services/style12/icons/choose/1.png') }}" alt="images">
                    </div>
                    <div class="services-text">
                        <div class="services-title">
                            <h3 class="title pb-8">
                                <a href="#">OUR MISSION</a>
                            </h3>
                        </div>
                        <p class="services-txt">It requires plenty of experience, ethics and technical knowledge to build a business like this. And we have the experience of what it truly takes. When we started this company, our mission was to make transportation easier and efficient for our customers as convenient as possible and we are already halfway there. We are extremely confident upon our services that you will be pleased with every bit of our services and this is sole aim we all work towards!</p>
                    </div>
                </div>
                <div class="services-item">
                    <div class="services-icon">
                        <img src="{{ asset('site/images/services/style12/icons/choose/2.png') }}" alt="images">
                    </div>
                    <div class="services-text">
                        <div class="services-title">
                            <h3 class="title pb-8">
                                <a href="#">OUR VISION</a>
                            </h3>
                        </div>
                        <p class="services-txt">Efficiency is one of the most essential element when it comes down to truck transportation services. The better the efficiency is, the better the communication with you and it often leads to a great service and quality work. We own the updated, state of art and most advanced equipment to avoid any dispute you might face. Our vision is a truck transportation service you won’t regret. Get in contact with us now!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="image-part">
                    <img src="{{ asset('site/images/about/about-14.png') }}" alt="images">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Section End -->
@endsection