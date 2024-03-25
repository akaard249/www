<?php
$error = "";
include('../api/verf.php');
include('../api/conn.php');
include('../api/admin_ver.php');


$users_list = $con->prepare("select distinct(users.user_name) , borrowings.user_cpr from borrowings inner join users on users.user_cpr = borrowings.user_cpr where borrowings.borrowing_status = '1' and borrowings.borrowing_payback_status = '0';");
$users_list->execute();
$user_list_data = $users_list->get_result();

$table_year_query = $con->prepare("select min(year(loan_acceptance_date)) from loans WHERE loan_acceptance_date is not null;");
$table_year_query->execute();
$table_year_result = $table_year_query->get_result();
$min_year = $table_year_result->fetch_assoc()["min(year(loan_acceptance_date))"];

$loanees_list = $con->prepare("
SELECT DISTINCT borrowings.user_cpr , users.user_name   from borrowings inner JOIN users on users.user_cpr = borrowings.user_cpr where borrowings.borrowing_status = '1';");
$loanees_list->execute();
$loanees_list_data = $loanees_list->get_result();

?>


<!doctype html>
<html lang="en">

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

	<!-- Css Styles -->
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="../css/flaticon.css" type="text/css">
	<!-- <link rel="stylesheet" href="../css/nice-select.css" type="text/css"> -->
	<link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css">
	<link rel="stylesheet" href="../css/magnific-popup.css" type="text/css">
	<link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
	<link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/api/js/br_payback.js"></script>
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
			<a href="./index.php"><img src="../img/acro.png" alt=""></a>
		</div>
		<div id="mobile-menu-wrap"></div>

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
								 <li><a href='./index.html'>Home</a></li>
                                <li><a href='./about.html'>Loans</a></li>
                                <li class='active'><a href='#'>Profile</a>
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
				
				<li class='active'><a href='#'>الاستلافات</a>
				<ul class='dropdown'>
				<li><a href='borrowings'>  سداد الاستلافات  </a></li>
				<li><a href='br_requests'> طلبات الاستلافات </a></li>
				</ul>
				
				</li>
                                <li ><a href='users'>العملاء</a></li>
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
						<h2> سداد الاستلافات</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->



	<!-- page content -->
	<div class="container">
		<div class="borrowings">
			<div class="row">
				<div class="col-lg-4 col-md-12 col-sm-12">
					<div class="consultation__form">
						<div class="section-title">
							<span>نافذة تسجيل</span>
							<h2>الاستلافات</h2>
						</div>
						<div class="br_submit">

							<select name="br_user_cpr" id="br_user_cpr">
								<option value="none"> اختر اسم العميل </option>
								<?php
								while ($users = mysqli_fetch_assoc($user_list_data)) {
									echo "
                                        <option value='$users[user_cpr]'>
                                        $users[user_name]
                                        </option>
                                        ";
								}
								?>
							</select>

							<div id="year_select"></div>
							
							<div id="error"></div>
							<div class="error">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<button type="submit" style="display:none;" name="share_payment"
								class="site-btn" id="btn_sub">سداد السلفة</button>
						</div>
					</div>



				</div>
				<div class="col-lg-8 col-md-12 col-sm-12">

					<div class="share_search">
						<div class="row">
						<div class="col-lg-11 col-md-11 col-sm-11">
					<label for="br_year"> حدد السنة </label>
											<select name="br_year" id="br_year">
												<option value="whole">الكل</option>
												<?php
												$current_year = date("Y");
												for ($i = $current_year; $i >= $min_year; $i--) {
													echo "<option value='$i'> $i </option>";

												}
												?>
											</select>
											<label for="br_year"> حدد الشهر </label>
											<select name="month" id="br_month">
												<option value="whole">السنة كاملة</option>
												<?php
												for ($i = 1; $i <= 12; $i++) {

													echo "<option value='$i' >$i</option>";
												}
												?>
											</select>
											<label for="br_year"> حدد العميل </label>
											<select name="user_cpr" id="user_cpr">
												<option value="whole"> الكل </option>
												<?php
												while ($data = $loanees_list_data->fetch_assoc()) {
													echo "<option value='$data[user_cpr]'>$data[user_name]</option>";


												}


												?>
											</select>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1">
						<div class="error">
							<div></div>
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>		
						</div>
					
						

					</div>
					 <div class="table table-responsive" style="height:500px;">
						<div class="br_results">
							<table class="table table-striped">
								<thead>
									<tr style="color:black;">

										<th scope="col">اسم المشترك</th>
										<th scope="col">كمية السلفة</th>
										<th scope="col"> تاريخ تقديم الطلب</th>
										<th scope="col"> تاريخ قبول السلفة</th>
										<th scope="col"> حالة السلفة</th>
										<th > المدفوع من السلفة </th>

									</tr>
								</thead>
								<tbody id="result_table" style="overflow-y:scroll;">

								</tbody>
							</table>
						</div>
					 </div>

				</div>

			</div>
		</div>
	</div>





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
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.019051644723!2d50.570479274411284!3d26.13092179325192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ad6ac2abb407%3A0xf4bd447e882a43cb!2z2YbYrNin2K3Yp9iqINmE2YTYpdmG2KzYp9iyINmI2KfZhNiq2LfZiNmK2LE!5e0!3m2!1sen!2sbh!4v1705505315072!5m2!1sen!2sbh"
							width="400" height="190" style="border:0;" allowfullscreen=""
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"></iframe>


					</div>
				</div>
			</div>
		</div>

	</footer>
	<!-- Footer Section End -->






	
	<script src="../js/jquery-3.3.1.min.js"></script>
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