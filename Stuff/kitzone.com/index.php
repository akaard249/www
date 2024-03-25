<?php
include('conn.php');
if(isset($_GET["language"]) && $_GET["language"]=="ar"){
	setcookie("language","arabic",time() + 31536000000);
	header("location:index.php");
}
elseif(isset($_GET["language"]) && $_GET["language"]=="en"){
	setcookie("language","English",time() + 31536000000);
	header("location:index.php");
}
elseif(isset($_COOKIE["language"])==false ){
	setcookie("language","English",time() + 31536000000);
	header("location:index.php");
}


if(isset($_COOKIE["language"]) && $_COOKIE["language"]=="arabic"){
	
	include('ar.php');
}
elseif((isset($_COOKIE["language"]) && $_COOKIE["language"]=="English")){
	include('en.php');
}

$result = mysqli_query($con,"SELECt images.swipe , images.front , images.back,  mainswipe.discription from mainswipe inner join images on images.P_id = mainswipe.P_id");
$feature_result = mysqli_query($con,"SELECt products.P_id ,products.p_company, images.swipe , products.P_name , products.P_price from ((featured_p INNER JOIN images ON featured_p.P_id = images.P_id) INNER JOIN products ON featured_p.P_id = products.p_id)");
$latest_result = mysqli_query($con , "select images.swipe , products.P_name ,products.p_company, products.P_price , products.P_id , products.date_added from products inner join images on products.P_id = images.P_id ORDER BY `products`.`date_added` DESC");



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KitZone Online Store</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="KitZone Online Store" name="keywords">
        <meta content="KitZone Online Store" name="description">

        <!-- Favicon -->
       
  
		
		<link href="logo.png" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
		 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
     
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
<link href="js/load.js">
        
    </head>

    <body>
             <div id = "boo">
         <!-- Top bar Start -->
       <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        
                      
                    </div>
                    <div class="col-sm-6">
                     <a style = "color:#ffffff" href="product-list.php?language=ar">اللغة العربية</a>
                     <a href="product-list.php?language=en">English</a>
                 
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->
        
        <!-- Nav Bar Start -->
        <div class="nav" id = "header">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand"><?php $lang["menu"];?></a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link active"><?php echo$lang["home"]; ?></a>
                            <a href="product-list.php" class="nav-item nav-link"><?php echo$lang["products"]; ?></a>
                            <a href="cart.php" class="nav-item nav-link"><?php echo$lang["cart"]; ?></a>
                            <a href="checkout.php" class="nav-item nav-link"><?php echo$lang["checkout"]; ?></a>
                            
                           
 <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo$lang["morepages"]; ?></a>
                                <div class="dropdown-menu">
                                    <a href="wishlist.php" class="dropdown-item"><?php echo$lang["wishlist"]; ?></a>
                                    <a href="login.php" class="dropdown-item"><?php echo$lang["login"]; ?></a>
                                    <a href="contact.php" class="dropdown-item"><?php echo$lang["contactus"]; ?></a>
                                </div>
								
                                    
                                </div>
                            </div>
                        </div>
                        <?php


                   if (isset($_COOKIE["username"]) && isset($_COOKIE["stat"]) ){
                       $username = $_COOKIE["username"];
                       echo"
                                  <div class=\"navbar-nav ml-auto\">
                            <div class=\"nav-item dropdown\">
                                <a href=\"#\" class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\">$username</a>
                                <div class=\"dropdown-menu\">
                                    <a href=\"login.php?login=true\" class=\"dropdown-item\" >".$lang["profile"]."</a>
                                    <a href=\"login.php?logout=true\" class=\"dropdown-item\">".$lang["logout"]."</a>
                       ";



                   }
                   else{
                       echo"
                                  <div class=\"navbar-nav ml-auto\">
                            <div class=\"nav-item dropdown\">
                                <a href=\"#\" class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\">Account</a>
                                <div class=\"dropdown-menu\">
                                    <a href=\"login.php?login=true\" class=\"dropdown-item\" >".$lang["login"]."</a>
                              
                       ";

                   }

                                    ?>
									<script>
// If user clicks anywhere outside of the modal, Modal will close

