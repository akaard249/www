<?php
//fetch.php
if(isset($_COOKIE["language"]) && $_COOKIE["language"]=="arabic"){
	
	include('ar.php');
}
elseif((isset($_COOKIE["language"]) && $_COOKIE["language"]=="English")){
	include('en.php');
}

$connect = mysqli_connect("localhost", "root", "", "samir");
$output = '';
if(isset($_POST["query"]))
{
	
 $search = mysqli_real_escape_string($connect, $_POST["query"]);
 if ($search == ""){
	 
 $query = "
  SELECt products.P_id , images.swipe , products.P_name , products.P_price from products 
  inner join images on images.P_id = products.P_id 
 
 
 ";
 }
 else{
	 $query = "
  SELECt products.P_id , images.swipe , products.P_name , products.P_price from products 
  inner join images on images.P_id = products.P_id 
  WHERE products.p_company LIKE '%".$search."%'
  OR products.p_name LIKE '%".$search."%' 
  OR products.p_type LIKE '%".$search."%' 
 
 "; 
	 
 }
}
else
{
 $query = "
SELECt products.P_id , images.swipe , products.P_name , products.P_price from products 
  inner join images on images.P_id = products.P_id 
 ";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_array($result))
 {
echo "
 <div class='col-md-4'>
                        <div class='product-item'>
                            <div class='product-title'>
                                <a href='product-detail.php?P_id=$row[P_id]'> $row[P_name] </a>
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
                                     <img src='data:image/jpg;charset=utf8;base64,".base64_encode($row['swipe'])."'>
                                </a>
                                <div class='product-action'>
                                    <a href='cart.php?P_id=$row[P_id]'><i class='fa fa-cart-plus'></i></a>
                                    <a href='#'><i class='fa fa-heart'></i></a>
                                    <a href='#'><i class='fa fa-search'></i></a>
                                </div>
                            </div>
                            <div class='product-price'>
                                <h3 style='color:white'><span>$</span> $row[P_price]</h3>
                                <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Buy Now</a>
                            </div>
                        </div>
                    </div> ";
 }

}
else
{
 echo 'Data Product Found';
}

?>