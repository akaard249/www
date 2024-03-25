<?php



if (!isset($_GET["P_id"])){
	header("location:product-list.php");
	
}
include('conn.php');
if(isset($_GET["P_id"])){
	$P_id = $_GET["P_id"];
	$query = mysqli_query($con,"select P_name,P_price,P_company,P_color,details  from products where P_id = '$P_id'");
	$row = mysqli_fetch_assoc($query);
	$p_name = $row["P_name"];
	$p_color = $row["P_color"];
	$p_company = $row["P_company"];
	
	$cl_query = mysqli_query($con,"select * from products where P_name = '$p_name' group by P_color");

		if(isset($_GET["color"])){
	$sz_query = mysqli_query($con,"select * from products where P_name = '$p_name' and P_color = '$_GET[color]' group by P_size");

			
			
		}
		
		
		if(isset($_GET["color"])){
			
			if(isset($_GET["size"])){
			$p_size = $_GET["size"];	
			$p_color = $_GET["color"];
			
$image_id_query = mysqli_query($con,"select P_id from products where P_name = '$p_name' and P_size = '$p_size' and  P_color = '$p_color' ");
$quantity_query = mysqli_query($con,"select count(P_id) from products where P_name = '$p_name' and P_size = '$p_size' and  P_color = '$p_color' ");
$quan_row = mysqli_fetch_array($quantity_query);
$quan = $quan_row[0];
$id_row = mysqli_fetch_array($image_id_query);
$id = $id_row["P_id"];

$image_query = mysqli_query($con,"select * from images where p_name='$p_name' and P_company='$p_company' and P_color = '".$_GET['color']."' ");
	$img_row = mysqli_fetch_assoc($image_query);
			}
			else{
				$p_color = $_GET["color"];
				$image_id_query = mysqli_query($con,"select P_id from products where P_name = '$p_name'  and P_color = '$p_color' ");
$id_row = mysqli_fetch_array($image_id_query);
$id = $id_row["P_id"];
				
				$image_query = mysqli_query($con,"select * from images where p_name='$p_name' and P_company='$p_company' and P_color = '".$_GET['color']."' ");
	$img_row = mysqli_fetch_assoc($image_query);
			}
		}
		else{
			
			$image_query = mysqli_query($con,"select * from images where p_id='$P_id' and P_company='$p_company' ");
	$img_row = mysqli_fetch_assoc($image_query);
	
			
		}

	
	
	
	
	
	
	
}
if(isset($_GET["language"]) && $_GET["language"]=="ar"){
	setcookie("language","arabic",time() + 31536000000);
	header("location:product-detail.php?P_id=$P_id");
}
elseif(isset($_GET["language"]) && $_GET["language"]=="en"){
	setcookie("language","English",time() + 31536000000);
	header("location:product-detail.php?P_id=$P_id");
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
?>

<?php 
// our brands code 


$brand_result = mysqli_query($con,"select P_company , count(P_id) from products group by P_company");





?>

<?php
//related products
$related_result = mysqli_query($con,"select products.P_id , products.P_name , products.P_price , images.swipe from images inner join products on images.P_id = products.P_id where products.P_company = '$p_company'  ");



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

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
       <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">

    </head>

     
     


    <body>

        <div id="boo">
		
		<!-- Top bar Start -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
                    </div>
                    <div class="col-sm-6">
                     <a href="product-detail.php?language=ar&P_id=<?php echo$P_id; ?>">اللغة العربية</a>
                     <a href="product-detail.php?language=en&P_id=<?php echo$P_id; ?>">English</a>
                 
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
                            <a href="product-detail.php" class="nav-item nav-link active" ><?php echo$lang["product-details"]; ?></a>
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
                    <li class="breadcrumb-item active"><?php echo$lang["product-details"];?></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product Detail Start -->
        <div class="product-detail">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="product-detail-top">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="product-slider-single normal-slider">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["swipe"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["front"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["side_a"]); ?>" alt="Product Image">
                                         <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["swipe"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["front"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["side_a"]); ?>" alt="Product Image">
                                        
                                       
                                    </div>
                                    <div class="product-slider-single-nav normal-slider">
                                         <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["swipe"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["front"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["side_a"]); ?>" alt="Product Image">
                                      <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["swipe"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["front"]); ?>" alt="Product Image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($img_row["side_a"]); ?>" alt="Product Image">
                                     
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="product-content"  id="colo">
                                        <div class="title"><h2><?php echo"$p_name";?></h2></div>
                                        <div class="ratting">
                                           <a> <i class="fa fa-star"></i></a>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="price">
                                            <h4><?php echo$lang["price"];?>:</h4>
                                            <p><?php echo$row["P_price"];?></p>
                                        </div>
                                       
                                      
                                        <div class="p-color">
                                            <h4><?php echo$lang["color"];?>:</h4>
                                            <div class="btn-group btn-group-sm">
                                               <?php 
											   while($cl_row = mysqli_fetch_assoc($cl_query)){
												   
												   
												   if($cl_row["P_color"] == $p_color){
													 echo"   <a href='product-detail.php?P_id=$cl_row[P_id]&color=$cl_row[P_color]'> <button       style = 'background:$cl_row[P_color]; color:#ffffff; border-radius: 50%' type='button' class='btn' > <i class='fa fa-check'></i> </button> </a> <pre> </pre>"   ;
												   }
												   else{
													   echo"   <a href='product-detail.php?P_id=$cl_row[P_id]&color=$cl_row[P_color]'> <button style = 'background:$cl_row[P_color] ;  border-radius: 50% 	' type='button' class='btn' ><i class='fa fa-circle' style='color:$cl_row[P_color]'></i></button> </a><pre> </pre>"   ;
													   
												   }
												   
											   }
											   
											   
											   ?>
                                            </div> 
                                        </div>
										  <?php 
											  if(isset($_GET["color"])){
										
										echo"
										  <div class='p-size'>
                                            <h4>".$lang["size"].":</h4>
                                            <div class='btn-group btn-group-sm'>
											";
                                                 while($sz_row = mysqli_fetch_assoc($sz_query)){
													 if(isset($_GET["size"]) && $_GET["size"] == $sz_row["P_size"]){
												echo"   <a href='product-detail.php?P_id=$P_id&color=".$_GET['color']."&size=".$sz_row['P_size']."' ><button style = 'background:#063F5D ; color:#ffffff'  type='button' class='btn'> $sz_row[P_size] </button> </a>"   ;
													 }
													 else{
														 
												echo"<a href='product-detail.php?P_id=$P_id&color=".$_GET['color']."&size=".$sz_row['P_size']."' ><button  type='button' class='btn'> $sz_row[P_size] </button> </a>"   ;
													 }
												   
											   }
											  echo"
                                            </div> 
                                        </div>
										";
											  }
										
											   
											   
								  if(isset($_GET["color"]) && isset($_GET["size"])){
											   
										 echo"<div class='quantity'>
                                            <h4>".$lang["quantity"].":</h4>
                                            <div class='qty'>
                                             
                                                <input type='number' min = '1' max='$quan'>
											
                                                
											
                                            </div>
                                        </div>";
								  }
										   ?>
										
                                        <div class="action">
                                            <a class="btn" href="<?php
                                            if (isset($_GET["P_id"]) && isset($_GET["size"]) && isset($_GET["color"])){
                                                echo"cart.php?P_id=".$_GET["P_id"];
}
                                            else{

                                                echo"#";
                                            }

                                            ?>"><i class="fa fa-shopping-cart"></i><?php echo$lang["addtocart"];?></a>
                                            <a class="btn" href="#"><i class="fa fa-shopping-bag"></i><?php echo$lang["buynow"];?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row product-detail-bottom">
                            <div class="col-lg-12">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#description"><?php echo$lang["discription"];?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#reviews">Reviews (1)</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="description" class="container tab-pane active">
                                        <h4><?php echo$lang["discription"];?></h4>
                                        <p><?php echo $row["details"];?>
                                       </p>
                                    </div>
                                    <div id="specification" class="container tab-pane fade">
                                        <h4>Product specification</h4>
                                        <ul>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                        </ul>
                                    </div>
                                    <div id="reviews" class="container tab-pane fade">
                                        <div class="reviews-submitted">
                                            <div class="reviewer">Phasellus Gravida - <span>01 Jan 2020</span></div>
                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <p>
                                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
                                            </p>
                                        </div>
                                        <div class="reviews-submit">
                                            <h4>Give your Review:</h4>
                                            <div class="ratting">
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="row form">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Name">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="email" placeholder="Email">
                                                </div>
                                                <div class="col-sm-12">
                                                    <textarea placeholder="Review"></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button>Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="product">
                            <div class="section-header">
                                <h1><?php echo$lang["relatedproducts"];?></h1>
                            </div>

                            <div class="row align-items-center product-slider product-slider-3">
                                <?php 
								$i= 1;
								while($related = mysqli_fetch_array($related_result)){
									
									echo"
								<div class='col-lg-3'>
                        <div class='product-item'>
                            <div class='product-title'>
                                <a href='product-detail.php?P_id=$related[P_id]'> $related[P_name] $i </a>
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
                                     <img height = '' src='data:image/jpg;charset=utf8;base64,".base64_encode($related['swipe'])."'>
                                </a>
                                <div class='product-action'>
                                    <a href='#'><i class='fa fa-cart-plus'></i></a>
                                    <a href='#'><i class='fa fa-heart'></i></a>
                                    <a href='#'><i class='fa fa-search'></i></a>
                                </div>
                            </div>
                            <div class='product-price'>
                                <h3 style='color:white'><span>$</span> $related[P_price]</h3>
                                <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Buy Now</a>
                            </div>
                        </div>
                    </div>";
								}
								?>
                                
								
                        </div>
                    </div>
                    <br>
                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                  
                 
                        <div class="sidebar-widget brands">
                            <h2 class="title"><?php echo$lang["ourbrands"];?></h2>
							
                            <ul>
							<?php
							while($row = mysqli_fetch_array($brand_result)){
								$count = $row['count(P_id)'] ;
							echo"	
                                <li><a href='#'>".$row["P_company"]." </a><span>(".$count.")</span></li>
                              
							";
							}
								?>
                            </ul>
                        </div>
                        
                    
				   </div>
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        <!-- Product Detail End -->
        </div>
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
		
	</div>
	<div class='spinner-wrapper' id = "loader">
		<div class="spinner"></div>
		</div>
		
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
    </body>
</html>
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
