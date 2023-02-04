@extends('layouts.admin.master')
@section('styles')
<style>
    td{
        white-space: normal !important;
    }
    .nav-item .nav-link, .nav-tabs .nav-link{
        -webkit-transition: all 300ms ease 0s;
        -moz-transition: all 300ms ease 0s;
        -o-transition: all 300ms ease 0s;
        -ms-transition: all 300ms ease 0s;
        transition: all 300ms ease 0s;
    }
    .card a{
        -webkit-transition: all 150ms ease 0s;
        -moz-transition: all 150ms ease 0s;
        -o-transition: all 150ms ease 0s;
        -ms-transition: all 150ms ease 0s;
        transition: all 150ms ease 0s;
    }
    [data-toggle="collapse"][data-parent="#accordion"] i{
        -webkit-transition: transform 150ms ease 0s;
        -moz-transition: transform 150ms ease 0s;
        -o-transition: transform 150ms ease 0s;
        -ms-transition: all 150ms ease 0s;
        transition: transform 150ms ease 0s;
    }
    [data-toggle="collapse"][data-parent="#accordion"][aria-expanded="true"] i{
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .now-ui-icons {
        display: inline-block;
        font: normal normal normal 14px/1 'Nucleo Outline';
        font-size: inherit;
        speak: none;
        text-transform: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    @-webkit-keyframes nc-icon-spin{
        0%{
            -webkit-transform: rotate(0deg);
        }
        100%{
            -webkit-transform: rotate(360deg);
        }
    }
    @-moz-keyframes nc-icon-spin{
        0%{
            -moz-transform: rotate(0deg);
        }
        100%{
            -moz-transform: rotate(360deg);
        }
    }

    @keyframes nc-icon-spin{
        0%{
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100%{
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    .now-ui-icons.loader_gear:before{
        content: "\ea4e";
    }
    .now-ui-icons.location_pin:before{
        content: "\ea47";
    }
    .now-ui-icons.objects_globe:before{
        content: "\ea2f";
    }
    .now-ui-icons.ui-2_settings-90:before{
        content: "\ea4b";
    }
    .nav-tabs{
        border: 0;
        padding: 15px 0.7rem;
    }
    .nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active{
        box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
    }
    .card .nav-tabs{
        border-top-right-radius: 0.1875rem;
        border-top-left-radius: 0.1875rem;
    }
    .nav-tabs>.nav-item>.nav-link{
        color: #888888;
        margin: 0;
        margin-right: 5px;
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 30px;
        font-size: 14px;
        padding: 11px 23px;
        line-height: 1.5;
    }
    .nav-tabs>.nav-item>.nav-link:hover{
        background-color: transparent;
    }
    .nav-tabs>.nav-item>.nav-link.active{
        background-color: #1e1e2d !important;
        border-radius: 30px;
        color: #FFFFFF;
    }
    .nav-tabs>.nav-item>.nav-link i.now-ui-icons{
        font-size: 14px;
        position: relative;
        top: 1px;
        margin-right: 3px;
    }
    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link{
        color: #FFFFFF;
    }
    .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active{
        background-color: rgba(255, 255, 255, 0.2);
        color: #FFFFFF;
    }
    .card{
        border: 0;
        border-radius: 0.1875rem;
        display: inline-block;
        position: relative;
        width: 100%;
        margin-bottom: 30px;
        box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
    }
    .card .card-header{
        background-color: transparent;
        border-bottom: 0;
        background-color: transparent;
        border-radius: 0;
        padding: 0;
    }
    .card[data-background-color="orange"]{
        background-color: #f96332;
    }
    .card[data-background-color="red"]{
        background-color: #FF3636;
    }
    .card[data-background-color="yellow"]{
        background-color: #FFB236;
    }
    .card[data-background-color="blue"]{
        background-color: #2CA8FF;
    }
    .card[data-background-color="green"]{
        background-color: #15b60d;
    }
    [data-background-color="orange"]{
        background-color: #e95e38;
    }
    [data-background-color="black"]{
        background-color: #2c2c2c;
    }
    [data-background-color]:not([data-background-color="gray"]){
        color: #FFFFFF;
    }
    [data-background-color]:not([data-background-color="gray"]) p{
        color: #FFFFFF;
    }
    [data-background-color]:not([data-background-color="gray"]) a:not(.btn):not(.dropdown-item){
        color: #FFFFFF;
    }
    [data-background-color]:not([data-background-color="gray"]) .nav-tabs>.nav-item>.nav-link i.now-ui-icons{
        color: #FFFFFF;
    }
    @font-face{
        font-family: 'Nucleo Outline';
        src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot");
        src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot") format("embedded-opentype");
        src: url("https://raw.githack.com/creativetimofficial/now-ui-kit/master/assets/fonts/nucleo-outline.woff2");
        font-weight: normal;
        font-style: normal;
    }
    .now-ui-icons{
        display: inline-block;
        font: normal normal normal 14px/1 'Nucleo Outline';
        font-size: inherit;
        speak: none;
        text-transform: none;
        /* Better Font Rendering */
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    footer{
        margin-top:50px;
        color: #555;
        background: #fff;
        padding: 25px;
        font-weight: 300;
        background: #f7f7f7;
        
    }
    .footer p{
        margin-bottom: 0;
    }
    footer p a{
        color: #555;
        font-weight: 400;
    }
    footer p a:hover{
        color: #e86c42;
    }
    @media screen and (max-width: 768px){
        .nav-tabs{
            display: inline-block;
            width: 100%;
            padding-left: 100px;
            padding-right: 100px;
            text-align: center;
        }
        .nav-tabs .nav-item>.nav-link{
            margin-bottom: 5px;
        }
    }
    .fileupload input.upload{
        cursor: pointer;
        filter: alpha(opacity=0);
        font-size: 20px;
        margin: 0;
        opacity: 0;
        padding: 0;
        position: absolute;
        right: 0;
        top: 0;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Site",
        'sub-title' => "Settings",
        'btn' => '',
        'url' => '',
    ];
@endphp

@include('admin.components.top-bar', $titles)
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        @include('admin.components.alerts')
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header d-flex justify-content-center">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                            <i class="bi bi-house-door fs-3 text-danger"></i> Home
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                            <i class="bi bi-globe2 fs-3 text-danger"></i> Social
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer" type="button" role="tab" aria-controls="footer" aria-selected="false">
                            <i class="bi bi-pin-map fs-3 text-danger"></i> Footer
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification" type="button" role="tab" aria-controls="notification" aria-selected="false">
                            <i class="bi bi-bell fs-3 text-danger"></i> Notifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="key-tab" data-bs-toggle="tab" data-bs-target="#key" type="button" role="tab" aria-controls="key" aria-selected="false">
                            <i class="bi bi-key fs-3 text-danger"></i> Keys
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="customize-tab" data-bs-toggle="tab" data-bs-target="#customize" type="button" role="tab" aria-controls="customize" aria-selected="false">
                            <i class="bi bi-card-heading fs-3 text-danger"></i> Customize
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button" role="tab" aria-controls="theme" aria-selected="false">
                            <i class="bi bi-palette fs-3 text-danger"></i> Colors
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="layout-tab" data-bs-toggle="tab" data-bs-target="#layout" type="button" role="tab" aria-controls="layout" aria-selected="false">
                            <i class="bi bi-grid-1x2 fs-3 text-danger"></i> Layout
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab" aria-controls="form" aria-selected="false">
                            <i class="bi bi-ui-radios fs-3 text-danger"></i> System
                        </button>
                    </li>
                </ul>
            </div>

            <form action="{{route('admin.site-settings.update')}}" class="form mb-15 fv-plugins-bootstrap5 fv-plugins-framework" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="mb-3">
                        <!-- Tab panes -->
                        <div class="tab-content text-start">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Title </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="title" class=" @error('title') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title" value="{{$settings['title']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Factoring Fee(%) </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="factoring" class=" @error('factoring') is-invalid border-danger @enderror form-control form-control-solid" placeholder="factoring fee" value="{{$settings['factoring']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Start Invoice Serial Numbers From</label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="number" name="invoice_start" class=" @error('factoring') is-invalid border-danger @enderror form-control form-control-solid" placeholder="Start Invoice Serial Numbers From" value="{{$settings['invoice_start']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Default Factoring Company</label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <select name="default_factoring" class="form-control form-select form-select-solid @error('default_factoring') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Factoring Company" required>
                                                <option value="">Select Factoring Company</option>
                                                @foreach($factoringCompanies as $company)
                                                <option value="{{ $company->id }}" @if($settings['default_factoring'] == $company->id) selected @endif>{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row mb-5">
                                        <div class="col-md-2 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Logo </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            <input type="hidden" name="hidden_logo" class="form-control form-control-solid" placeholder="title" value="{{$settings['logo']}}" maxlength="500">
                                            <img src="{{ asset(Storage::url($settings['logo'])) }}" alt="image" class="img-thumbnail bg-light"
                                            >
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                                <div class=" @error('logo') is-invalid border-danger @enderror  btn btn-danger btn-rounded waves-effect waves-light" onclick="$('#logo')[0].click();"><span><i class="ion-upload m-r-5"></i>Upload Image</span>
                                                    <input type="file" name="logo" class="upload" id="logo" style="width: 100% !important;display:none" > </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-2 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Logo White </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            <input type="hidden" name="hidden_logo_white" class="form-control form-control-solid" placeholder="title" value="{{$settings['logo_white']}}" maxlength="100" >
                                            <img src="{{ asset(Storage::url($settings['logo_white'])) }}" alt="image" class="img-thumbnail bg-light">
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <div class=" @error('logo_white') is-invalid border-danger @enderror  btn btn-danger btn-rounded waves-effect waves-light"   onclick="$('#logo_white')[0].click();"><span><i class="ion-upload m-r-5"></i>Upload Image</span>
                                                <input type="file" name="logo_white" class="upload" id="logo_white" style="width: 100% !important;display:none" > 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-2 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Authentication Background</label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            <input type="hidden" name="hidden_auth_bg" class="form-control form-control-solid" placeholder="title" value="{{$settings['auth_bg']}}" maxlength="100" >
                                            <img src="{{ asset(Storage::url($settings['auth_bg'])) }}" alt="image" class="img-thumbnail bg-light"
                                            >
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                                <div class=" @error('auth_bg') is-invalid border-danger @enderror  btn btn-danger btn-rounded waves-effect waves-light"   onclick="$('#auth_bg')[0].click();"><span><i class="ion-upload m-r-5"></i>Upload Image</span>
                                                    <input type="file" name="auth_bg" class="upload" id="auth_bg" style="width: 100% !important;display:none" > 
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-2 m-b-20">
                                            <label class="pb-2   fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Authentication Text Background </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            <input type="hidden" name="hidden_auth_text_bg" class="form-control form-control-solid" placeholder="title" value="{{$settings['auth_text_bg']}}" maxlength="100" >
                                            <img src="{{ asset(Storage::url($settings['auth_text_bg'])) }}" alt="image" class="img-thumbnail bg-light"
                                            >
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                                <div class=" @error('auth_text_bg') is-invalid border-danger @enderror  btn btn-danger btn-rounded waves-effect waves-light"   onclick="$('#auth_text_bg')[0].click();"><span><i class="ion-upload m-r-5"></i>Upload Image</span>
                                                    <input type="file" name="auth_text_bg" class="upload" id="auth_text_bg" style="width: 100% !important;display:none" > 
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="social" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Facebook </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="facebook" class=" @error('facebook') is-invalid border-danger @enderror form-control form-control-solid" placeholder="https://facebook.com" value="{{$settings['facebook']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Instagram </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="instagram" class=" @error('instagram') is-invalid border-danger @enderror form-control form-control-solid" placeholder="https://instagram.com" value="{{$settings['instagram']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Twitter </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="twitter" class=" @error('twitter') is-invalid border-danger @enderror form-control form-control-solid" placeholder="https://twitter.com" value="{{$settings['twitter']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Youtube </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="youtube" class=" @error('youtube') is-invalid border-danger @enderror form-control form-control-solid" placeholder="https://youtube.com" value="{{$settings['youtube']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">LinkedIn </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="linkedin" class=" @error('linkedin') is-invalid border-danger @enderror form-control form-control-solid" placeholder="https://linkedin.com" value="{{$settings['linkedin']}}" maxlength="100" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="footer" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">About </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="about" class=" @error('about') is-invalid border-danger @enderror form-control form-control-solid" placeholder="About your company..." value="{{$settings['about']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Address </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="address" class=" @error('address') is-invalid border-danger @enderror form-control form-control-solid" placeholder="abc apt#123 , MN , USA" value="{{$settings['address']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Contact </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="contact" class=" @error('contact') is-invalid border-danger @enderror form-control form-control-solid" placeholder="+631 1234567" value="{{$settings['contact']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Email </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="email" name="email" class=" @error('email') is-invalid border-danger @enderror form-control form-control-solid" placeholder="youth@gmail.com" value="{{$settings['email']}}" maxlength="100" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="notification" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Receive email when someone submit contact form ? </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            
                                            <div class="w-20  p-4 bd-highlight">
                                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                    <input class="mx-auto form-check-input h-20px w-30px " type="checkbox"  name="contact_form_email" @if($settings['contact_form_email'] == 1) checked @endif    value="1" id="contact_form_email">
                                                    <label class="form-check-label" for="contact_form_email"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="key" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Google Map Api </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="map_key" class=" @error('map_key') is-invalid border-danger @enderror form-control form-control-solid" placeholder="1lgWQED21_sawe@dasda9232SRF32dqwwd_wd!" value="{{$settings['map_key']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Pusher App ID </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PUSHER_APP_ID" class=" @error('PUSHER_APP_ID') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PUSHER_APP_ID" value="{{$settings['PUSHER_APP_ID']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Pusher App KEY </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PUSHER_APP_KEY" class=" @error('PUSHER_APP_KEY') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PUSHER_APP_KEY" value="{{$settings['PUSHER_APP_KEY']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Pusher App SECRET </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PUSHER_APP_SECRET" class=" @error('PUSHER_APP_SECRET') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PUSHER_APP_SECRET" value="{{$settings['PUSHER_APP_SECRET']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Pusher App CLUSTER </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PUSHER_APP_CLUSTER" class=" @error('PUSHER_APP_CLUSTER') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PUSHER_APP_CLUSTER" value="{{$settings['PUSHER_APP_CLUSTER']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Paypal Client ID </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PAYPAL_CLIENT_ID" class=" @error('PAYPAL_CLIENT_ID') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PAYPAL_CLIENT_ID" value="{{$settings['PAYPAL_CLIENT_ID']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Paypal Client ID </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PAYPAL_SECRET" class=" @error('PAYPAL_SECRET') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PAYPAL_SECRET" value="{{$settings['PAYPAL_SECRET']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Paypal Client ID </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="PAYPAL_MODE" class=" @error('PAYPAL_MODE') is-invalid border-danger @enderror form-control form-control-solid" placeholder="PAYPAL_MODE" value="{{$settings['PAYPAL_MODE']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Voyanage Api ID </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="VOYANAGE_APP_KEY" class=" @error('VOYANAGE_APP_KEY') is-invalid border-danger @enderror form-control form-control-solid" placeholder="VOYANAGE_APP_KEY" value="{{$settings['VOYANAGE_APP_KEY']}}" maxlength="100" >
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Voyanage Api KEY </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <input type="text" name="VOYANAGE_API_KEY" class=" @error('VOYANAGE_API_KEY') is-invalid border-danger @enderror form-control form-control-solid" placeholder="VOYANAGE_API_KEY" value="{{$settings['VOYANAGE_API_KEY']}}" maxlength="100" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="customize" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Header (For custom css & js in header) </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <textarea name="custom_header" rows="5"  class="form-control  form-control-solid w-100"> {{siteSetting('custom_header')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Footer (For custom css & js in footer) </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <textarea name="custom_footer" rows="5"  class="form-control  form-control-solid w-100">  {{siteSetting('custom_footer')}} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="theme" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Class </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Color </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Light </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Hover </label>
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <label class="pb-2   fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Preview </label>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Primary 
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are #009EF7 ,  #ECF8FF and #0095E8 respectively"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="primary" class=" float-start @error('primary') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#009EF7" value="{{$settings['primary']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="primary_light" class=" float-start @error('primary_light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#" value="{{$settings['primary_light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="primary_active" class=" float-start @error('primary_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#0095E8" value="{{$settings['primary_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-primary">Primary</button>
                                                </div>
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-end btn btn-light-primary">Primary Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Secondary
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are    #E4E6EF and #0095E8 respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="secondary" class=" float-start @error('secondary') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#E4E6EF" value="{{$settings['secondary']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="secondary_active" class=" float-start @error('secondary_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#0095E8" value="{{$settings['secondary_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-12 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-secondary">Secondary</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Success
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are #50CD89 ,  #E8FFF3 and #47BE7D respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="success" class=" float-start @error('success') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#50CD89" value="{{$settings['success']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="success_light" class=" float-start @error('success_light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#E8FFF3" value="{{$settings['success_light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="success_active" class=" float-start @error('success_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#47BE7D" value="{{$settings['success_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-success">Success</button>
                                                </div>
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-end btn btn-light-success">Success Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Info
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are #7239EA ,  #5014D0 and #7239EA respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="info" class=" float-start @error('info') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#7239EA" value="{{$settings['info']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="info_light" class=" float-start @error('info_light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#5014D0" value="{{$settings['info_light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="info_active" class=" float-start @error('info_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#7239EA" value="{{$settings['info_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-info">Info</button>
                                                </div>
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-end btn btn-light-info">Info Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Warning
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are #FFC700 ,  #FFF8DD and #F1BC00 respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="warning" class=" float-start @error('warning') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#FFC700" value="{{$settings['warning']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="warning_light" class=" float-start @error('warning_light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#FFF8DD" value="{{$settings['warning_light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="warning_active" class=" float-start @error('warning_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#F1BC00" value="{{$settings['warning_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-warning">Warning</button>
                                                </div>
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-end btn btn-light-warning">Warning Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Danger
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are #F1416C ,  #FFF5F8 and #D9214E respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="danger" class=" float-start @error('danger') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#F1416C" value="{{$settings['danger']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="danger_light" class=" float-start @error('danger_light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#FFF5F8" value="{{$settings['danger_light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="danger_active" class=" float-start @error('danger_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#D9214E" value="{{$settings['danger_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-danger">Danger</button>
                                                </div>
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-end btn btn-light-danger">Danger Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Light
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are  #F5F8FA and #F5F8FA respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="light" class=" float-start @error('light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#F5F8FA" value="{{$settings['light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="light_active" class=" float-start @error('light_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#F5F8FA" value="{{$settings['light_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-12 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-light">Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Dark
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors are #181C32 ,  #EFF2F5 and #131628 respectively"></i> </label>
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="dark" class=" float-start @error('dark') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#181C32" value="{{$settings['dark']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="dark_light" class=" float-start @error('dark_light') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#EFF2F5" value="{{$settings['dark_light']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-1 m-b-20">
                                            <input type="color" name="dark_active" class=" float-start @error('dark_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#131628" value="{{$settings['dark_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-start btn btn-dark">Dark</button>
                                                </div>
                                                <div class="col-md-6 d-grid  ">
                                                    <button type="button" class=" float-end btn btn-light-dark">Dark Light</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="tab-pane" id="layout" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Background </label>
                                        </div>
                                        <div class="col-md-2 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Color </label>
                                        </div>
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-end  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Preview </label>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Logo 
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors is #1a1a27  "></i></label>
                                        </div>
                                        <div class="col-md-2 m-b-20">
                                            <input type="color" name="logo_background" class=" float-start @error('logo_background') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#1a1a27" value="{{$settings['logo_background']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-5 m-b-20">
                                            <span class="svg-icon svg-icon-2tx svg-icon-logo float-end">
                                                {!! getSvg('lay007') !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Header 
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors is #1e1e2d"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-2 m-b-20">
                                            <input type="color" name="header_background" class=" float-start @error('header_background') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#1e1e2d" value="{{$settings['header_background']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-5 m-b-20">
                                            <span class="svg-icon svg-icon-2tx svg-icon-header float-end">
                                                {!! getSvg('lay010') !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Sidebar 
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors is #1e1e2d"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-2 m-b-20">
                                            <input type="color" name="sidebar_background" class=" float-start @error('sidebar_background') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#1e1e2d" value="{{$settings['sidebar_background']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-5 m-b-20">
                                            <span class="svg-icon svg-icon-2tx svg-icon-sidebar float-end">
                                                {!! getSvg('lay004') !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Sidebar Active 
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Default colors is #DB1430  "></i></label>
                                        </div>
                                        <div class="col-md-2 m-b-20">
                                            <input type="color" name="sidebar_active" class=" float-start @error('sidebar_active') is-invalid border-danger @enderror form-control form-control-solid p-2" style="height:50px" placeholder="#DB1430" value="{{$settings['sidebar_active']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-5 m-b-20">
                                            <span class="svg-icon svg-icon-2tx svg-icon-sidebar-active float-end">
                                                {!! getSvg('lay001') !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="form" role="tabpanel">
                                <div class="col-12">
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> System </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Enable? </label>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Users's can login ? </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            
                                            <div class="w-20  p-4 bd-highlight">
                                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                    <input class="mx-auto form-check-input h-20px w-30px " type="checkbox"  name="login" @if($settings['login'] == 1) checked @endif    value="1" id="login">
                                                    <label class="form-check-label" for="login"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Users's can register ? </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            
                                            <div class="w-20  p-4 bd-highlight">
                                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                    <input class="mx-auto form-check-input h-20px w-30px " type="checkbox"  name="register" @if($settings['register'] == 1) checked @endif    value="1" id="register">
                                                    <label class="form-check-label" for="register"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Users's can reset their password ( Forgot password ) ? </label>
                                        </div>
                                        <div class="col-md-7 m-b-20">
                                            
                                            <div class="w-20  p-4 bd-highlight">
                                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                    <input class="mx-auto form-check-input h-20px w-30px " type="checkbox"  name="reset" @if($settings['reset'] == 1) checked @endif    value="1" id="reset">
                                                    <label class="form-check-label" for="reset"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Error </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Title </label>
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            <label class="pb-2 float-start  fs-3 fw-bolder mb-2" style="font-size:15px; font-weight: 400;"> Message </label>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 401 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_401" class=" @error('title_401') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_401" value="{{$settings['title_401']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_401" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_401')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 403 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_403" class=" @error('title_403') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_403" value="{{$settings['title_403']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_403" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_403')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 404 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_404" class=" @error('title_404') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_404" value="{{$settings['title_404']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_404" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_404')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 419 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_419" class=" @error('title_419') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_419" value="{{$settings['title_419']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_419" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_419')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 429 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_429" class=" @error('title_429') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_429" value="{{$settings['title_429']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_429" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_429')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 500 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_500" class=" @error('title_500') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_500" value="{{$settings['title_500']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_500" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_500')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-5 m-b-20">
                                            <label class="pb-2 float-start  fs-5 fw-bold mb-2" style="font-size:15px; font-weight: 400;">Code 503 </label>
                                        </div>
                                        <div class="col-md-3 m-b-20">
                                            
                                            <input type="text" name="title_503" class=" @error('title_503') is-invalid border-danger @enderror form-control form-control-solid" placeholder="title_503" value="{{$settings['title_503']}}" maxlength="100" >
                                        </div>
                                        <div class="col-md-4 m-b-20">
                                            
                                                <textarea name="message_503" rows="3"  class="form-control  form-control-solid w-100">  {{siteSetting('message_503')}} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Details-->
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                            <span class="svg-icon svg-icon-2 svg-icon-logo">
                                {!! getSvg('gen055') !!}
                            </span>
                            Update 
                    </button>
                </div>
            </form>
        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection
@push('js')
@endpush
@section('scripts')
<!-- Custom Functions -->
<script>
    

      
</script>
@endsection