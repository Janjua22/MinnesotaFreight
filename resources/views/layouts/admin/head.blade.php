@include('admin.components.colors')
<base href="">
<title>{{ siteSetting('title') }}</title>
<meta name="description" content="{{ siteSetting('title') }} - Admin Panel">
<meta name="keywords" content="United Freight Dashboard Panel">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8" />
<meta property="og:locale" content="en_US">
<meta property="og:type" content="article">
<meta property="og:title" content="{{ siteSetting('title') }}">
<meta property="og:url" content="https://iconictek.com" />
<meta property="og:site_name" content="IconicTek | DigiHive">
<link rel="canonical" href="https://iconictek.com">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{asset('admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css">
<!--end::Page Vendor Stylesheets-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{asset('admin/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('admin/assets/plugins/custom/live-search/live-search.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('admin/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/cropper.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"  />

<meta name="_token" content="{!! csrf_token() !!}">
<!--end::Global Stylesheets Bundle-->

<style>
    @for( $i = 1 ; $i < 100; $i++)
    .w-{{$i}} {
        width: {{$i}}% !important;
    }
    @endfor
</style>

{{-- Custom code in header from Site Settings--}}
{!! siteSetting('custom_header') !!}