<?php 
include('conn.php');
$error="";
if(isset($_GET["language"]) && $_GET["language"]=="ar"){
	setcookie("language","arabic",time() + 31536000000);
	header("location:wishlist.php");
}
elseif(isset($_GET["language"]) && $_GET["language"]=="en"){
	setcookie("language","English",time() + 31536000000);
	header("location:wishlist.php");
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

// Del
if (isset($_GET["del"])){
    $P_id = $_GET["del"];
if(isset($_COOKIE["username"])){
$username = $_COOKIE["username"];
   if( $del_result = mysqli_query($con , "delete from wishlist where wishlist_id = '$P_id'")){
       header("location:wishlist.php");
   }
   else{
   
$error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to delete from the cart!</strong>!.
</div>";
   }
}

else{

if(isset($_COOKIE["wishlist_items"])){

$items = json_decode($_COOKIE["wishlist_items"],true);

unset($items["$p_name"]);
setcookie("wishlist_items",json_encode($items),time() + 31536000000);
header("location:wishlist.php");

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
           $username = $_COOKIE["username"];
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
        
        if($ins_result = mysqli_query($con , "INSERT INTO `wishlist` (`wishlist_id`, `username`, `P_company` , `P_name`,`P_id`) VALUES (NULL, '$username', '$P_company' , '$P_name','$P_id');")){
	   header("location:wishlist.php");
	}	
	else{
		
	echo"alert('".mysqli_error($con)."');";	
	}
}
	}
	}
	else{
	if(isset($_COOKIE["wishlist_items"])){
        $items=array();
$items = json_decode($_COOKIE["wishlist_items"],true);

     if(isset($items["$P_id"])){
$error = "<div class=\"alert alert-warning alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Unable to add to the wishlist!</strong> ".$lang["wishlistwarning"]." !.
</div>";
}
else{
$count = count($items);
$count++;

$items["$P_id"] = "$P_id" ;
setcookie("wishlist_items",json_encode($items),time() + 31536000000);
header("location:wishlist.php");
}
}
else{
$items=array();
$items["$P_id"] = "$P_id" ;

setcookie("wishlist_items",json_encode($items),time() + 31536000000);
header("location:wishlist.php");
}
}
	
	
}









if(isset($_COOKIE["username"])){
	$username = $_COOKIE["username"];
	$result = mysqli_query($con , "select distinct wishlist.P_id , wishlist.wishlist_id , wishlist.P_size , wishlist.P_name , wishlist.P_company , wishlist.P_color, products.P_price , images.swipe  from wishlist inner join products on products.P_name = wishlist.P_name and products.P_company = wishlist.P_company inner join images on images.P_id = wishlist.P_id where wishlist.username = '$username'");




}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <meta charset="utf-8">
        <title><?php echo$lang["wishlist"];?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Kitzone Online Store" name="keywords">
        <meta content="Kitzone Online Store" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Top bar Start -->
       <?php 
	  echo"$error";
	  
	  ?>
          <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
                    </div>
                    <div class="col-sm-6">
                     <a style = "color:#ffffff" href="wishlist.php?language=ar">اللغة العربية</a>
                     <a href="wishlist.php?language=en">English</a>
                 
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->
        
        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand"><?php echo$lang["menu"];?></a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                     <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link"><?php echo$lang["home"]; ?></a>
                            <a href="product-list.php" class="nav-item nav-link"><?php echo$lang["products"]; ?></a>
                            <a href="product-detail.php" class="nav-item nav-link"><?php echo$lang["product-details"]; ?></a>
                            <a href="cart.php" class="nav-item nav-link"><?php echo$lang["cart"]; ?></a>
                            <a href="checkout.php" class="nav-item nav-link"><?php echo$lang["checkout"]; ?></a>
                            
                           
 <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo$lang["morepages"]; ?></a>
                                <div class="dropdown-menu">
                                    <a href="wishlist.php" class="dropdown-item active"><?php echo$lang["wishlist"]; ?></a>
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
                                  <span>(<?php 
								if(isset($_COOKIE["username"])){
								$wl_count = mysqli_query($con,"select * from wishlist where username = '$username';");
								echo "(".mysqli_num_rows($wl_count).")";
								}
                                                                elseif(isset($_COOKIE["wishlist_items"])){
                                                               $wishlistcount =  json_decode($_COOKIE["wishlist_items"],true);
                                                                echo count($wishlistcount);
                                                                }
                                                                else{
                                                                
                                                                echo"0";
                                                                }
								
								
								
								?>)</span>
                            </a>
                            <a href="cart.php" class="btn cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>(<?php 
								if(isset($_COOKIE["username"])){
								$cart_count = mysqli_query($con,"select * from cart where username = '$username';");
								echo "(".mysqli_num_rows($cart_count).")";
								}
                                                                  elseif(isset($_COOKIE["cart_items"])){
                                                                $cartcount =  json_decode($_COOKIE["cart_items"],true);
                                                                echo count($cartcount);
                                                                }
								else{
									echo"0";
									
								}
								
								?>)</span>
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
                    <li class="breadcrumb-item active"><?php echo$lang["search"];?></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Wishlist Start -->
        <div class="wishlist-page">
            <div class="container-fluid">
                <div class="wishlist-page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th><?php echo$lang["product"];?></th>
                                            <th><?php echo$lang["price"];?></th>
                                           <th><?php echo$lang["color"];?></th>
                                            <th><?php echo$lang["size"];?></th>
                                            <th><?php echo$lang["addtocart"];?></th>
                                            <th><?php echo$lang["remove"];?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
