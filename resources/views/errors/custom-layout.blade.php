<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>404 HTML Tempalte by Colorlib</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
    <link href="{{asset('admin/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

    <style>
        * {
        -webkit-box-sizing: border-box;
                box-sizing: border-box;
        }

        body {
        padding: 0;
        margin: 0;
        }

        #notfound {
        position: relative;
        height: 100vh;
        }

        #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
        }

        .notfound {
        max-width: 410px;
        width: 100%;
        text-align: center;
        }

        .notfound .notfound-404 {
        height: 280px;
        position: relative;
        z-index: -1;
        }

        .notfound .notfound-404 h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 230px;
        margin: 0px;
        font-weight: 900;
        position: absolute;
        left: 50%;
        -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
                transform: translateX(-50%);
        background: url({{asset(Storage::url(siteSetting('auth_text_bg')))}}) no-repeat;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: cover;
        background-position: center;
        -webkit-text-stroke: 4px #e1c57d !important;
        }


        .notfound h2 {
        font-family: 'Montserrat', sans-serif;
        color: #997f4f;
        font-size: 24px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 0;
        }

        .notfound p {
        font-family: 'Montserrat', sans-serif;
        color: #997f4f;
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 20px;
        margin-top: 0px;
        }

        .notfound a {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        text-decoration: none;
        text-transform: uppercase;
        background: #997f4f;
        display: inline-block;
        padding: 15px 30px;
        border-radius: 40px;
        color: #fff;
        font-weight: 200;
        -webkit-box-shadow: 0px 4px 15px -5px #dcbb6b;
                box-shadow: 0px 4px 15px -5px #dcbb6b;
        }


        @media only screen and (max-width: 767px) {
            .notfound .notfound-404 {
            height: 142px;
            }
            .notfound .notfound-404 h1 {
            font-size: 112px;
            }
        }

    </style>

</head>

<body>

	<div id="notfound" class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{asset(Storage::url(siteSetting('auth_bg')))}});background-size: cover;background-repeat: no-repeat;">
		<div class="notfound">
			<div class="notfound-404">
				<h1>
                    @yield('code')
                </h1>
			</div>
			<h2>@yield('title')</h2>
			<p>@yield('message')</p>
			<a href="{{ url()->previous() }}"> <i class="bi bi-caret-left fs-2  text-white"></i> Back</a>
            @if (Route::has('login'))
			<a href="{{route('login')}}"> <i class="bi bi-house fs-2  text-white"></i> {{ __('Go Home') }}</a>
            @endif
		</div>
	</div>

</body>

</html>
