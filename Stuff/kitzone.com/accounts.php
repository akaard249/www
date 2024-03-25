<?php
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
		
		
		
	if ($email == ""){
		$query = "insert into `users` (`username`, `FullName`, `password`, `phone`, `email`) VALUES ('$uname', '$fname', '$pass', '$phone', NULL);";
	}
	else{
		$query = "insert into `users` (`username`, `FullName`, `password`, `phone`, `email`) VALUES ('$uname', '$fname', '$pass', '$phone', '$email');";
	}
	
	if (mysqli_query($con,$query)){
		
		setcookie("username","$uname",time() + 31536000000);
		setcookie("stat","logged",time() + 31536000000);
		session_start();
		$_SESSION["username"]="$uname";
		header("location:cart.php");
		
		
	}
	else{
		
		echo"<script> alert('failed');</script>";
		echo "\n $query";
	}
	
	}
	else{
		echo"<script> alert('mismatched passwords');</script>";
	}
}

if (isset($_POST["login"])){
	$uname = $_POST["uname"];
	$pass = $_POST["pass"];
	
	$result = mysqli_query($con,"select * from users where username = '$uname' and password = '$pass' ");
	if(mysqli_num_rows($result)> 0 ){
		
		setcookie("username","$uname",time() + 31536000000);
		setcookie("stat","logged" , time() + 31536000000);
        session_start();
		$_SESSION["username"]="$uname";
		header("location:cart.php");
		
		
	}
	else{
		
	echo"<script> alert('wrong passwords');</script>";	
	}

}

if (isset ($_GET["logout"])){

    setcookie("username","12",1);
    setcookie("stat","logged out",1);
    session_start();
    session_destroy() ;



}
?>