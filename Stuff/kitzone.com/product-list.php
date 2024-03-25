<?php 
include('conn.php');

if(isset($_GET["language"]) && $_GET["language"]=="ar"){
	setcookie("language","arabic",time() + 31536000000);
	header("location:product-list.php");
}
elseif(isset($_GET["language"]) && $_GET["language"]=="en"){
	setcookie("language","English",time() + 31536000000);
	header("location:product-list.php");
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
if(isset($_COOKIE["username"])){
$username = $_COOKIE["username"];

}

//fetching code 
if(isset($_GET["search_key"])){
	$search = $_GET["search_key"];
$products = mysqli_query($con,"SELECt products.P_id , images.swipe ,products.p_company , products.p_type, products.P_name , products.P_price from products INNER JOIN images ON products.P_id = images.P_id   WHERE products.P_company LIKE '%".$search."%'
  OR products.p_name LIKE '%".$search."%' 
  OR products.p_type LIKE '%".$search."%'");
	
	
}
else{
$products = mysqli_query($con,"SELECt products.P_id , images.swipe , products.P_name , products.P_price from products INNER JOIN images ON products.P_id = images.P_id");
}


// our brands code 


$brand_result = mysqli_query($con,"select P_company , count(P_id) from products group by P_company");


if(isset($_GET["error"]) && $_GET["error"] == "cart"){

echo"<div class=\"alert alert-alert alert-dismissible\">
  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>can't make a cart </strong> You Have To Log In First !
</div>";
}


?>




	
	
	
	







<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KitZone - products list</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="KitZone" name="keywords">
        <meta content="KitZone Store" name="description">

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
    <!-- Top bar Start -->
       <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
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
                            <a href="product-list.php" class="nav-item nav-link active" ><?php echo$lang["products"]; ?></a>
                            <a href="product-detail.php" class="nav-item nav-link"><?php echo$lang["product-details"]; ?></a>
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
                                                                
                                                                echo"(5)";
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
                    <li class="breadcrumb-item"><a href="index.php"><?php echo$lang["home"];?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo$lang["products"];?></a></li>
                    <li class="breadcrumb-item active"><a href="product-list.php"<?php echo$lang["product-list"];?></a></li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product List Start -->
        <div class="product-view">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-view-top">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="product-search">
                                                <input type="text" placeholder="<?php echo$lang["search"];?>" id="search_k">
                                                <button><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-short">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" data-toggle="dropdown"><?php echo$lang["sort"];?></div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" onClick="sortByNewest()" class="dropdown-item"><?php echo$lang["newest"];?></a>
                                                        <a href="#" class="dropdown-item"><?php echo$lang["popular"];?></a>
                                                        <a href="#" class="dropdown-item"><?php echo$lang["bestselling"];?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-price-range">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" data-toggle="dropdown"><?php echo$lang["pricerange"];?></div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item">$0 to $50</a>
                                                        <a href="#" class="dropdown-item">$51 to $100</a>
                                                        <a href="#" class="dropdown-item">$101 to $150</a>
                                                        <a href="#" class="dropdown-item">$151 to $200</a>
                                                        <a href="#" class="dropdown-item">$201 to $250</a>
                                                        <a href="#" class="dropdown-item">$251 to $300</a>
                                                        <a href="#" class="dropdown-item">$301 to $350</a>
                                                        <a href="#" class="dropdown-item">$351 to $400</a>
                                                        <a href="#" class="dropdown-item">$401 to $450</a>
                                                        <a href="#" class="dropdown-item">$451 to $500</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						
						<div id="searchq">
                            
							</div>
							<div id="all">
							<?php 
							while($list = mysqli_fetch_assoc($products)){
							echo"
							
							<div class='col-md-4'>
                        <div class='product-item'>
                            <div class='product-title'>
                                <a href='product-detail.php?P_id=$list[P_id]'> $list[P_name] </a>
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
                                     <img src='data:image/jpg;charset=utf8;base64,".base64_encode($list['swipe'])."'>
                                </a>
                                <div class='product-action'>
                                    <a href='cart.php?P_id=$list[P_id]'><i class='fa fa-cart-plus'></i></a>
                                    <a href='wishlist_op.php?P_id=$list[P_id]'><i class='fa fa-heart'></i></a>
                                  
                                </div>
                            </div>
                            <div class='product-price'>
                                <h3 style='color:white'><span>$</span> $$list[P_price]</h3>
                                <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Buy Now</a>
                            </div>
                        </div>
                    </div> 
                      
							
							";	
								
							}
							?>
                            
							</div>
					  </div>
                        
                        <!-- Pagination Start -->
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"><?php echo$lang["previous"];?></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><?php echo$lang["next"];?></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination Start -->
                    </div>           
                    
                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-widget category">
                            <h2 class="title"><?php echo$lang["categories"];?></h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                     <li class="nav-item">
                                    <a class="nav-link" href="product-list.php?search_key=Slipper"><i class="fa fa-home"></i><?php echo$lang["slippers"]; ?></a>
                                </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="product-list.php?search_key=Sneaker"><span class="icon icon-accessibility" > . </span></i><?php echo$lang["sneakers"]; ?></a>
                                </li>
                             <li class="nav-item">
                                    <a class="nav-link" href="product-list.php?search_key=Jersy"><i class="	fas fa-futbol"></i><?php echo$lang["footballjersies"]; ?></a>
                                </li>
                                </ul>
                            </nav>
                        </div>
                        
                        
                        
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
        <!-- Product List End -->  
        
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
                    
                    
                    <div class="col-lg-3 col-md-8">
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
      
        <script src="js/plist.js"></script>
		<script>
 var div  = document.getElementById('result');
 	div.style.display = 'none';
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

</script>

    </body>
</html>
