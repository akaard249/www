<?php 
$error = "";
include('api/conn.php');

if (isset($_POST["login"])){
	$user_cpr = $_POST["user_cpr"];
	$pass =$_POST["password"];
	$query = $con->prepare("SELECT * from users where user_cpr = ?");
	$query->bind_param("i", $user_cpr);
	$query->execute();
	$result = $query->get_result();
	if(mysqli_num_rows($result)> 0 ){
		$user_data = $result->fetch_assoc();
		$db_pass = $user_data["user_password"];
		if(password_verify($pass, $db_pass)){
			$type = $user_data["user_type"];
			$name = $user_data["user_name"];
			setcookie("user_cpr","$user_cpr",time() + 31536000000);
			setcookie("user_name","$name",time() + 31536000000);
			setcookie("stat","logged" , time() + 31536000000);
			setcookie("type","$type" , time() + 31536000000);
			header("location:index.php");
		}
		else{
			$error ="<div class=\"alert alert-danger alert-dismissible m-t-10\">
  			<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  			<strong>كلمة المرور غير صحيحة ، الرجاء التأكد من كلمة المرور و المحاولة مجددا 
			</div>";
    			}	
		}
    	else{
		
		$error ="<div class=\"alert alert-danger alert-dismissible m-t-10\">
  			<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  			<strong>كلمة المرور غير صحيحة </strong> الرجاء التأكد من كلمة المرور و المحاولة مجددا	</div>";
    	}
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
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/img/bckg.jpg');">
			<div class="wrap-login100">
				<form action="login.php" method="post" class="login100-form validate-form">
					
						<i ><img src="login_page/logo.png"></i>
					

					<span class="login100-form-title p-b-34 p-t-27">
						تسجيل الدخول
					</span>

					<div class="wrap-input100 validate-input" data-validate = "أدخل الرقم الشخصي">

						<input class="input100" type="text" name="user_cpr" placeholder="الرقم الشخصي"
						oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">

						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="أدخل كلمة السر">
						<input class="input100" type="password" name="password" placeholder="كلمة المرور">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
<div style="text-align:right;"><?php echo $error ; ?></div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login" type="submit">
							Login
						</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="login_page/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login_page/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login_page/vendor/bootstrap/js/popper.js"></script>
	<script src="login_page/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login_page/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login_page/vendor/daterangepicker/moment.min.js"></script>
	<script src="login_page/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login_page/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login_page/js/main.js"></script>

</body>
</html>