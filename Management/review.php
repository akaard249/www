<?php
include('../api/verf.php');
include('../api/conn.php');
include('../api/admin_ver.php');
if (isset($_GET["request_id"])) {
	$request_id = $_GET["request_id"];
	$request_query = "select loans.loan_id ,
				loans.loan_finance_comment,
				loans.loan_admin_comment ,
				users.user_name,users.user_cpr ,
				 user_company , 
				 loans.loan_amount ,
				  loans.loan_status , 
				  loans.loan_submition_date
				   from loans inner join users on users.user_cpr = loans.user_cpr where loans.loan_id = ? ;";
	$request_table = $con->prepare($request_query);
	$request_table->bind_param("i", $request_id);
	$request_table->execute();
	$request_result = $request_table->get_result();
	$request_data = $request_result->fetch_assoc();
	$selected_user_cpr = $request_data["user_cpr"];


	$comment_string = $con->prepare("SELECT * FROM annual_comment where user_cpr = ? ");
	$comment_string->bind_param("i", $selected_user_cpr);
	$comment_string->execute();
	$comment_query = $comment_string->get_result();

	$user_info = $con->prepare("select * from users where user_cpr = ? ");
	$user_info->bind_param("i", $selected_user_cpr);
	$user_info->execute();
	$user_data_result = $user_info->get_result();
	$user_data = $user_data_result->fetch_assoc();

	$loans_string = $con->prepare("select count(user_cpr) from loans where user_cpr = ? and loan_status = '1';");
	$loans_string->bind_param("i", $selected_user_cpr);
	$loans_string->execute();
	$loan_string_result = $loans_string->get_result();
	$num_loans = $loan_string_result->fetch_assoc();


	$shares_number = $con->prepare("select count(user_cpr) from shares where user_cpr= ? ;");
	$shares_number->bind_param("i", $selected_user_cpr);
	$shares_number->execute();
	$shares_num_result = $shares_number->get_result();
	$share_count = $shares_num_result->fetch_assoc();
	$shares_count = $share_count["count(user_cpr)"];

} else {

	header("location:/");

}






?>

<!DOCTYPE html>


<html lang="en">

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
	<script src="/api/js/loan_review.js"></script>
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
								 <li><a href='index.php'>Calender</a></li>
                                <li><a href='about.html'>Loans</a></li>
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
				<li class='active'><a href='#'> القروض</a>
					<ul class='dropdown'>
						<li ><a href='loan_payback'> سداد القروض</a></li>
						<li ><a href='requests'> طلبات القروض</a></li>
					</ul>
				</li>
				
				<li ><a href='#'>الاستلافات</a>
				<ul class='dropdown'>
				<li><a href='borrowings'>  سداد الاستلافات  </a></li>
				<li><a href='br_requests'> طلبات الاستلافات </a></li>
				</ul>
				
				</li>
                                <li ><a href='users'>العملاء</a></li>
                                <li><a href='reports'>التقارير</a></li>
				<li ><a href='#'> الملف الشخصي</a>
					<ul class='dropdown'>
						<li ><a href='/logout?logout=1'> تسجيل الخروج</a></li>
					</ul>
				</li>
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
						<h2>مراجعة قرض</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->



	<!-- Contact Section Begin -->
	<section class="contact spad">
		<div class="container">
			<div class="contact__content">
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="contact__form">
							<h3>معلومات العميل </h3>
							<div class="doctor__item__text">
								<div class="col-lg-3 col-md-3">
									<span>الرقم الشخصي</span>
									<h2>
										<?php echo $request_data["user_cpr"]; ?>
									</h2>
								</div>
								<div class="col-lg-12 col-md-12">
									<ul>
										<li><i class="fa fa-clock-o"></i> تاريخ
											الانضمام
											:
											<?php echo $user_data["user_reg_date"]; ?>
										</li>
										<li><i class="fa fa-id-card-o"></i>
											اسم الشخصي
											الاقرب للعميل :
											<?php echo $user_data["user_rel"]; ?>
										</li>
										<li><i class="fa fa-credit-card-alt"></i>
											رقم
											 هاتف اقرب شخص للعميل :
											<?php echo $user_data["user_rel_phone"]; ?>
										</li>
										<li><i class="fa fa-money"></i> المبلغ
											الأولي :
											<?php echo $user_data["user_init_payment"] ?>
											د.ب
										</li>
										<li><i class="fa fa-money"></i> عدد
											القروض
											الممنوحة :
											<?php echo $num_loans["count(user_cpr)"]; ?>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-md-6 col-sm-12">
<table class="custom-table" style="border-radius:3px;">
									<thead>
										<th width="20%"> السنة </th>

										<th width="50%"> تعليق الصندوق على السنة
										</th>
									</thead>
									<tbody>
											<?php
											while ($comment_table = mysqli_fetch_assoc($comment_query)) {
												echo "
													<tr>                                        
													<td>$comment_table[comment_year]</td>   
												
													<td>$comment_table[comment]
													</td>
												</tr>
												
												";
		}
		?>
									</tbody>
