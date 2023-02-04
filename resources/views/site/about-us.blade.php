@extends('layouts.master-site')

@section('content')
<!-- Breadcrumbs Section Start -->
<div class="rs-breadcrumbs bg-1">
    <div class="container">
        <div class="content-part text-center breadcrumbs-padding">
            <h1 class="breadcrumbs-title white-color mb-0 txt-shadow">About Us</h1>
        </div>
    </div>
</div>
<!-- Breadcrumbs Section End -->

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
                    <p class="desc mt-2">
                        As a family-owned long-haul trucking company, we have a fleet of late-model refrigerated trucks with the latest technology 
                        to move products throughout the continental United States. We also offer regional freight service, moving dry and 
                        refrigerated goods throughout the Midwest. {{ siteSetting('title') }} is our nationwide brokerage firm that matches customers who have 
                        freight needs with trucking companies that have available capacity.
                    </p>
                    <p class="desc mt-2">
                        Our drivers have always been the backbone of our business and we have some of the best in the business. They are experienced, safe 
                        and conscientious, offering nothing but the best service for our customers.
                    </p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="image-part">
                    <img src="{{ asset('site/images/about/about-14.png') }}" alt="images">
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
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
            </div>
            <div class="col">
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
        </div>
    </div>
</div>
<!-- About Section End -->
@endsection