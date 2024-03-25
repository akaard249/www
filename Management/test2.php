<?php
$con = mysqli_connect("localhost","root","root","najahat_db");

	
	$user_cpr = "1738";
	$hashed_password = password_hash( "1738", PASSWORD_DEFAULT );
	$sql = $con -> prepare("UPDATE users set user_password = ? where user_cpr = ?");
	$sql -> bind_param("si", $hashed_password, $user_cpr );
	$sql -> execute();
echo"success";
