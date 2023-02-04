<div class="full-width-header header-style-4"> <!-- header-style2 modify4 -->
    <!-- Toolbar Start -->
    <div class="toolbar-area hidden-md">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="toolbar-contact">
                        <ul>
                            <li class="border-right"><i class="flaticon-call"></i><a href="tel:{{ siteSetting('contact') }}">{{ siteSetting('contact') }}</a></li>
                            <li><i class="flaticon-email"></i><a href="mailto:{{ siteSetting('email') }}">{{ siteSetting('email') }}</a></li>
                            {{-- <li class="opening">Your Trusted 24 Hours Service Provider!</li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="toolbar-sl-share">
                        <ul>
                            <li><a href="{{ siteSetting('facebook') }}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ siteSetting('twitter') }}"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toolbar End -->
    
    <!--Header Start-->
    <header id="rs-header" class="rs-header">
        <!-- Menu Start -->
        <div class="menu-area menu-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="logo-area">
                            <a href="{{ route('home') }}"><img src="{{ asset(Storage::url(siteSetting('logo'))) }}" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-9 text-right">
                        <div class="rs-menu-area">
                            <div class="main-menu">
                                <div class="mobile-menu">
                                    <a class="rs-menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>
                                <nav class="rs-menu">
                                    <ul id="onepage-menu" class="nav-menu">
                                        <li @if(url()->current() == route('home')) class="current-menu-item" @endif><a href="{{ route('home') }}">Home</a></li>
                                        <li @if(url()->current() == route('site.about')) class="current-menu-item" @endif><a href="{{ route('site.about') }}">About Us</a></li>
                                        <li @if(url()->current() == route('site.services')) class="current-menu-item" @endif><a href="{{ route('site.services') }}">Services</a></li>
                                        <li @if(url()->current() == route('site.apply')) class="current-menu-item" @endif><a href="{{ route('site.apply') }}">Apply Now</a></li>
                                        <li @if(url()->current() == route('site.contact')) class="current-menu-item" @endif><a href="{{ route('site.contact') }}">Contact Us</a></li>
                                    </ul> <!-- //.nav-menu -->
                                </nav>
                            </div> <!-- //.main-menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->
    </header>
    <!--Header End-->
</div>