<?php 

 if(isset($_COOKIE["username"])){
while($wishlist= mysqli_fetch_assoc($result)){
   $colors  = mysqli_query($con,"select P_color from products where P_name = '$wishlist[P_name]' and P_company = '$wishlist[P_company]' and P_color <> '$wishlist[p_color]' group by P_color ");	
                                    $sizes  = mysqli_query($con,"select P_size from products where P_name = '$wishlist[P_name]' and P_company = '$wishlist[P_company]' and P_size <> '$wishlist[P_size]' group by P_size ");	
echo"	
									   <tr>
                                            <td>
                                                <div class='img'>
                                                    <a href='#'> <img src='data:image/jpg;charset=utf8;base64,".base64_encode($wishlist['swipe'])."'></a>
                                                    <p>$wishlist[p_name]</p>
                                                </div>
                                            </td>
                                            <td>$wishlist[P_price]</td>
                                            <td><select id='color$wishlist[wishlist_item_id]'> <option value='$wishlist[P_color]'>$wishlist[P_color]</option>
                                            ";
                                        
                                            while($fetch_colors = mysqli_fetch_assoc($colors)){
                                            echo"<option value='$fetch_colors[P_color]'> $fetch_colors[P_color] </option>";
                                            }
                                            echo"</select></td>
                                            
                                            
                                            
                                            
                                            
                                            
                                          <td><select id = 'size$wishlist[cart_item_id]' > <option value='$wishlist[P_size]'>$wishlist[P_size]</option>
                                            ";
                                        
                                            while($fetch_colors = mysqli_fetch_assoc($sizes)){
                                            echo"<option value='$fetch_colors[P_size]'> $fetch_colors[P_size] </option>";
                                            }
                                            echo"</select></td>
                                            
                                           

                                        <
										
					<script>
        $(document).ready(function(){
        
        
        \$('#color$wishlist[wishlist_item_id]').on('change', function(){ 
    var color = \$(this).val();
    var P_name = '$wishlist[P_name]';
    var P_company = '$wishlist[P_company]';
    $.ajax({
        type: 'POST',
        url: 'wishlist_select.php', // this is your target page where post will go
        data: {color:color, P_name:P_name , P_company:P_company},
        success: function (response) {
            console.log(response); // here you can get response
        }

    });


})


\$('#size$wishlist[wishlist_item_id]').on('change', function(){ 
    var size = \$(this).val();
    var name = '$wishlist[P_name]';
    var company = '$wishlist[P_company]';
    $.ajax({
        type: 'POST',
        url: 'wishlist_select.php', // this is your target page where post will go
        data: {size:size, P_name:name , P_company:company},
        success: function (response) {
            console.log(response); // here you can get response
        }

    });


})

     });   
        </script>
                                            <td><a href='cart.php?P_id=$wishlist[p_id]&P_name=$wishlist[P_name]&P_company=$wishlist[P_company]' >Add to Cart</button> </a></td>
                                            <td><a href='wishlist.php?del=$wishlist[wishlist_id]' ><button><i class='fa fa-trash'></i></button></a></td>
                                        </tr>
                                       ";
}
}
else{
if(isset($_COOKIE["wishlist_items"])){
$data = json_decode($_COOKIE["wishlist_items"],true);

foreach($data as $cart_item_idex => $P_id) {


$result = mysqli_query($con,"select products.p_id , products.P_size , products.p_name , products.p_color, products.P_price , images.swipe  from products inner join images on images.p_id = products.p_id where products.p_id = '$P_id'"); 
$wishlist_item = mysqli_fetch_assoc($result);

echo"
                                        <tr>
                                            <td>
                                                <div class=\"img\">
                                                    <a href=\"#\"><img src=\"data:image/jpg;charset=utf8;base64,".base64_encode($wishlist_item['swipe'])."\" alt=\"Image\"></a>
                                                    <p>".$wishlist_item["p_name"]."</p>
                                                </div>
                                            </td>
                                            <td>".$wishlist_item["P_price"]."</td>          <td>".$wishlist_item["P_color"]."</td>
                                            <td>
                                              
                                                
                                                   <td> ".$wishlist_item["P_size"]."
                                                   
                                                </td>
                                           <td><a href='cart.php?P_id=$wishlist_item[p_id]' > <button  class='btn-cart'>Add to Cart</button> </a></td>
                                            <td><a href='wishlist.php?del=$wishlist_item[P_id]'><button><i class=\"fa fa-trash\"></i></button> </a></td>
                                        </tr>
										
										
                                        ";
								$total = $total + $wishlist_item["P_price"];
}


}
else{
$data = array();




foreach($data as $wishlist_item_index => $P_id) {

$result = mysqli_query($con,"select products.p_id , products.P_size , products.p_name , products.p_color, products.P_price , images.swipe  from products inner join images on images.p_id = products.p_id where products.p_id = '$P_id'"); 
$wishlist_item = mysqli_fetch_asso($result);

echo"
                                        <tr>
                                         <td>
                                                 <div class=\"img\">
                                                    <a href=\"#\"><img src=\"data:image/jpg;charset=utf8;base64,".base64_encode($wishlist_item['swipe'])."\" alt=\"Image\"></a>
                                                    <p>".$wishlist_item["p_name"]."</p>
                                                        </div>
                                        </td>
                                        <td>".$wishlist_item["P_price"]."</td>
                                        <td>".$wishlist_item["P_color"]."</td>
                                        <td>".$wishlist_item["P_size"]."</td>
                                        <td><a href='cart.php?P_id=".$wishlist_item["p_id"]."' > <button  class='btn-cart'>Add to Cart</button> </a></td>
                                        <td><a href='cart.php?del=$wishlist_item[p_id]'><button><i class=\"fa fa-trash\"></i></button> </a></td>
                                        </tr>
										
										
                                        ";
								$total = $total + $wishlist_item["P_price"];
}



}


}
?>

								  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wishlist End -->
        
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
