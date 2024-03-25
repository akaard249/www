<?php

include('../api/verf.php');
include('../api/conn.php');
include('../api/admin_ver.php');

if (isset($_GET["user_cpr"])) {
	$user_id = $_GET["user_cpr"];

	$user_query = $con->prepare("select * from users where user_cpr = ? ;");
	$user_query->bind_param("i", $user_id);
	$user_query->execute();
	$user_data = $user_query->get_result();

	$loans_info = $con->prepare("select * from loans where user_cpr = ? and loan_status = '1' ");
	$loans_info->bind_param("i", $user_id);
	$loans_info->execute();
	$loans_result = $loans_info->get_result();
	$loans_count = mysqli_num_rows($loans_result);

	$annual_comments_info = $con->prepare("select * from annual_comment where user_cpr = ?");
	$annual_comments_info->bind_param("i", $user_id);
	$annual_comments_info->execute();
	$annual_comments_result = $annual_comments_info->get_result();

	$latest5 = $con->prepare("select month(share_date) month , year(share_date) year from shares where user_cpr = ? limit 5;");
	$latest5->bind_param("i", $user_id);
	$latest5->execute();
	$latest5_result = $latest5->get_result();



	if (mysqli_num_rows($user_data) > 0) {
		$user_table = $user_data->fetch_assoc();
		$user_name = $user_table["user_name"];
		$user_company = $user_table["user_company"];
		$user_init_payment = $user_table["user_init_payment"];
		$user_phone = $user_table["user_phone"];
		$user_rel = $user_table["user_rel"];
		$user_rel_phone = $user_table["user_rel_phone"];
		$user_reg_date = $user_table["user_reg_date"];
	} else {
		header("location :users.php?fetch_error=1");
	}
} else {
	header("loaction :users.php");


}


?>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="صندوق نجاحات التعاوني">
	<meta name="keywords" content="صندوق, نجاحات">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="../favicon.png" type="image/png" />
	<title>Najahat</title>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">

	<!-- Css Styles -->
	<script src="../js/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="../css/flaticon.css" type="text/css">
	<link rel="stylesheet" href="../css/nice-select.css" type="text/css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css">
	<link rel="stylesheet" href="../css/magnific-popup.css" type="text/css">
	<link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
	<link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
	<link rel="stylesheet" href="../css/style.css" type="text/css">
</head>

