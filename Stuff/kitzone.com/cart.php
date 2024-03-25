<?php
$error = "";
if(isset($_GET["language"]) && $_GET["language"]=="ar"){
	setcookie("language","arabic",time() + 31536000000);
	header("location:cart.php");
}
elseif(isset($_GET["language"]) && $_GET["language"]=="en"){
	setcookie("language","English",time() + 31536000000);
	header("location:cart.php");
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



include ('conn.php');
if(isset($_COOKIE["username"])){
	$username = $_COOKIE["username"];
	$result = mysqli_query($con , "select  cart.P_id , count(cart.cart_item_id) ,cart.cart_item_id, cart.P_size , cart.P_name , cart.P_company , cart.p_color, products.P_price , images.swipe  from cart inner join products on products.P_name = cart.P_name and products.P_company = cart.P_company inner join images on images.P_id = cart.P_id where cart.username = '$username' ");




}
// Del
if (isset($_GET["del"])){
    $cart_item_id = $_GET["del"];

if(isset($_COOKIE["username"])){
   if( $del_result = mysqli_query($con , "delete from cart where username = '$username' and cart_item_id = '$cart_item_id'")){
       header("location:cart.php");
   }
   else{
   
$error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to delete from the cart!</strong>! alshajjar alnabag.
</div>";
   }
}

else{

if(isset($_COOKIE["cart_items"])){

$items = json_decode($_COOKIE["cart_items"],true);

unset($items["$p_name"]);
setcookie("cart_items",json_encode($items),time() + 31536000000);
header("location:cart.php");
$error = "<div class=\"alert alert-success alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to delete from the cart!</strong>!.
</div>";
}
else{
$error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>unable to delete from the cart!</strong>!.
</div>";
}


}

}



//Add

if(isset($_GET["P_name"]) && isset($_GET["P_company"])){
	$P_company = $_GET["P_company"];
        $P_name = $_GET["P_name"];
        if(isset($_COOKIE["username"])){
        if(isset($_GET["P_color"]) && isset($_GET["P_size"])){
        
        $error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to add to the carty!</strong> ".$lang["cartwarning"]." !.
</div>";
        }
        else{
	$id_fetch = mysqli_query($con,"select P_id from products where P_name = '$P_name' and P_company = '$P_company'");
        if (mysqli_num_rows($id_fetch)>0){
        $P_id = 0;
        while($row = mysqli_fetch_assoc($id_fetch)){
        $P_id = $row["P_id"];
        $check = mysqli_query($con, "select * from cart where username = '$username' and P_id = '$P_id'");
       
        if (mysqli_num_rows($check)<1){break;}
        
        }
        
        }
        
        if($P_id == 0 ){
         $error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to add to the carty!</strong> ".$lang["cartwarning"]." !.
</div>";
        }
        else{
        
        if($ins_result = mysqli_query($con , "INSERT INTO `cart` (`cart_item_id`, `username`, `P_company` , `P_name`,`P_id`) VALUES (NULL, '$username', '$P_company' , '$P_name','$P_id');")){
	   header("location:cart.php");
	}	
	else{
		
	echo"alert('".mysqli_error($con)."');";	
	}
}
	}
	}
	else{
	if(isset($_COOKIE["cart_items"])){
        if(isset($_COOKIE["wishlist_items"])){
$wishlist_arr = json_decode($_COOKIE["wishlist_items"],true);
if(isset($wishlist_arr["$P_id"])){
unset($wishlist_arr["$P_id"]);
setcookie("wishlist_items",json_encode($wishlist_arr),time() + 31536000000);
}
}
        $items=array();
$items = json_decode($_COOKIE["cart_items"],true);

     if(isset($items["$P_id"])){
$error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to add to the cart!</strong> ".$lang["cartwarning"]." !.
</div>";
}
else{


$items["$P_id"] = "$P_id" ;
setcookie("cart_items",json_encode($items),time() + 31536000000);
header("location:cart.php");
}
}
else{
if(isset($_COOKIE["wishlist_items"])){
$wishlist_arr = json_decode($_COOKIE["wishlist_items"],true);
if(isset($wishlist_arr["$P_id"])){
unset($wishlist_arr["$P_id"]);
setcookie("wishlist_items",json_encode($wishlist_arr),time() + 31536000000);
}
}
$items=array();
$items["$P_id"] = "$P_id" ;

setcookie("cart_items",json_encode($items),time() + 31536000000);
header("location:cart.php");
}
}
	
	
}



?>



<!DOCTYPE html>
<html lang="en">
    <head>
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <meta charset="utf-8">
        <title>KitZone - Cart </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="KitZone-Cart" name="keywords">
        <meta content="cart" name="description">

        <!-- Favicon -->
        <link href="img/favico.png" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
	
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">
			  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
			  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <div id="boo">
	
        <!-- Top bar Start -->
      <div id="alert"><?php 
	  echo"$error";
	  
	  ?>
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
                            <a href="index.php" class="nav-item nav-link"><?php echo$lang["home"]; ?></a>
                            <a href="product-list.php" class="nav-item nav-link"><?php echo$lang["products"]; ?></a>
                            <a href="product-detail.php" class="nav-item nav-link"><?php echo$lang["product-details"]; ?></a>
                            <a href="cart.php" class="nav-item nav-link active"><?php echo$lang["cart"]; ?></a>
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
                  <div class="col-md-6">
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
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><?php echo$lang["home"];?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo$lang["products"];?></a></li>
                    <li class="breadcrumb-item active"><?php echo$lang["cart"];?></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Cart Start -->
        <div class="cart-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-page-inner">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th><?php echo$lang["product"];?></th>
                                            <th><?php echo$lang["price"];?></th>
                                            <th><?php echo$lang["color"];?></th>
                                            <th><?php echo$lang["size"];?></th>
                                            <th><?php echo$lang["buynow"];?></th>
                                            <th><?php echo$lang["remove"];?></th>
                                        </tr>




                                    </thead>
                                    <tbody class="align-middle">
                                    <?php
										$total = 0;
                                   if(isset($_COOKIE["username"])){
                                    while($cart_item  = mysqli_fetch_assoc($result)){
                                    
                                    $colors  = mysqli_query($con,"select P_color from products where P_name = '$cart_item[P_name]' and P_company = '$cart_item[P_company]' and P_color <> '$cart_item[p_color]' group by P_color ");	
                                    $sizes  = mysqli_query($con,"select P_size from products where P_name = '$cart_item[P_name]' and P_company = '$cart_item[P_company]' and P_size <> '$cart_item[P_size]' group by P_size ");	
                                    
                                        echo"
                                        <tr>
                                            <td>
                                                <div class=\"img\">
                                                    <a href=\"#\"><img src=\"data:image/jpg;charset=utf8;base64,base64_encode($cart_item[swipe])\ alt=\"Image\"></a>
                                                    <p>".$cart_item["P_name"]."</p>
                                                </div>
                                            </td>
                                            <td>".$cart_item["P_price"]."</td>
                                            
                                            
                                            
                                            
                                            
                                            <td><select id='color$cart_item[cart_item_id]'> <option value='$cart_item[p_color]'>$cart_item[p_color]</option>
                                            ";
                                        
                                            while($fetch_colors = mysqli_fetch_assoc($colors)){
                                            echo"<option value='$fetch_colors[P_color]'> $fetch_colors[P_color] </option>";
                                            }
                                            echo"</select></td>
                                            
                                            
                                            
                                            
                                            
                                            
                                          <td><select id = 'size$cart_item[cart_item_id]' > <option value='$cart_item[P_size]'>$cart_item[P_size]</option>
                                            ";
                                        
                                            while($fetch_colors = mysqli_fetch_assoc($sizes)){
                                            echo"<option value='$fetch_colors[P_size]'> $fetch_colors[P_size] </option>";
                                            }
                                            echo"</select></td>
                            <td><a href='checkout.php?P_id=$cart_item[cart_item_id]' class='btn cart'>
                                <i class='fa fa-shopping-cart'></i>

                            </a></td>
                                            
                                           
                                            <td><a href='cart.php?del=$cart_item[cart_item_id]'><button><i class=\"fa fa-trash\"></i></button> </a></td>
                                        </tr>
										
					<script>
        $(document).ready(function(){
        
        
        \$('#color$cart_item[cart_item_id]').on('change', function(){ 
    var color = \$(this).val();
    var P_name = '$cart_item[P_name]';
    var P_company = '$cart_item[P_company]';
    $.ajax({
        type: 'POST',
        url: 'cart_select.php', // this is your target page where post will go
        data: {color:color, P_name:P_name , P_company:P_company},
        success: function (response) {
            console.log(response); // here you can get response
        }

    });


})


\$('#size$cart_item[cart_item_id]').on('change', function(){ 
    var size = \$(this).val();
    var name = '$cart_item[P_name]';
    var company = '$cart_item[P_company]';
    $.ajax({
        type: 'POST',
        url: 'cart_select.php', // this is your target page where post will go
        data: {size:size, P_name:name , P_company:company},
        success: function (response) {
            console.log(response); // here you can get response
        }

    });


})

     });   
        </script>
        
        
        
        
                                        ";
										$total = $total + $cart_item["P_price"];

                                    
                                    }
                                    }
                                    else{

if(isset($_COOKIE["cart_items"])){
$data = json_decode($_COOKIE["cart_items"],true);

foreach($data as $cart_item_idex => $P_id) {


$result = mysqli_query($con,"select products.p_id , products.P_size , products.p_name , products.p_color, products.P_price , images.swipe  from products inner join images on images.p_id = products.p_id where products.p_id = '$P_id'"); 
$cart_item = mysqli_fetch_assoc($result);

echo"
                                        <tr>
                                            <td>
                                                <div class=\"img\">
                                                    <a href=\"#\"><img src=\"data:image/jpg;charset=utf8;base64,".base64_encode($cart_item['swipe'])."\" alt=\"Image\"></a>
                                                    <p>".$cart_item["p_name"]."</p>
                                                </div>
                                            </td>
                                            <td>".$cart_item["P_price"]."</td>          <td>".$cart_item["p_color"]."</td>
                                            <td>
                                              
                                                
                                                    ".$cart_item["P_size"]."
                                                   
                                                </td>
                                            
                                            <td><a href='cart.php?del=$cart_item[p_id]'><button><i class=\"fa fa-trash\"></i></button> </a></td>
                                        </tr>
										
										
                                        ";
								$total = $total + $cart_item["P_price"];
}


}
else{
$data = array();




foreach($data as $cart_item_idex => $P_id) {

$result = mysqli_query($con,"select products.p_id , products.P_size , products.p_name , products.p_color, products.P_price , images.swipe  from products inner join images on images.p_id = products.p_id where products.p_id = '$P_id'"); 
$cart_item = mysqli_fetch_asso($result);

echo"
                                        <tr>
                                            <td>
                                                <div class=\"img\">
                                                    <a href=\"#\"><img src=\"data:image/jpg;charset=utf8;base64,".base64_encode($cart_item['swipe'])."\" alt=\"Image\"></a>
                                                    <p>".$cart_item["p_name"]."</p>
                                                </div>
                                            </td>
                                            <td>".$cart_item["P_price"]."</td>          <td>".$cart_item["p_color"]."</td>
                                            <td>
                                              
                                                
                                                    ".$cart_item["P_size"]."
                                                   
                                                </td>
                                            
                                            <td><a href='cart.php?del=$cart_item[p_id]'><button><i class=\"fa fa-trash\"></i></button> </a></td>
                                        </tr>
										
										
                                        ";
								$total = $total + $cart_item["P_price"];
}


}

}
                                    ?>





                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-page-inner">
                            <div class="row">
                           
                                <div class="col-md-12">
                                    <div class="cart-summary">
                                        <div class="cart-content">
                                            <h1><?php echo$lang["cartsummery"];?></h1>
                                            <p><?php echo$lang["subtotal"];?><span><?php echo$total?></span></p>
                                           
                                          
                                        </div>
                                        <div class="cart-btn">
                                        
                                            <a href="checkout.php?username=<?php echo $username;?>"><button class="form-action"><?php echo$lang["checkout"];?></button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart End -->
        
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
        <script>
        
        $('#status').on('change', function(){ 
    var color = $(this).val();
    var P_name = $(this).data('id');
    $.ajax({
        type: 'POST',
        url: 'somepage.php', // this is your target page where post will go
        data: {update:value, hidden:id},
        success: function (response) {
            console.log(response); // here you can get response
        }

    });


})
        
        </script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script src="js/search.js"></script>
    </body>
</html>
