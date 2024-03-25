<?php
$error = "";
$error2="";
include('conn.php');

if(isset($_POST["signup"])){
	if ($_POST["pass1"] == $_POST["pass2"] ){
		$fname = $_POST["fullname"];
		$uname = $_POST["username"];
		$pass = $_POST["pass1"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
$fname = trim($fname);
$uname = trim($uname);
$email = trim($email);
$phone = trim($phone);
		$check_uname = mysqli_query($con,"select * from users where username = '$uname'");
		if(mysqli_num_rows($check_uname) > 0 ){
			$error2 = "<div class=\"alert alert-danger alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable To Sign Up!</strong> Username Already Taken . Try using another UserNames !.
</div>";
		}
		
		else{
	if ($email == ""){
		$query = "insert into `users` (`username`, `FullName`, `password`, `phone`, `email`) VALUES ('$uname', '$fname', '$pass', '$phone', NULL);";
	}
	else{
		$query = "insert into `users` (`username`, `FullName`, `password`, `phone`, `email`) VALUES ('$uname', '$fname', '$pass', '$phone', '$email');";
	}
	
	
	
	
	
	
	if (mysqli_query($con,$query)){
		
		setcookie("username","$uname",time() + 31536000000);
		setcookie("stat","logged",time() + 31536000000);
		if(isset($_COOKIE["cart_items"])){
                
                $data = json_decode($_COOKIE["cart_items"],true);
                foreach($data as $cart_item_index => $P_id) {
                $query = mysqli_query($con,"select * from cart where username = '$uname' and P_id = '$P_id'; ");
                if(mysqli_num_rows($query)){
                continue;
                }
                else{
                 if(mysqli_query($con,"insert into cart (username , P_id) values ('$uname','$P_id')")){
                 
                 if(mysqli_query($con,"delete from wishlist where username = '$uname' and P_id = '$P_id' ;")){
                 continue;
                 }
                 }
                 
                
                
                }
                
                }
                setcookie("cart_items", time() - 3600);
                }
                
                
                if(isset($_COOKIE["wishlist_items"])){
                
                $data = json_decode($_COOKIE["wishlist_items"],true);
                foreach($data as $cart_item_index => $P_id) {
                $query = mysqli_query($con,"select * from wishlist where username = '$uname' and P_id = '$P_id'; ");
                if(mysqli_num_rows($query)){
                continue;
                }
                else{
                
                
                 if(mysqli_query($con,"insert into wishlist (username , P_id) values ('$uname','$P_id')")){
                 
                 continue;
                 }
                 
                
                
                }
                
                }
                setcookie("wishlist_items", time() - 3600);
                }
		header("location:cart.php");
		
		
	}
	else{
		
		echo"<div class=\"alert alert-danger alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Failed to Signup </strong>.
</div>";
		
	}
	
	
	}
	}
	else{
		echo"<div class=\"alert alert-danger alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Wrong Entry !</strong> Missmatched Passowrds .
</div>";
	}
}



if (isset($_GET["logout"])){

    setcookie("username","12",1);
    setcookie("stat","logged out",1);
    session_start();
    session_destroy() ;
header("location:index.php");

		


}
if (isset($_POST["login"])){
	$uname = $_POST["uname"];
	$pass = $_POST["pass"];
	
	$result = mysqli_query($con,"select * from users where username = '$uname' and password = '$pass' ");
	if(mysqli_num_rows($result)> 0 ){
		
		setcookie("username","$uname",time() + 31536000000);
		setcookie("stat","logged" , time() + 31536000000);
    }
 if(isset($_COOKIE["cart_items"])){
              
                  $data = json_decode($_COOKIE["cart_items"],true);
                if(count(array($data))>0){
                 foreach($data as $cart_item_index => $P_id) {
                $query = mysqli_query($con,"select * from cart where username = '$uname' and P_id = '$P_id'; ");
                if(mysqli_num_rows($query)>0){
                continue;
                
                
                
                }
                else{
                 if(mysqli_query($con,"insert into cart (username , P_id) values ('$uname','$P_id')")){
                 
                 if(mysqli_query($con,"delete from wishlist where username = '$uname' and P_id = '$P_id' ;")){
                 continue;
                 }
                 }
                 
                
                
                }
                
                }
                
                }
                
              
                
                
               
                setcookie("cart_items", time() - 3600);
                }
		if(isset($_COOKIE["wishlist_items"])){
                
                $data = json_decode($_COOKIE["wishlist_items"],true);
                
                if(count($data)>0){
                      foreach($data as $cart_item_index => $P_id) {
                $query = mysqli_query($con,"select * from wishlist where username = '$uname' and P_id = '$P_id'; ");
                if(mysqli_num_rows($query)>0){
                continue;
                }
                else{
                
                
                 if(mysqli_query($con,"insert into wishlist (username , P_id) values ('$uname','$P_id')")){
                 
                 continue;
                 }
                 
                
                
                }
                
                }
                
                }
                
          
                setcookie("wishlist_item", time() - 3600);
                }
		
		header("location:cart.php");
		
		
	}
		else{

		$error ="<div class=\"alert alert-danger alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable To Login!</strong> Either Username Or Password is wrong . Try Again!.
</div>";

	
	}

	
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login And Sign up</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="eCommerce HTML Template Free Download" name="keywords">
        <meta content="eCommerce HTML Template Free Download" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
		    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
       
        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <a href="product-list.php" class="nav-item nav-link">Products</a>
                            <a href="product-detail.php" class="nav-item nav-link">Product Detail</a>
                            <a href="cart.php" class="nav-item nav-link">Cart</a>
                            <a href="checkout.php" class="nav-item nav-link">Checkout</a>
                            <a href="my-account.php" class="nav-item nav-link">My Account</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">More Pages</a>
                                <div class="dropdown-menu">
                                    <a href="wishlist.php" class="dropdown-item">Wishlist</a>
                                    <a href="login.php" class="dropdown-item active">Login & Register</a>
                                    <a href="contact.php" class="dropdown-item">Contact Us</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item">Login</a>
                                    <a href="#" class="dropdown-item">Register</a>
                                </div>
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
                    <div class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Search">
                            <button><i class="fa fa-search"></i></button>
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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active">Login & Register</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Login Start -->
		<br>
		<ul class="nav nav-pills nav-justified" style="margin-left:10%; margin-right:10%">
                                   <li class="nav-item">
                            <a <?php if(isset($_GET["login"])){echo "class='nav-link active'";}else{echo "class='nav-link'";}?> data-toggle="pill" onClick="login();" color="white">Log In</a>
                                    </li>
								   <li class="nav-item">
                                         <a <?php if(isset($_GET["signup"])){echo "class='nav-link active'";}else{echo "class='nav-link'";} ?> data-toggle="pill" onClick="signup();" color="white">Sign Up</a>
                                    </li>
									
									</ul>
									
		
        <div class="login">
            <div class="container-fluid">
                <div class="row" >
                    <div class="col-lg-6" >    
                          <div id="login" class="login-form" <?php if(isset($_GET["signup"])){echo "style='display:none'";}?>>
                           <form action="login.php?login=true" method="post"> 
						   <div class="row">
							
                                <div class="col-md-6">
                                    <label>Username</label>
                                    <input class="form-control" name = "uname" type="text" placeholder="E-mail / Username">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name = "pass" type="password" placeholder="Password">
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount">
                                        <label class="custom-control-label" for="newaccount">Keep me signed in</label>
                                    </div>
                                </div>
<?php

echo"$error";
								
								?>
								                       
                                <div class="col-md-12">
                                    <button type="submit" class="btn" name="login"> Submit</button>
                                </div>
								
                            </div>
							</form>
                        </div>
                    </div>
                    <div class="col-lg-6" >
                      <div  id="signup" class="register-form" <?php if(isset($_GET["login"])){echo "style='display:none'";}?>>
                          <form action="login.php" method="post" > 
						  <div class="row">
							
							
                                <div class="col-md-6">
                                    <label>full Name</label>
                                    <input class="form-control" name="fullname" type="text" placeholder="First Name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" name="email" id="email" type="email" placeholder="E-mail">
                                </div>
							
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control"  name="phone" type="text" placeholder="Mobile No" required>
                                </div>
								<div class="col-md-6">
                                    <label>UserName</label>
                                    <input class="form-control" name="username" type="text" placeholder="Last Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name="pass1" type="text" placeholder="Password" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Retype Password</label>
                                    <input class="form-control" name="pass2" type="text" placeholder="Password" required>
                                </div>
								
								<?php echo"$error2";?>
								
                                <div class="col-md-12">
                                    <button  type="submit" class="btn" name="signup">Submit</button>
                                </div>
								
                            </div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	
        <!-- Login End -->
        <script>
					
				
function login(){
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
        <!-- Footer Start -->
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
        </div><!-- Footer End -->
        
     
        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>
</html>