</table>
<div class="doctor__item__text">
<div class="contact__form">
	<h3> استحقاق القرض </h3>
	<ul>
		<li> وزن الدفعة الاولية :
			<?php echo $user_data["user_init_payment"] / 20; ?>
			شهر
		</li>
		<li> عدد الشهور داخل المعادلة (قيمة
			الشهور + قيمة الدفعة الأولية) :
			<?php echo $shares_count + $user_data["user_init_payment"] / 20; ?>
		</li>

		<li> المعادلة : عدد الشهور * 30
		</li>
		<li> المبلغ المستحق :
			<?php echo $shares_count + $user_data["user_init_payment"] / 20; ?>
			*
			30 =
			<?php echo ($shares_count + $user_data["user_init_payment"] / 20) * 30; ?>
			د.ب
		</li>
		<li> مبلغ السماح : 100 د.ب</li>
		<li> المبلغ الكلي :
			<?php echo ($shares_count + $user_data["user_init_payment"] / 20) * 30 + 100; ?>
			د.ب
		</li>
	</ul>
</div>
</div>
					</div>
					<div class="col-lg-4 col-md-12">
						<div class="contact__form">
							<h3>مراجعة الطلب</h3>
							<div class="review_form review_form--right">
									<input type="text" id="loan_id" value="<?php echo $request_data["loan_id"]; ?>" hidden>
									<label for="applicant" for="applicant">
										اسم المشترك </label>
									<input type="text" name="applicant"
										value="<?php echo $request_data["user_name"]; ?>"
										readonly>
									<input type="text" name="loan_id"
										value="<?php echo $request_data["loan_id"]; ?>"
										hidden>
									<label for="company_name">
										اسم الشركة </label>
									<input type="text" name="company_name"
										value="<?php echo $request_data["user_company"]; ?>"
										readonly>
									<label for="amount">
										كمية القرض </label>
									<input type="text" name="amount"
										value="<?php echo $request_data["loan_amount"] . "  د.ب"; ?>"
										readonly>
									

									<?php
									if ($user_type == 2) {
										if ($request_data["loan_status"] <> 2) {

											echo " 
											<label > نعليق أمين الصندوق </label>
											<textarea id='financeComment'  readonly > $request_data[loan_finance_comment] </textarea>";
											echo "<button id='back'  onclick='back()'   class='site-btn' style='font-size:15px;background-color:rgba(6,6,6,0.9);'> الرجوع </button>";

										} else {
											echo "
											<label > تعليق أمين الصندوق </label>
											<textarea type='text' id='financeComment' required placeholder = 'تعليق الأمين المالي'> </textarea>";
											echo "
											<div id='error'></div>
											<button id = 'accept' onclick='financeFun(event)' style='font-size:15px;background-color:rgba(4,170,109,0.9);' name='request_accept_btn' class='site-btn' >رفع الطلب </button>
											<button id = 'reject'  onclick='financeFun(event)' style='font-size:15px;backhground-color:red;' type='submit' name='request_reject_btn' class='site-btn' >رفض الطلب</button>
											<button id = 'back'  onclick='back()' name='requests_back'  class='site-btn' style='font-size:15px;background-color:rgba(6,6,6,0.9);'> الرجوع </button>";
										}

									} elseif ($user_type == 3) {

										if ($request_data["loan_status"] <> 3) {
											echo "  
											<label > تعليق أمين الصندوق </label>
											<textarea name='finance_comment' readonly > $request_data[loan_finance_comment] </textarea>";
											echo " 
											<label > تعليق المدير </label>
											<textarea name='admin_comment' readonly > $request_data[loan_admin_comment] </textarea>";
											echo "<button id = 'back'  onclick='back()' class='site-btn' style='background-color:rgba(6,6,6,0.9);'> الرجوع </button><a>";
										} else {
											echo "
											<label for='payback'> القسط الشهري </label>
											<input type='number' id='monthlyPayment' required>";
											echo "
											<label > نعليق أمين الصندوق </label>
											<textarea name='finance_comment' readonly > $request_data[loan_finance_comment] </textarea>";
											echo "
											<label > نعليق المدير </label>
											<textarea name='admin_comment' id='adminComment' placeholder='تعليق المدير ...'></textarea>";
											echo "
											<div id='error'></div>
											<button id = 'accept' onclick='adminBtnFun(event)' style='font-size:15px;background-color:rgba(4,170,109,0.9);' type='submit' name='request_accept_btn' class='site-btn' >رفع الطلب </button>
											<button id = 'reject' onclick='adminBtnFun(event)' style='font-size:15px;backhground-color:red;' type='submit' name='request_reject_btn' class='site-btn' >رفض الطلب</button>
											<button id = 'back'  onclick='back()' class='site-btn' style='font-size:15px;background-color:rgba(6,6,6,0.9);'> الرجوع </button>";
										}
									}
									?>
							</div>




						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Contact Section End -->

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

	</footer> <!-- Footer Section End -->

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