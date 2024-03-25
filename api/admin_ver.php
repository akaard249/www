<?php

if (isset($_COOKIE["type"])){
$user_type = $_COOKIE["type"];
if($user_type == 1){
	
	header("location: index.php");
}
}
else{
header("location: /login.php");
die();
}

?>