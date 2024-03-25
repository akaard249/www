<?php
include('api/conn.php');
include('api/verf.php');

if ($user_type == 2 || $user_type == 3) {
	header("location:management");
}


if (isset($_COOKIE["user_cpr"])) {
	$user_cpr = $_COOKIE["user_cpr"];
	$user_info = $con->prepare("select * from users where user_cpr = ?");
	$user_info->bind_param("i", $user_cpr);
	$user_info->execute();
	$result = $user_info->get_result();
	$user_data = $result->fetch_assoc();
}

?>



<?php

$year_query = $con->prepare("SELECT year(user_reg_date) year from users where user_cpr = ? ;");
$year_query->bind_param("i", $user_cpr);
$year_query->execute();
$years = $year_query->get_result();

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="صندوق نجاحات التعاوني">
	<meta name="keywords" content="صندوق, نجاحات">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="favicon.png" type="image/png" />
	<title>Najahat</title>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<script src="js/jquery-3.3.1.min.js"></script>
	<!-- Css Styles -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="css/flaticon.css" type="text/css">
	<link rel="stylesheet" href="css/nice-select.css" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
	<link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
	<link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
	<link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="/api/js/edit_profile.js"></script>
</head>

<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Offcanvas Menu Begin -->
	<div class="offcanvas-menu-overlay"></div>
	<div class="offcanvas-menu-wrapper">

		<div id="mobile-menu-wrap"></div>
		<div class="offcanvas__btn">
			<a href="#" class="primary-btn">Appointment</a>
		</div>
		<ul class="offcanvas__widget">
			<li><i class="fa fa-phone"></i> +973-3388-4711</li>
			<li><i class="fa fa-map-marker"></i> Riffa, Bahrain ,2508</li>
			<li><i class="fa fa-clock-o"></i> Sat to Thur 9:00 am to 2:00 pm - 4:00 pm to 8:00 pm </li>
		</ul>
		<div class="offcanvas__social">
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-instagram"></i></a>
			<a href="#"><i class="fa fa-dribbble"></i></a>
		</div>
	</div>
	<!-- Offcanvas Menu End -->

	<!-- Header Section Begin -->
	<!-- Header Section Begin -->
	<header class="header">
		<div class="header__top">

			<div class="container">
				<div class="row">

					<div class="col-lg-8">
						<ul class="header__top__left">
							<li><i class="fa fa-phone"></i> +973-3388-4711</li>
							<li><i class="fa fa-map-marker"></i> Riffa, Bahrain ,2508</li>
							<li><i class="fa fa-clock-o"></i> Sat to Thur 9:00 am to 2:00 pm
								- 4:00 pm to 8:00 pm </li>
						</ul>
					</div>
					<div class="col-lg-2">
						<div class="header__top__right">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-instagram"></i></a>
							<a href="#"><i></i></a>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="header__top__left">

							<style>
								.dropbtn {
									border-radius: 3px;
									background-color: #04AA6D;
									color: white;
									padding: 0px;
									font-size: 15px;
									border: none;
									width: 140px;
									height: 30px;
								}

								/* The container  - needed to position the dropdown content */
								.dropdown {
									border-radius: 3px;
									position: relative;
									display: inline-block;
								}

								/* Dropdown Content (Hidden by Default) */
								.dropdown-content {
									border-radius: 3px;
									display: none;
									position: absolute;
									background-color: #f1f1f1;
									min-width: 160px;
									box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
									z-index: 1;
									opacity: 95%;
									border-bottom=5px;
								}

								/* Links inside the dropdown */
								.dropdown-content a {
									color: black;
									padding: 12px 16px;
									text-decoration: none;
									display: block;
								}

								/* Change color of dropdown links on hover */
								.dropdown-content a:hover {
									background-color: #ddd;
								}

								/* Show the dropdown menu on hover */
								.dropdown:hover .dropdown-content {
									display: block;
								}

								/* Change the background color of the dropdown button when the dropdown content is shown */
								.dropdown:hover .dropbtn {
									background-color: #3e8e41;
								}
							</style>


							<div class="dropdown">
								<button class="dropbtn">
									<?php echo $user; ?>
								</button>
								<div class="dropdown-content">
									<a href='logout.php?logout=1'>logout</a>

								</div>
							</div>
						</div>





						<div class="col-lg-10 col-md-6 col-sm-6">

						</div>







					</div>
				</div>
			</div>
		</div>
		</div>

		<div class="container">
			<div class="row align-items-center " style="">

				<div class="col-lg-2  d-flex align-items-center">
					<a href="index.php"><img src="img/acro.png" alt="نجاحات"></a>

				</div>




				<div class="col-lg-10">
					<div class="header__menu__option">
						<nav class="header__menu">
							<ul>
								<?php
								if ($user_type == 1) {
									echo "
				 <li ><a href='index.php'>التقويم السنوي</a></li>
                                <li><a href='/Loan.php'>القروض</a></li>
				<li><a href='/borrowings.php'>الاستلافات</a></li>
                                <li class='active' ><a href='#'>الملف الشخصي</a>
                                    <ul class='dropdown'>
                                        <li><a href='./edit_profile.php'>تعديل الملف  الشخصي</a></li>
                                        <li><a href='logout.php?logout=1'>تسجيل الخروج</a></li>
                                    </ul>
                                </li>
				<li><a href='./contact.html'></a></li>
								
								";



								} else {
									echo "
				<li><a href='requests.php'>Loan Requests</a></li>
                                <li ><a href='users.php'>Users</a></li>
                                <li><a href='reports.php'>Reports</a></li>
                                <li><a href='./contact.html'></a></li>
								
								";



								}
								?>


							</ul>
						</nav>

					</div>
				</div>
			</div>
			<div class="canvas__open">
				<i class="fa fa-bars"></i>
			</div>
		</div>
	</header>
	<!-- Header Section End -->

	<!-- Breadcrumb Section Begin -->
	<section class="breadcrumb-option spad set-bg" data-setbg="img/banner.avif">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="breadcrumb__text">
						<h2>تعديل الملف الشخصي</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->

	<!-- Blog Section Begin -->
	<div class="container">
		<div class="row" style="justify-content:center;">
			<div class="tab">
				<button class="tablinks active" style="margin-left:0%;"  onclick="toggle(event, 'edit_profile')"> تعديل الملف </button>
				<button class="tablinks" style="margin-left:0%;" onclick="toggle(event, 'edit_password')"> تعديل كلمة السر </button>
			</div>
		</div>
		<div class="row" style="justify-content:center;">
			<div class="col-lg-4">
				<div id="edit_profile" class="tabcontent" style="display:block;">
					<div id="edit_form" class="edit_form">
						<input type="text" value="<?php echo$user_cpr;?>" id="user_cpr" readonly hidden>
						<label >الاسم بالكامل</label>
						<input type="text" readonly id="user_name"  placeholder="الاسم بالكامل" value="<?php echo$user_data["user_name"];?>">
						<label >اسم الشركة</label>
						<input type="text" id="user_company" placeholder="اسم الشركة" value="<?php echo $user_data["user_company"]; ?>">
						<label >رقم الهاتف</label>
						<input type="text" id="user_phone" maxlength="9" value="<?php echo $user_data["user_phone"]; ?>" placeholder="رقم الهاتف" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
						<label >اسم اقرب شخص للعميل</label>
						<input type="text" id="user_rel" value="<?php echo $user_data["user_rel"]; ?>" placeholder="اسم أقرب شخص للعميل">
						<label >رقم هاتف اقرب شخص للعميل</label>
						<input type="text" id="user_rel_phone" maxlength="9" value="<?php echo $user_data["user_rel_phone"]; ?>" placeholder="رقم هاتف أقرب شخص للعميل" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
						<div id="error"></div>
						<button id="edit_user" > نعديل الملف </button>
					</div>
					<div  class="confirm_form" id="confirm_form" >
						<label > الرجاء ادخال كلمة المرور لحفظ التغييرات</label>
						<input type="password" id="password"  placeholder="كلمة المرور">
						<div id="error2"></div>
						<button id="password_check" > نعديل الملف </button>
						<button id="back" style="background-color:black;color:white"> الرجوع </button>
					</div>
				</div>
				<div id="edit_password" class="tabcontent">
					<div class="edit_form">
						<label for="old_password"> كلمة السر القديمة</label>
						<input type="password" id="old_password">
						<label for="new_password"> كلمة السر الجديدة </label>
						<input type="password" id="new_password">
						<label for="new_password_confirmed"> تأكيد كلمة السر الجديدة</label>
						<input type="password" id="new_password_confirmed">
						<div id="pass_edit_error"></div>
						<button id="edit_pass_but" > تعديل كلمة السر </button>
					</div>
				</div>
			</div>						
		</div>
	</div>
	<script>
		function toggle(evt, section_name) {
			// Declare all variables
			var i, tabcontent, tablinks;

			// Get all elements with class="tabcontent" and hide them
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}

			// Get all elements with class="tablinks" and remove the class "active"
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}

			// Show the current tab, and add an "active" class to the button that opened the tab
			document.getElementById(section_name).style.display = "block";
			evt.currentTarget.className += " active";
		}
			</script>

	</div>
	<!-- Blog Section End -->

	<!-- Footer Section Begin -->
	<footer class="footer">
		<div class="footer__top">
			<div class="container">
				<div class="row">

					<div class="col-lg-4 col-md-8">
						<div class="footer__newslatter">
							<form action="#" dir="ltr">
								<input type="text" placeholder="البريد الالكتروني">
								<button type="submit" class="site-btn">تواصل معنا
								</button>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">

				<div class="col-lg-2 col-md-3 col-sm-6">
					<div class="footer__widget">
						<h5>Quick links</h5>
						<ul>
							<li><a href="#">Facebook</a></li>
							<li><a href="#">Insta</a></li>
							<li><a href="#">Twitter</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="footer__address">
						<h5>Contact Us</h5>
						<ul>
							<li><i class="fa fa-map-marker"></i>Riffa, Bahrain ,2508</li>
							<li><i class="fa fa-phone"></i> +973-3388-4711</li>
							<li><i class="fa fa-envelope"></i> Support@gmail.com</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-12 col-sm-6">
				</div>
				<div class="col-lg-4 col-md-12 col-sm-6">
					<div class="footer__map">
						<iframe <iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.019051644723!2d50.570479274411284!3d26.13092179325192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ad6ac2abb407%3A0xf4bd447e882a43cb!2z2YbYrNin2K3Yp9iqINmE2YTYpdmG2KzYp9iyINmI2KfZhNiq2LfZiNmK2LE!5e0!3m2!1sen!2sbh!4v1705505315072!5m2!1sen!2sbh"
							width="400" height="190" style="border:0;" allowfullscreen=""
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"></iframe>


					</div>
				</div>
			</div>
		</div>

	</footer>
	<!-- Footer Section End -->

	<!-- Js Plugins -->
	
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