var modal = document.getElementById('modal-wrapper');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
                                </div>
                            </div>
                        </div>

                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->      
         <!-- Bottom Bar Start -->
        <div class="bottom-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="index.php">
                                <img src="logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search">
                           <form action="product-list.php" method="get">
                            <input type="text" id="search_text" name="search_key" placeholder="<?php echo$lang["search"]; ?>">
                            
							</form>
							<div  style="position:absolute;z-index: 3;opcacity :0;width:100%;" id="result" class="col-md-6"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user">
                            <a href="wishlist.php" class="btn wishlist">
                                <i class="fa fa-heart"></i>
                                   <span><?php 
								if(isset($_COOKIE["username"])){
								$wl_count = mysqli_query($con,"select * from wishlist where username = '$username';");
								echo "(".mysqli_num_rows($wl_count).")";
								}
                                                                  elseif(isset($_COOKIE["wishlist_items"])){
                                                                $cartcount =  json_decode($_COOKIE["wishlist_items"],true);
                                                                echo count($cartcount);
                                                                }
                                                                else{
                                                                
                                                                echo"(0)";
                                                                }
								
								
								
								?></span>
                            </a>
                            <a href="cart.php" class="btn cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span><?php 
								if(isset($_COOKIE["username"])){
								$cart_count = mysqli_query($con,"select * from cart where username = '$username';");
								echo "(".mysqli_num_rows($cart_count).")";
								}
                                                                  elseif(isset($_COOKIE["cart_items"])){
                                                                $cartcount =  json_decode($_COOKIE["cart_items"],true);
                                                                echo count($cartcount);
                                                                }
								else{
									echo"(0)";
									
								}
								
								?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End -->  
       
        <!-- Main Slider Start -->
		
        <div class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <nav class="navbar bg-light">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php"><i class="fa fa-home"></i><?php echo$lang["home"]; ?></a>
                                </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="product-list.php?search_key=slippers"><i class="fa fa-home"></i><?php echo$lang["slippers"]; ?></a>
                                </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="product-list.php?search_key=Sneaker"><span class="icon icon-accessibility" > . </span></i><?php echo$lang["sneakers"]; ?></a>
                                </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="product-list.php?search_key=jersies"><i class="	fas fa-futbol"></i><?php echo$lang["footballjersies"]; ?></a>
                                </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i><?php echo$lang["cart"]; ?></a>
                                </li>
                            
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-6">
                        <div class="header-slider normal-slider" width="500px">
						<?php
						while($row= mysqli_fetch_array($result)){
						echo"
                            <div class='header-slider-item'>
                                <img  width='' src='data:image/jpg;charset=utf8;base64,".base64_encode($row['swipe'])."' />
                                <div class='header-slider-caption'>
                                    <p>$row[discription]</p>
                                    <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Shop Now</a>
                                </div>
                            </div>
                          
                            ";
						}
							?>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
        <!-- Main Slider End -->      
        
        <!-- Brand Start -->
        <div class="brand">
            <div class="container-fluid">
                <div class="brand-slider">
                    <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
                </div>
            </div>
        </div>
        <!-- Brand End -->      
        
        
        <!-- Featured Product Start -->
        <div class="featured-product product">
            <div class="container-fluid">
                <div class="section-header">
                    <h1><?php echo$lang["featuredproduct"]; ?></h1>
                </div>
                <div class="row align-items-center product-slider product-slider-4">
                   
					<?php
					while($feature=mysqli_fetch_assoc($feature_result)){
						
						echo"
						<div class='col-lg-3'>
                        <div class='product-item'>
                            <div class='product-title'>
                                <a href='product-detail.php?P_id=$feature[P_id]'> $feature[P_name] </a>
                                <div class='ratting'>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                </div>
                            </div>
                            <div class='product-image'>
                                <a href='product-detail.php'>
                                     <img src='data:image/jpg;charset=utf8;base64,".base64_encode($feature['swipe'])."'>
                                </a>
                                <div class='product-action'>
                                    <a href='cart.php?P_name=$feature[P_name]&P_company=$feature[p_company]'><i class='fa fa-cart-plus'></i></a>
                                    <a href='wishlist.php?P_id=$feature[P_id]'><i class='fa fa-heart'></i></a>
                                    <a href='#'><i class='fa fa-search'></i></a>
                                </div>
                            </div>
                            <div class='product-price'>
                                <h3 style='color:white'><span>$</span> $feature[P_price]</h3>
                                <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Buy Now</a>
                            </div>
                        </div>
                    </div> 
              
					
              
					 
						
						";
					}
						?>
                   
                   
                </div>
                </div>
                
        </div>
        <!-- Featured Product End -->       
        
       
        <!-- Recent Product Start -->
        <div class="recent-product product">
            <div class="container-fluid">
                <div class="section-header">
                    <h1><?php echo$lang["recentproduct"]; ?></h1>
                </div>
                <div class="row align-items-center product-slider product-slider-4">
                   <?php 
				   $i = 1;
				   while($recent = mysqli_fetch_assoc($latest_result)){
					   echo"
					  <div class='col-lg-3'>
                        <div class='product-item'>
                            <div class='product-title'>
                                <a href='product-detail.php?P_id=$recent[P_id]'> $recent[P_name] </a>
                                <div class='ratting'>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                    <i class='fa fa-star'></i>
                                </div>
                            </div>
                            <div class='product-image'>
                                <a href='product-detail.php'>
                                     <img src='data:image/jpg;charset=utf8;base64,".base64_encode($recent['swipe'])."'>
                                </a>
                                <div class='product-action'>
                                    <a href='cart.php?P_name=$recent[P_name]&P_company=$recent[p_company]'><i class='fa fa-cart-plus'></i></a>
                                    <a href='wishlist.php?P_name=$recent[P_name]&P_company=$recent[p_company]'><i class='fa fa-heart'></i></a>
                                    <a href='#'><i class='fa fa-search'></i></a>
                                </div>
                            </div>
                            <div class='product-price'>
                                <h3 style='color:white'><span>$</span> $recent[P_price]</h3>
                                <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Buy Now</a>
                            </div>
                        </div>
                    </div> 
					 "; 
$i= $i+1;					 
				   }
				   
                 ?>
				</div>
            </div>
        </div>
        <!-- Recent Product End -->
        
       
        <!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2><?php echo$lang["followus"]; ?></h2>
                            <div class="contact-info">
                                <div class="social">
                                    <a href=""><i class="fab fa-twitter"></i></a>
                                    <a href=""><i class="fab fa-facebook-f"></i></a>
                                    <a href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a href=""><i class="fab fa-instagram"></i></a>
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        <!-- Footer Bottom Start -->
		<div id="modal-wrapper" class="modal">
  
   
  
  <form class="modal-content animate" action="/action_page.php">
        
    <div class="imgcontainer">
      <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close PopUp">&times;</span>
      <img src="logo.png" alt="Avatar" class="avatar">
      <h1 style="text-align:center">Log In</h1>
    </div>

    <div class="container">
	<ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" onClick="signin()">Log In</a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" onClick="signup()">Sign Up</a>
                                    </li>
									</ul>
									<br>
									<div id= "login">
									
      <input class="form-control" type="text" placeholder="Enter Username" name="uname">
      <input class="form-control" type="password" placeholder="Enter Password" name="pass">        
      <button class="form-control" type="submit">Login</button>
      <input type="checkbox" style="margin:26px 30px;"> Remember me      
      <a href="#" style="text-decoration:none; float:right; margin-right:34px; margin-top:26px;">Forgot Password ?</a>
    </div>
	
	
	
	<div id= "signup" style="display:none">
									
      <input type="text" placeholder="Enter Username" name="uname">
      <input type="password" placeholder="Enter Password" name="pass">        
      <button type="submit">sign up</button>
      <input type="checkbox" style="margin:26px 30px;"> Remember me      
      <a href="#" style="text-decoration:none; float:right; margin-right:34px; margin-top:26px;">Forgot Password ?</a>
    </div>
	</div>
    
  </form>
  
  <script>
  function signin(){
	  var login = document.getElementById('login');
	  var signup = document.getElementById('signup');
  login.style.display = 'block';
  signup.style.display = 'none';
  }
  function signup(){
	  var login = document.getElementById('login');
	  var signup = document.getElementById('signup');
   login.style.display = 'none';
  signup.style.display = 'block';
  }
  
  </script>
</div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 copyright">
                        <p>Copyright &copy; <a href="https://htmlcodex.com">HTML Codex</a>. All Rights Reserved</p>
                    </div>

                    <div class="col-md-6 template-by">
                        <p>Template By <a href="https://htmlcodex.com">HTML Codex</a></p>
                    </div>
                </div>
            </div>
        </div>

        
		
		<!-- Footer Bottom End -->       
        
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        <script>
		window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("header");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>

    <!-- JavaScript Libraries -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script src="js/load.js"></script>
        </div>
        <div class='spinner-wrapper' id = "loader">
		<div class="spinner"></div>
		</div>
    </body>
</html>
<script>

var loader = document.getElementById('loader');
var page = document.getElementById('boo');
page.style.opacity = '0';
var myFunc = function() {
   page.style.opacity = '1';
   loader.style.display = 'none';
}
window.onload = function() {
  setTimeout(myFunc, 500);
}
</script>
 <script>
 var div  = document.getElementById('result');
 	div.style.display = 'none';
$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search_text').keyup(function(){
			div.style.display = 'block';
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			div.style.display = 'none';
			load_data();			
		}
	});
});
</script>
    
