<?php
include('api/conn.php');
include('api/verf.php');
$check = $con -> prepare("SELECT user_first_signin from users where user_cpr = ?");
$check -> bind_param("i", $user_cpr);
$check -> execute();
$row = $check -> get_result() -> fetch_assoc();
if( $row["user_first_signin"] != 0){
header("location: /");
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="shortcut icon" href="favicon.png" type="image/png" />
	<title>Najahat</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->

	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_page/css/util.css">
	<link rel="stylesheet" type="text/css" href="login_page/css/main.css">
	<!--===============================================================================================-->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/login_page/js/greeting.js"></script>
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('/img/bckg.jpg');">
			<div class="wrap-login100">
				

					<i align="center"><img src="login_page/logo.png"></i>


					<span class="login100-form-title p-b-34 p-t-27">
						مرحبا بك في صندوق نجاحات
					</span>
					<span class="login100-form-title p-b-34"><h4> الرجاء تعديل كلمة السر لكلمة من اختيارك </h4></span>
					
					<input type="text" value="<?php echo$user_cpr;?>" id="user_cpr" hidden>
					<div class="wrap-input100 " data-validate="Enter username">
						<input id = "password1" class="input100" type="password" name="user_cpr"
							placeholder="ادخل كلمة السر" style="background:transparent !important">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 " data-validate="Enter password">
						<input id = "password2" class="input100" type="password" name="password"
							placeholder="ادخل كلمة السر مرة اخرى للتأكيد">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<div id="error"></div>
					<div class="container-login100-form-btn">
						<button id="submit_but" class="login100-form-btn" name="login" type="submit">
							تأكيد
						</button>
						<button id="ignore_but" style = "::before{background:#fff;}" class="login100-form-btn m-l-10" name="login" type="submit">
							تجاهل
						</button>
					</div>
					<div>
					</div>
				
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/masonry.pkgd.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.slicknav.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>