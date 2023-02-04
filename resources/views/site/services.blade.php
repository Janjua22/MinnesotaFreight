@extends('layouts.master-site')

@section('content')
<!-- Breadcrumbs Section Start -->
<div class="rs-breadcrumbs bg-2">
    <div class="container">
        <div class="content-part text-center breadcrumbs-padding">
            <h1 class="breadcrumbs-title white-color mb-0 txt-shadow">Services</h1>
        </div>
    </div>
</div>
<!-- Breadcrumbs Section End -->

<!-- Services Section Start -->
<div class="rs-about style9 pt-100 pb-100 md-pt-70 md-pb-70">
    <div class="container">
        <div class="row y-middle">
            <div class="col-lg-7 pr-73 md-pr-15 md-mb-50">
                <div class="sec-title4 mb-50 md-mb-35">
                    <span class="sub-title pb-15">Our</span>
                    <h2 class="title pb-30 md-pb-20">Services</h2>
                    <div class="desc">
                        We understand the needs of our customer and act upon their request to provide prompt, courteous and cost effective service. 
                        We help you to move your shipments arranging for different type of equipments like Van, Reefer, Flatbed, Step-deck, etc. 
                        We engage in helping shippers find the best price with the best carrier for any given load.
                        <br><br>
                        Each client need is unique and we have the flexibility to negotiate rates with carriers on behalf of our clients.
                        <br><br>
                        We have a vast network and access to a library of freight carriers and search for the right availability based on customer 
                        specifications.  we determine the most cost-effective solution based on your transportation needs. We deal in LTL(Less than 
                        a truck load / Partial Load) , TL (Truckload / Full Truckload), Expedited load, Heavy Haul loads.
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="image-part">
                    <img src="{{ asset('site/images/about/about-13.png') }}" alt="images">
                </div>
            </div>
        </div>
    </div>
</div>
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
<!-- Services Section End -->
@endsection