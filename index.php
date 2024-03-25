<?php
include('api/conn.php');
include('api/verf.php');

if($user_type == 2 || $user_type == 3){
 header("location:management");	
}

$check_first_signin = $con->prepare("SELECT user_first_signin FROM users where user_cpr = ?");
$check_first_signin->bind_param("i", $user_cpr);
$check_first_signin->execute();
$result = $check_first_signin->get_result();
$check_signin = $result->fetch_assoc();
if ($check_signin["user_first_signin"] == 0) {
	header('location: /greeting');
}

$now = (new DateTime)->format("Y");
  
if(isset($_COOKIE["user_cpr"])){	
	if(isset($_GET["year_dropdown"])){
		$year_val = $_GET["year_dropdown"];
		$query = $con-> prepare("select user_cpr,EXTRACT(MONTH FROM share_date) date from shares where user_cpr = ? and  year(share_date) = ? ORDER BY `date` ASC");
		$query -> bind_param("is",$user_cpr,  $year_val);
		$query -> execute();
		$content = $query -> get_result();

	}
	else{
		$query =$con ->prepare("select user_cpr,EXTRACT(MONTH FROM share_date) date from shares where user_cpr = ? and year(share_date) = ? ORDER BY `date` ASC");
		$query ->bind_param("is",$user_cpr , $now);
		$query -> execute();
		$content = $query -> get_result();
			
	}
}

?>



<?php 

