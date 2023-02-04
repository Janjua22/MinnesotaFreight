<footer id="rs-footer" class="rs-footer mihmft">
    <div class="bg-wrap">
        <div class="container">
            <div class="footer-content pt-62 pb-40 md-pb-40 sm-pt-48">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 footer-widget md-mb-39">
                        <div class="about-widget pr-15">
                            <div class="logo-part">
                                <a href="{{ route('home') }}"><img src="{{ asset(Storage::url(siteSetting('logo_white'))) }}" alt="Footer Logo"></a>
                            </div>
                            <p class="desc">{{ siteSetting('about') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 md-mb-32 footer-widget">
                        <h4 class="widget-title">Contact Info</h4>
                        <ul class="address-widget pr-40">
                            <li>
                                <i class="flaticon-location"></i>
                                <div class="desc">{{ siteSetting('address') }}</div>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <div class="desc">
                                    <a href="tel:{{ siteSetting('contact') }}">{{ siteSetting('contact') }}</a>
                                </div>
                            </li>
                            <li>
                                <i class="flaticon-email"></i>
                                <div class="desc">
                                    <a href="mailto:{{ siteSetting('email') }}">{{ siteSetting('email') }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 md-mb-32 footer-widget">
                        <h4 class="widget-title">Helpful Links</h4>
                        <ul class="address-widget pr-40">
                            <li>
                                <div class="desc">
                                    <a href="{{ route('site.about') }}">About Us</a>
                                </div>
                            </li>
                            <li>
                                <div class="desc">
                                    <a href="{{ route('site.services') }}">Services</a>
                                </div>
                            </li>
                            <li>
                                <div class="desc">
                                    <a href="{{ route('site.apply') }}">Apply Now</a>
                                </div>
                            </li>
                            <li>
                                <div class="desc">
                                    <a href="{{ route('site.contact') }}">Contact Us</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row y-middle">
                    <div class="col-lg-6 col-md-8 sm-mb-21">
                        <div class="copyright">
                            <p>&copy; 2021 All Rights Reserved. Developed By <a href="http://iconictek.com/">Iconictek</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 text-right sm-text-center">
                        <ul class="footer-social">
                            <li><a href="{{ siteSetting('facebook') }}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ siteSetting('twitter') }}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{ siteSetting('linkedin') }}"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>