<?php 

if(isset($_COOKIE["language"]) && $_COOKIE["language"]=="arabic"){
	
	include('ar.php');
}
elseif((isset($_COOKIE["language"]) && $_COOKIE["language"]=="English")){
	include('en.php');
} 		

include('conn.php');
$username = $_COOKIE["username"];
//Delete function
if (isset($_GET["del"])){
    $p_name = $_GET["del"];

   if( $del_result = mysqli_query($con , "delete wishlist from wishlist inner join products on products.P_id = wishlist.p_id where wishlist.username = '$username' and products.P_id = '$p_name'")){
       header("location:wishlist.php");
   }
}

// insert function 
if(isset($_GET["P_id"])){
	$P_id = $_GET["P_id"];
	$check = mysqli_query($con,"select * from wishlist where username = '$username' and P_id = '$P_id';");
	if (mysqli_num_rows($check)){
	echo"<script>alert('".$lang["wishlistwarning"]."');";
echo 'window.location.href = "index.php";';
echo '</script>';
}
else{
	if($ins_result = mysqli_query($con , "INSERT INTO `wishlist` (`wishlist_id`, `username`, `p_id`) VALUES (NULL, '$username', '$P_id');")){
	   header("location:wishlist.php");
	}	
	else{
		
	echo"alert('".mysqli_error($con)."');";	
	}
	
}
}








?>