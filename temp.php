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
        <div class="offcanvas__logo">
            <a href="./index.php"><img src="img/logo.png" alt=""></a>
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
            <li><i class="fa fa-clock-o"></i> Sat to Thur 9:00 am to 2:00 pm - 4:00 pm to 8:00 pm </li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <div class="header__top__right">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i ></i></a>
                        </div>
                    </div>
					
					 <div class="col-lg-2">
                        <div class="header__top__left">
						
						<style>
			
			.dropbtn {border-radius : 3px ;
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
	border-radius : 3px;
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
	border-radius : 3px ;
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  opacity : 95% ;
  border-bottom = 5px;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}
			
			</style>
			
						
                            <div class="dropdown">
				<button class="dropbtn">  <?php echo $user ;?>  </button>
				<div class="dropdown-content">
					<a href='index.php?logout=1'>logout</a>
						
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
				<span align="center"><img src="img/acro.png" alt="نجاحات"></span>
                   
                </div>
				
				
				
				
              <div class="col-lg-10">
                    <div class="header__menu__option">
                        <nav class="header__menu">
                            <ul>
							<?php
							if($user_type == 1 ){
								echo"
								 <li><a href='./index.html'>Calender</a></li>
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
                        <h2>لائحة العميل</h2>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->



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
                                <button type="submit" class="site-btn">تواصل معنا </button>
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
                <div class="col-lg-2 col-md-12 col-sm-6" >
				</div>
                <div class="col-lg-4 col-md-12 col-sm-6" >
                    <div class="footer__map">
                        <iframe  
						
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.019051644723!2d50.570479274411284!3d26.13092179325192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ad6ac2abb407%3A0xf4bd447e882a43cb!2z2YbYrNin2K3Yp9iqINmE2YTYpdmG2KzYp9iyINmI2KfZhNiq2LfZiNmK2LE!5e0!3m2!1sen!2sbh!4v1705505315072!5m2!1sen!2sbh" width="400" height="190" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						
						
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