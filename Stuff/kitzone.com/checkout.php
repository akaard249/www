<?php 
include('conn.php');
if(isset($_COOKIE["username"])){
	$username = $_COOKIE["username"];
		$result = mysqli_query($con , "select cart.p_id , products.p_price from cart inner join products on products.p_id = cart.p_id where cart.username = '$username'");
$total = 0 ;
while($g_total = mysqli_fetch_array($result)){
	$total = $total + $g_total["p_price"];
	
}
}

if(isset($_GET["language"]) && $_GET["language"]=="ar"){
	setcookie("language","arabic",time() + 31536000000);
	header("location:checkout.php");
}
elseif(isset($_GET["language"]) && $_GET["language"]=="en"){
	setcookie("language","English",time() + 31536000000);
	header("location:checkout.php");
}
elseif((isset($_GET["language"]) || isset($_COOKIE["language"]))==false ){
	setcookie("language","English",time() + 31536000000);
	
}


if(isset($_COOKIE["language"]) && $_COOKIE["language"]=="arabic"){
	
	include('ar.php');
}
elseif((isset($_COOKIE["language"]) && $_COOKIE["language"]=="English")){
	include('en.php');
} 		
if(isset($_GET["P_id"])){
$cartP_id = $_GET["P_id"];
$query = mysqli_query($con,"select * from cart where cart_item_id = '$cartP_id'");
$fetch = mysqli_fetch_assoc($query);

$row = mysqli_fetch_assoc(mysqli_query($con,"select * from products where P_id = '$fetch[P_id] '"));

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo$lang["checkout"];?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="eCommerce HTML Template Free Download" name="keywords">
        <meta content="eCommerce HTML Template Free Download" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
		    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Top bar Start -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
                    </div>
                    <div class="col-sm-6">
                     <a href="checkout.php?language=ar">اللغة العربية</a>
                     <a href="checkout.php?language=en">English</a>
                 
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->
        
         <!-- Nav Bar Start -->
        <div class="nav" id = "header">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link"><?php echo$lang["home"]; ?></a>
                            <a href="product-list.php" class="nav-item nav-link"><?php echo$lang["products"]; ?></a>
                            <a href="product-detail.php" class="nav-item nav-link"><?php echo$lang["product-details"]; ?></a>
                            <a href="cart.php" class="nav-item nav-link"><?php echo$lang["cart"]; ?></a>
                            <a href="checkout.php" class="nav-item nav-link active"><?php echo$lang["checkout"]; ?></a>
                            
                           
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
                                    <a href=\"accounts.php?logout=true\" class=\"dropdown-item\">".$lang["logout"]."</a>
                       ";



                   }
                   else{
                       echo"
                                  <div class=\"navbar-nav ml-auto\">
                            <div class=\"nav-item dropdown\">
                                <a href=\"#\" class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\">Account</a>
                                <div class=\"dropdown-menu\">
                                    <a href=\"login.php?login=true\" class=\"dropdown-item\" >".$lang["login"]."</a>
                                    <a href=\"login.php?signup=true\" class=\"dropdown-item\">".$lang['signup']."</a>
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
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                     <div class="col-md-6" >
                          <div class="search">
                           <form action="product-list.php" method="get">
                            <input type="text" id="search_text" name="search_key" placeholder="<?php echo$lang["search"]; ?>">
                            <button type="submit" ><i class="fa fa-search"></i></button>
							</form>
							<div  style="position:absolute;z-index: 3;opcacity :0;width:100%;" id="result" class="col-md-6"></div>
                        </div>
						 
                    </div>
                    <div class="col-md-3">
                        <div class="user">
                            <a href="wishlist.php" class="btn wishlist">
                                <i class="fa fa-heart"></i>
                                <span>(0)</span>
                            </a>
                            <a href="cart.php" class="btn cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>(0)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End --> 
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><?php echo$lang["home"];?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo$lang["products"];?></a></li>
                    <li class="breadcrumb-item active"><?php echo$lang["checkout"];?></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Checkout Start -->
        <div class="checkout">
        <form>
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-inner">
                            <div class="billing-address">
                                <h2><?php echo$lang["billingaddress"];?></h2>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?php echo$lang["billername"];?></label>
                                        <input class="form-control" type="text" placeholder="First Name" required>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <label><?php echo$lang["email"];?></label>
                                        <input class="form-control" type="text" placeholder="E-mail">
                                    </div>
                                    <div class="col-md-6">
                                        <label><?php echo$lang["phonenum"];?></label>
                                        <input class="form-control" type="text" placeholder="Mobile No" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label><?php echo$lang["address"];?></label>
                                        <input class="form-control" type="text" placeholder="Address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <select class="form-control" placeholder="City" required>
										<option value="Khartoum"> <?php echo$lang["khartoum"];?></option>
										<option value="Omdurman"><?php echo$lang["omdurman"];?></option>
										<option value="Bahri"> <?php echo$lang["bahri"];?></option>
										
										
										</select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="newaccount">
                                            <label class="custom-control-label" for="newaccount">Create an account</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="shipto">
                                            <label class="custom-control-label" for="shipto">Ship to different address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout-inner">
                            <div class="checkout-summary">
                                <h1><?php echo$lang["checkoutsummery"];?></h1>
                                            <p><?php echo$lang["subtotal"];?><span><?php if (isset($_GET["P_id"])){
                                            echo"$row[P_price]";
                                            }
                                            else{
                                            echo$total;
                                            }?></span></p>
                                            <p><?php echo$lang["shipping"];?><span><?php echo$total;?></span></p>
                                            <h2><?php echo$lang["grandtotal"];?><span><?php echo$total+$total;?></span></h2>
                            </div>

                            <div class="checkout-payment">
                               
                                <div class="checkout-btn">
                                    <button type="submit" name="checkout">Place Order</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- Checkout End -->
        
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
        
        <!-- JavaScript Libraries -->
          <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
		    <script src="js/search.js"></script>
    </body>
</html>
