<!DOCTYPE html>
<html lang="en">
	@include('admin.components.colors')
	<head>
		<title>Confirm Password | {{ siteSetting('title') }}</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{asset('admin/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('admin/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <style>
            .form-panel{
                border-radius: 0.475rem;
            }
        </style>
	</head>
	<body id="kt_body" class="bg-body">
		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ asset(Storage::url(siteSetting('auth_bg'))) }});background-size:cover;">
				<div class="d-flex flex-center flex-column flex-column-fluid p-10">
					<a href="{{route('home')}}" class="mb-12">
						<img alt="Logo" src="{{ asset(Storage::url(siteSetting('logo_white'))) }}" style="width: 400px;">
					</a>
					<div class="w-lg-500px bg-body form-panel shadow-sm p-10 p-lg-15 mx-auto">
						<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('password.confirm') }}">
                            @csrf
							<div class="text-center mb-10">
								<h1 class="text-dark mb-3">Confirm Password</h1>
                                <p>This is a secure area of the application. Please confirm your password before continuing.</p>
							</div>
							<div class="fv-row mb-10">
								<div class="d-flex flex-stack mb-2">
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
								</div>
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" required>
							</div>
							<div class="text-center">
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Proceed</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('admin/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('admin/assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('admin/assets/js/custom/authentication/sign-in/general.js')}}"></script>
	</body>
</html>