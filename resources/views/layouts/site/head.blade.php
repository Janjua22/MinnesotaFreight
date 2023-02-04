<head> 
    <!-- meta tag -->
    <meta charset="utf-8">
    <title>{{ siteSetting('title') }}</title>
    <meta name="description" content="">
    <!-- responsive tag -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/ico" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/aos.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/off-canvas.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/fonts/linea-fonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/fonts/flaticon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/magnific-popup.css') }}">
    <!-- Main Menu css -->
    <link rel="stylesheet" href="{{ asset('site/css/rsmenu-main.css') }}">
    <link rel="stylesheet" href="{{ asset('site/css/rs-animations.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/inc/custom-slider/css/nivo-slider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/inc/custom-slider/css/preview.css') }}">
    <!-- rsmenu transitions css -->
    <link rel="stylesheet" href="{{ asset('site/css/rsmenu-transitions.css') }}">
    <!-- spacing css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/rs-spacing.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/select2.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/style.css') }}"> <!-- This stylesheet dynamically changed from style.less -->
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/responsive.css') }}">

    @yield('styles')
</head>