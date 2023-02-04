@extends('layouts.master-site')

@section('content')
<!-- Breadcrumbs Section Start -->
<div class="rs-breadcrumbs bg-4">
    <div class="container">
        <div class="content-part text-center breadcrumbs-padding">
            <h1 class="breadcrumbs-title white-color mb-0 txt-shadow">Contact Us</h1>
        </div>
    </div>
</div>
<!-- Breadcrumbs Section End -->

<!-- Contact Section Start -->
<div id="rs-contact" class="rs-contact style1 inner">
    <div class="pt-100 pb-100 md-pt-80 md-pb-80">
        <div class="container">
            <div class="content-info-part mb-60">
                <div class="row gutter-16">
                    <div class="col-lg-4 md-mb-30">
                        <div class="info-item h-100">
                            <div class="icon-part">
                                <i class="fa fa-at"></i>
                            </div>
                            <div class="content-part">
                                <h4 class="title">Phone Number</h4>
                                <a href="tel:{{ siteSetting('contact') }}">{{ siteSetting('contact') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 md-mb-30">
                        <div class="info-item h-100">
                            <div class="icon-part">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="content-part">
                                <h4 class="title">Email Address</h4>
                                <a href="mailto:{{ siteSetting('email') }}">{{ siteSetting('email') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="info-item h-100">
                            <div class="icon-part">
                                <i class="fa fa-map-o"></i>
                            </div>
                            <div class="content-part">
                                <h4 class="title">Office Address</h4>
                                <p>{{ siteSetting('address') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-part">
                <div class="row md-col-padding">
                    <div class="col-md-5 custom1 pr-0">
                        <div class="img-part" style="border-radius: 0.475rem 0 0 0.475rem;"></div>
                    </div>
                    <div class="col-md-7 custom2 pl-0">
                        <div id="form-messages"></div>
                        <form action="{{ route('site.contact.create') }}" method="POST" id="contact-form" class="contact-form" style="border-radius: 0 0.475rem 0.475rem 0;">
                            @csrf
                            
                            <div class="sec-title mb-53 md-mb-42">
                                <div class="sub-title white-color">Let's Talk</div>
                                <h2 class="title white-color mb-0">Get In Touch</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-30">
                                    <div class="common-control form-group mb-0">
                                        <input type="text" name="name" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-30">
                                    <div class="common-control form-group mb-0">
                                        <input type="email" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-30">
                                    <div class="common-control form-group mb-0">
                                        <input type="text" name="phone" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-30">
                                    <div class="common-control form-group mb-0">
                                        <input type="text" name="subject" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-30">
                                    <div class="common-control form-group mb-0">
                                        <textarea name="message" placeholder="Your Message Here" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="submit-btn form-group mb-0">
                                        <button type="submit" class="readon">Submit Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Section End -->
@endsection