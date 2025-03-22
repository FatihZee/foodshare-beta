<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register - FoodShare</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.ico') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
	<style>
		.home-btn {
			position: fixed;
			top: 20px;
			left: 20px;
			z-index: 1000;
			background-color: rgba(255, 255, 255, 0.8);
			border-radius: 50%;
			width: 50px;
			height: 50px;
			display: flex;
			justify-content: center;
			align-items: center;
			box-shadow: 0 2px 5px rgba(0,0,0,0.2);
			transition: all 0.3s ease;
		}
		.home-btn:hover {
			background-color: #fff;
			transform: scale(1.1);
			box-shadow: 0 3px 7px rgba(0,0,0,0.3);
		}
		.home-btn i {
			font-size: 24px;
			color: #333;
		}
	</style>
</head>
<body>
	
	<!-- Home button outside the register container -->
	<a href="{{ route('home') }}" class="home-btn">
		<i class="fa fa-home"></i>
	</a>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('{{ asset('images/bg-01.jpg') }}');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
					@csrf
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Register
					</span>

					<div class="wrap-input100 validate-input" data-validate="Masukkan nama">
						<input class="input100" type="text" name="name" placeholder="Nama" required>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Masukkan email">
						<input class="input100" type="email" name="email" placeholder="Email" required>
						<span class="focus-input100" data-placeholder="&#xf15a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Masukkan password">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Konfirmasi password">
						<input class="input100" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Daftar
                        </button>
                    </div>
                    
                    <div class="text-center p-t-10"> <!-- Mengurangi jarak -->
                        <a class="txt1" href="{{ route('login') }}">
                            Sudah punya akun? Login
                        </a>
                    </div>                    
				</form>
			</div>
		</div>
	</div>

	<script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('vendor/countdowntime/countdowntime.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>