<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Offcanvas Menu Begin -->
	<div class="offcanvas-menu-overlay"></div>
	<div class="offcanvas-menu-wrapper">
		<div class="offcanvas__logo">
			<a href="./index.php"><img src="../img/logo.png" alt=""></a>
		</div>
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
									<a href='/logout?logout=1'>logout</a>

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
					<a href="/management"><span align="center"><img src="../img/acro.png"
								alt="نجاحات"></span></a>

				</div>




				<div class="col-lg-10">
					<div class="header__menu__option">
						<nav class="header__menu">
							<ul>
								<?php
								if ($user_type == 1) {
									echo "
								 <li><a href='./index.html'>Calender</a></li>
                                <li><a href='./about.html'>Loans</a></li>
                                <li ><a href='#'>Profile</a>
                                    <ul class='dropdown'>
                                        <li><a href='./pricing.html'>View Profile</a></li>
                                        <li><a href='./doctor.html'>Edit Profile</a></li>
                                        <li><a href='./blog-details.html'>Log out</a></li>
                                    </ul>
                                </li>
								<li><a href='./contact.html'></a></li>
								
								";



								} else {
									echo "
                                <li ><a href='requests'>الرئيسية</a></li>
				<li ><a href='shares'>الدفعات الشهرية</a></li>
				<li ><a href='#'> القروض</a>
					<ul class='dropdown'>
						<li ><a href='loan_payback'> سداد القروض</a></li>
						<li><a href='requests'> طلبات القروض</a></li>
					</ul>
				</li>
				
				<li ><a href='#'>الاستلافات</a>
				<ul class='dropdown'>
				<li><a href='borrowings'>  سداد الاستلافات  </a></li>
				<li><a href='br_requests'> طلبات الاستلافات </a></li>
				</ul>
				
				</li>
                                <li class='active'><a href='users'>العملاء</a></li>
                                <li><a href='reports'>التقارير</a></li>
                                <li><a href='./contact'></a></li>
								
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
	<section class="breadcrumb-option spad set-bg" data-setbg="../img/banner.avif">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="breadcrumb__text">
						<h2>لائحة العميل</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->

	<!-- About Section Begin -->
	<section class="about spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="contact__form">
						<h3>معلومات العميل </h3>
						<div class="doctor__item__text doctor__item__text--left">
							<h4 style="margin-bottom :10px;">تعليقات السنين السابقة  </h4>
							<table class="custom-table" style="border-radius:3px;">
								<thead>
									<th width="20%"> السنة </th>

									<th width="50%"> تعليق الصندوق على السنة
									</th>
								</thead>
								<tbody>
									<?php

									while ($annual_comments_table = mysqli_fetch_assoc($annual_comments_result)) {
										echo "
                                            <tr>                                        
                                                <td>$annual_comments_table[comment_year]</td>   
                                            
                                                <td>$annual_comments_table[comment]
                                                </td>
                                            </tr>
                                            
                                            ";

									}
									?>
								</tbody>
							</table>
							<h4 style="margin-bottom :10px;"> اخر 5 شهور مدفوعة </h4>
							<table class="custom-table" style="border-radius:3px;">
								<thead>
									<th> الشهر  </th>
									<th> السنة  </th>

								</thead>
								<?php
								while($latest5_array = mysqli_fetch_assoc($latest5_result)) {
echo"
<tr>
<td>$latest5_array[month] </td> 
<td> $latest5_array[year] </td> </tr>";
								}


?>



							</table>


						</div>



					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="about__text ">
						<div class="section-title">
							<h3 align="right"> المعلومات الشخصية </h3>

							<h2 align="right ">
								<?php echo $user_name; ?>
							</h2>
						</div>
						<div class="row">
							<ul align="right">
								<li> <i class="fa fa-user"></i>
									الرقم الشخصي :
									<?php echo " " . $user_id; ?>
								</li>
								<li> <i class="fa fa-building"></i>
									شركة متعلقة :
									<?php echo " " . $user_company; ?>
								</li>

								<li><i class="fa fa-clock-o"></i> تاريخ
									الانضمام
									:
									<?php echo "$user_reg_date" ?>
								</li>
								<li><i class="fa fa-money"></i> الدفعة الأولية :
									<?php echo "$user_init_payment" ?>
									د.ب
								</li>
								<li><i class="fa fa-money"></i> رقم  الهاتف :
									<?php echo "$user_phone" ?>
									د.ب
								</li>

							</ul>
							<ul align="left" style=" text-align:right;">
								<li><i class="fa fa-id-card-o"></i>
									 اسم
									أقرب شخص :
									<?php echo "$user_rel"; ?>
								</li>
								<li><i class="fa fa-credit-card-alt"></i>
									رقم
									هاتف أفرب شخص للعميل :
									<?php echo "$user_rel_phone"; ?>
								</li>
								<li><i class="fa fa-money"></i> عدد
									القروض
									الممنوحة :
									<?php echo "$loans_count" ?>
								</li>
							</ul>
						</div>
						<div class="row">
							<h3>ملخص للحالة القائمة</h3>
							<div class="table-responsive "></div>
						</div>




					</div>

				</div>

			</div>
			<div class="col-lg-12 col-md-12">
				<div id="error"></div>
				<a style="font-size: 15px;" href="users.php" class="primary-btn normal-btn">رجوع</a>
				<button style="font-size: 15px;" id="user_del_but" class="primary-btn normal-btn">تعطيل المستخدم</button>
			</div>
			<script>
				const del_but =document.getElementById("user_del_but");
				$(document).ready(function(){
					function delete_user(user_cpr){
						$.ajax({
							url :"/api/jsscripts.php" ,
							method : "post",
							data: {func:"del_user",user_cpr:user_cpr},
							success:function(data){
								if(data == "success" ){
									alert("تم نعطيل العميل");
									window.location.replace("/management/users");
								}
								else{
									$("#error").html(data);	
								}
							}
						});
					}


					del_but.addEventListener("click",function(){

						delete_user(<?php echo json_encode("$user_id", JSON_HEX_TAG); ?>);
					});
				});

			</script>
		</div>
	</section>
	<!-- About Section End -->

	<!-- Footer Section Begin -->

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
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.magnific-popup.min.js"></script>
	<script src="../js/masonry.pkgd.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<script src="../js/jquery.nice-select.min.js"></script>
	<script src="../js/jquery.slicknav.js"></script>
	<script src="../js/owl.carousel.min.js"></script>
	<script src="../js/main.js"></script>
</body>

</html>