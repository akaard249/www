<?php

include('../api/verf.php');
include('../api/conn.php');
include('../api/admin_ver.php');

$query = $con -> prepare("select * from users where user_type = '1' and user_status = '1' ;");
$query -> execute();
$users_name_result = $query -> get_result();


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
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="../css/flaticon.css" type="text/css">
	<link rel="stylesheet" href="../css/nice-select.css" type="text/css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css">
	<link rel="stylesheet" href="../css/magnific-popup.css" type="text/css">
	<link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
	<link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<script src="/api/js/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.umd.js"></script>
      
	
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
                                <li ><a href='users'>العملاء</a></li>
                                <li class='active'><a href='reports'>التقارير</a></li>
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
						<h2> التقارير</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->

	<!-- reports selector section -->
	<div id = "reportSelector" class="report-selector">
		<div class="col-lg-12" style="height:100%; width:100%;">
		<div class="row" style="height:100%; width:100%;justify-content:space-evenly;">
			<button class="toggle-button" onclick = "toggle(event,'whole-div')" id="whole"> الكل</button>
			<button class="toggle-button" onclick = "toggle(event,'monthlyShares-div')" id="clients"> المساهمات الشهرية </button>
			<button class="toggle-button" onclick = "toggle(event,'borrowings-div')" id="borrowings"> الاستلافات </button>
			<button class="toggle-button" onclick = "toggle(event,'loans-div')" id="loans"> القروض </button>
		
		</div>
	</div>
				
	</div>

	<div class="report">
		
		<div class="report-section">
			<div class="report-type" id="whole-div">
				<div class="report-filters">
					<label for="">من تاريخ</label>
					<input type="date" id="whole_from_date" min="2005-01-01" value="2005-01-01">
					
					<label for="">الى تاريخ</label>
					<input type="date" id="whole_to_date" max="2030-01-01" value="2025-03-02">
					
				</div>

				<div class="row" >

					<div class="col-lg-6 col-md-12">
						<div class="row">
							<div class="summery">
								<div class="treasury">
								<h5> الخزنة :</h5>
								<h6 > <strong id="treasury_value">1000</strong> د.ب <i class="fa fa-money"></i></h6>
								</div>
							
							
								<div class="arrears">
								<h5> المتأخرات :</h5>
								<h6> <strong id="arrears_value">1000</strong> د.ب <i class="fa fa-money"></i></h6>
								</div>
							</div>
						
							
						
					</div>
					<div class="row" style="height:400px; width:400px">
						
						<canvas id="piechart" ></canvas>
					
						
					</div>
							
					</div>

					<div class="col-lg-6 col-md-12" >
					<div class="table table-responsive" style="height:100%;">
					<table class="table table-striped" id="wholeress">
						<thead>
							<tr>

							
							<th scope="col" style="position: sticky;top: 0px">الدفعات الشهرية</th>
							<th scope="col" style="position: sticky;top: 0px"> الدفعات الأولية</th>
							<th scope="col" style="position: sticky;top: 0px"> القروض الممنوحة </th>
							<th scope="col" style="position: sticky;top: 0px"> سداد القروض </th>
							<th scope="col" style="position: sticky;top: 0px"> السلفات الممنوحة </th>
							<th scope="col" style="position: sticky;top: 0px">المسدد من السلفات </th>
							<th scope="col" style="position: sticky;top: 0px"> كامل المدفوع</th>
							
							
							
							
							
							
							</tr>
						</thead>
						<tbody id = "wholeResult" style="overflow-y:scroll;">
							<tr>
							<td id ="shares_table"> 0 </td>
							<td id ="init"> 0 </td>	
							<td id ="loans_given"> 0 </td>
							<td id ="loans_payback"> 0 </td>
							<td id ="borrowings_given">0</td>
							<td id ="borrowings_payback"> 0 </td>
							<td id ="total"> 0 </td>	
							
							</tr>
						<tbody>
					</table>
				
				</div>	
					</div>
				</div>	
                        </div>	
			
			<div class="report-type" id="monthlyShares-div">
				<div class="report-filters">
			
			<select  id="singleClient_user_cpr"> 
								<option value="whole"> اسم العميل (الكل)</option>
								
						<?php
						$query = $con->prepare("select * from users where user_type = '1' and user_status = '1' ;");
						$query->execute();
						$users_name_result = $query->get_result();


						while ($row = $users_name_result->fetch_assoc()) {
							echo "<option value = '$row[user_cpr]'> $row[user_name] </option> ";
						}
						?>
				
					</select>
					<label for="">من تاريخ</label>
					<input type="date" id="singleClient_from_date" min="2005-01-01" value="2005-01-01">
				
					<label for="">الى تاريخ</label>
					<input type="date" id="singleClient_to_date" max="2030-01-01" value="2025-03-02">
				</div>
				<div class="table table-responsive" style="height:100%;;">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col" style="position: sticky;top: 0px"> اسم العميل</th>
								<th scope="col" style="position: sticky;top: 0px"> تاريخ انضمام العميل</th>
								<th scope="col" style="position: sticky;top: 0px"> عدد المساهمات الشهريةالمدفوعة</th>
								<th scope="col" style="position: sticky;top: 0px"> قيمة المساهمات الشهريةالمدفوعة </th>
								<th scope="col" style="position: sticky;top: 0px">  اخر تاريخ للمساهمات </th>
								<th scope="col" style="position: sticky;top: 0px"> الشهور المتأخرة</th>
								<th scope="col" style="position: sticky;top: 0px"> قيمة المتأخرات</th>
								
								
							</tr>
						</thead>
						
						<tbody id="monthlySharesResult" style="overflow-y:scroll;">
						<tbody>
					</table>
				
				</div>
				
                        </div>	
			
			<div class="report-type" id="borrowings-div">
				<div class="report-filters">
					<select  id="borrowing_user_cpr"> 
										<option value="whole"> اسم العميل (الكل)</option>
										
										<?php
										$query = $con->prepare("select * from users where user_type = '1' and user_status = '1' ;");
										$query->execute();
										$users_name_result = $query->get_result();


										while( $row = $users_name_result->fetch_assoc() ) {
											echo "<option value = '$row[user_cpr]'> $row[user_name] </option> ";
										}
										?>
										
					</select>

					<label for="">من تاريخ</label>
					<input type="date" id="borrowing_from_date" min="2005-01-01" value="2005-01-01">
					
					<label for="">الى تاريخ</label>
					<input type="date" id="borrowing_to_date" max="2030-01-01" value="2025-03-02">
					<label for=""> حالة السلفة</label>
					<select  id="borrowing_stat">
						<option value="whole"> الكل </option>
						<option value="1"> سلفة منتهية </option>
						<option value="0">  سلفة قائمة </option>
					</select>
					
				</div>
				<div class="table table-responsive" style="height:100%;overflow-y:scroll;">
					<table class="table table-striped">
						<thead>
							<tr>
							<th scope="col" style="position: sticky;top: 0px"> اسم العميل </th>
							<th scope="col" style="position: sticky;top: 0px">كمية السلفة</th>
							<th scope="col" style="position: sticky;top: 0px">المسدد من السلفة </th>
							<th scope="col" style="position: sticky;top: 0px">تاريخ تقديم الطلب</th>
							<th scope="col" style="position: sticky;top: 0px">تعليق أمين الخزنة </th>
							<th scope="col" style="position: sticky;top: 0px">تعليق الادارة</th>
							</tr>
						</thead>
						<tbody id = "borrowingResult">
						<tbody>
					</table>
				
				</div>		
			</div>
			<div class="report-type" id="loans-div">
				<div class="report-filters">
			
			<select  id="loan_user_cpr"> 
								<option value="whole"> اسم العميل (الكل)</option>
								<?php
								$query = $con->prepare("select * from users where user_type = '1' and user_status = '1' ;");
								$query->execute();
								$users_name_result = $query->get_result();

								while( $row = $users_name_result->fetch_assoc() ) {
									echo "<option value = '$row[user_cpr]'> $row[user_name] </option> ";
								}
								?>
								
			</select>
			<label for="">من تاريخ</label>
			<?php 
			$query = $con -> prepare("select min(user_reg_date) from users;");
			$query ->execute();
			$result = $query -> get_result();
			$row = $result->fetch_assoc();

			?>
			<input type="date" id="loan_from_date" min="<?php echo $row["min(user_reg_date)"];?>" value="<?php echo $row["min(user_reg_date)"]; ?>">
			
			<label for="">الى تاريخ</label>
			<input type="date" id="loan_to_date" max="2030-01-01" value="2025-03-02">
			<label for=""> نوع القرض</label>
			<select name="" id="loan_stat">
				<option value="whole"> الكل </option>
				<option value="1"> قروض سابقة </option>
				<option value="0">  قروض قائمة </option>
				
			</select>
				</div>
			<div class="table table-responsive" style="height:100%;overflow-y:scroll;">
				<table class="table table-striped">
					<thead>
						<tr>
						<th scope="col" style="position: sticky;top: 0px"> اسم العميل </th>
						<th scope="col" style="position: sticky;top: 0px">كمية القرض</th>
						<th scope="col" style="position: sticky;top: 0px">المدفوع من القرض </th>
						<th scope="col" style="position: sticky;top: 0px">تاريخ تقديم الطلب</th>
						
						<th scope="col" style="position: sticky;top: 0px">تعليق أمين الخزنة </th>
						<th scope="col" style="position: sticky;top: 0px">تعليق الادارة</th>
						</tr>
					</thead>
					<tbody id="loanResult">
					<tbody>
				</table>
			
			</div>	
			</div>
				    
			


		</div>
	</div>



	<!-- reports selector section ends -->







	<!-- Footer Section Begin -->
	<footer class="footer">
		<div class="footer__top">
			<div class="container">
				<div class="row">

					<div class="col-lg-4 col-md-8">
						<div class="footer__newslatter">
							<form action="#" dir="ltr">
								<input type="text" placeholder="البريد الالكتروني">
								<button style="font-size:15px" type="submit"
									class="site-btn">تواصل معنا </button>
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
						<iframe
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
<!-- <script src="../js/jquery-3.3.1.min.js"></script> -->
<script src="/api/js/reports.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.magnific-popup.min.js"></script>
	<script src="../js/masonry.pkgd.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<!-- <script src="../js/jquery.nice-select.min.js"></script> -->
	<script src="../js/jquery.slicknav.js"></script>
	<script src="../js/owl.carousel.min.js"></script>
	<script src="../js/main.js"></script>
</body>

</html>