$year_query = $con -> prepare("SELECT year(user_reg_date) year from users where user_cpr = ? ;");
$year_query -> bind_param("i",$user_cpr);
$year_query -> execute();
$years = $year_query -> get_result();

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
								<button class="dropbtn"> <?php echo $user ;?> </button>
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
							if($user_type == 1 ){
								echo"
				 <li class='active'><a href='index.php'>التقويم السنوي</a></li>
                                <li><a href='/Loan.php'>القروض</a></li>
				<li><a href='/borrowings.php'>الاستلافات</a></li>
                                <li ><a href='#'>الملف الشخصي</a>
                                    <ul class='dropdown'>
                                        <li><a href='./edit_profile.php'>تعديل الملف  الشخصي</a></li>
                                        <li><a href='logout.php?logout=1'>تسجيل الخروج</a></li>
                                    </ul>
                                </li>
				<li><a href='./contact.html'></a></li>
								
								";
								
								
								
							}
							else{
								echo"
								<li><a href='requests.php'>Loan Requests</a></li>
                                <li class='active'><a href='users.php'>Users</a></li>
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
						<h2>التقويم السنوي</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->

	<!-- Blog Section Begin -->
	<section class="blog spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-1 col-md-6 col-sm-6">
					<div class="dropdown">
						<button class="dropbtn" style="font-weight:700;"> <?php if(isset($_GET["year_dropdown"])){
							echo $_GET["year_dropdown"];
						}else{
							echo date("Y");
						}?> </button> 
						<div class="dropdown-content">
							<?php 
								$year_dropdown = mysqli_fetch_assoc($years);
								$current_year = date("Y");
								$user_reg = $year_dropdown["year"];
										for($i = $user_reg ; $i <= $current_year ; $i++){
								echo"<a href='index.php?year_dropdown=$i'>$i</a>";  

										}					
				
							?>


						</div>
					</div>
				</div>

			</div>
			<br>

			<div class="row">


				<?php 
                    $current_year = date("Y");
                    if(isset($_GET["year_dropdown"]) && $_GET["year_dropdown"] != $current_year){
                    $user_year = $_GET["year_dropdown"];
                    $counter = 1;
                    $num_rows = mysqli_num_rows($content);
                    
                    if($num_rows > 0){
                        while($table = $content -> fetch_assoc()){
                            for($i = $counter ; $i < $table["date"] ; $i++){
                                echo"
                                    <div class='col-lg-4 col-md-6 col-sm-6'>
                                        <div class='blog__item' id='cards' style='background-color:rgba(255,193,7,0.5);border-radius:10px;' >
                                            <div class='blog__item__text' align='center'>
                                                <h5><a href='#'> ".$i." </a></h5>
                                                <ul align:right>
                                                    <li >غير مدفوع</li>
								                        <br>
								                        <br>
                                                    <li align='right'>TBD</li>
                                                </ul>
                                            </div>
                                        </div>
						            </div>
                            
                                ";
                                $counter++;
                            }
                            $counter++;
                            echo"
                            <div class='col-lg-4 col-md-6 col-sm-6'>
                                <div class='blog__item' id='cards' style='background-color:rgba(4,170,109,0.5);border-radius:10px;' >
                                    <div class='blog__item__text' align='center'>
                                        <h5><a href='#'> ".$table["date"]." </a></h5>
                                        <ul align:right>
                                            <li >مدفوع </li>
                                            <br>
                                            <br>
                                            <li align='right'>TBD</li>
                                        </ul>
                                    </div>
                                </div>
						    </div>";
                                    
                        }
                        for($i = $counter ; $i <= 12 ; $i++ ){
                            echo"<div class='col-lg-4 col-md-6 col-sm-6'>
                                        <div class='blog__item' id='cards' style='background-color:rgba(255,193,7,0.5);border-radius:10px;' >
                                            <div class='blog__item__text' align='center'>
                                                <h5><a href='#'> ".$i." </a></h5>
                                                <ul align:right>
                                                    <li >غير مدفوع</li>
								                        <br>
								                        <br>
                                                    <li align='right'>TBD</li>
                                                </ul>
                                            </div>
                                        </div>
						            </div>
                            ";
                        }
                       
                        }
                    else{
                        for($i = 1;$i <= 12 ; $i++){
                             echo"
                                <div class='col-lg-4 col-md-6 col-sm-6'>
                                <div class='blog__item' id='cards' style='background-color:rgba(255,193,7,0.5);border-radius:10px;' >
                                <div class='blog__item__text' align='center'>
                                    <h5><a href='#'> ".$i." </a></h5>
                                    <ul align:right>
                                        <li >غير مدفوع</li>
                                        <br>
                                        <br>
                                        <li align='right'>TBD</li>
                                    </ul>
                                </div>
                                </div>
                                </div>";
                        }    
                       }

                        }
                        
                    else{

                    $current_month = date("m");
                    $i = 0;
                    $num_rows = mysqli_num_rows($content);
                    
					while($table = $content->fetch_assoc()){
                        echo"
						<div class='col-lg-4 col-md-6 col-sm-6'>
						<div class='blog__item' id='cards' style='background-color:rgba(4,170,109,0.5);border-radius:10px;' >
						 <div class='blog__item__text' align='center'>
                            <h5><a href='#'> ".$table["date"]." </a></h5>
                            <ul align:right>
                                <li style='font-weight:700;'>مدفوع </li>
								<br>
								<br>
                                <li align='right'>TBD</li>
                            </ul>
                        </div>
                        </div>
						</div>";
                        if(isset($table["date"])){
                            $i = $table["date"];
                        }
                        
                                     
                    }
                  $i++;
                    
                                       
                                       while($i <= $current_month){
                                        echo"
						<div class='col-lg-4 col-md-6 col-sm-6'>
						<div class='blog__item' id='cards' style='background-color:rgba(232,62,140,0.5);border-radius:10px;' >
						 <div class='blog__item__text' align='center'>
                            <h5><a href='#'> ".$i." </a></h5>
                            <ul align:right>
                                <li style='font-weight:700;'>غير مدفوع</li>
								<br>
								<br>
                                <li align='right'>TBD</li>
                            </ul>
                        </div>
                        </div>
						</div>";
                        $i++;
                                       }
                                      
                                       while($i <= 12 ){
                                        echo"
						<div class='col-lg-4 col-md-6 col-sm-6'>
						<div class='blog__item' id='cards' style='background-color:rgba(255,193,7,0.5);border-radius:10px;' >
						 <div class='blog__item__text' align='center'>
                            <h5><a href='#'> ".$i." </a></h5>
                            <ul align:right>
                                <li style='font-weight:700;'>غير ملزم</li>
								<br>
								<br>
                                <li align='right'>TBD</li>
                            </ul>
                        </div>
                        </div>
						</div>";
                        $i = $i + 1 ;
                                       }


                    }


					?>



			</div>

		</div>

		</div>
		</div>
	</section>
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