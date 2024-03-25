<?php

if(isset($_POST["username"]))

{

$username = $_POST["username"];
$password = $_POST["password"];

$con = mysqli_connect("localhost","root","","test");
$result = mysqli_query($con,"select * from users where username = '$username' and password = '$password' ");
	if(mysqli_num_rows($result)> 0 ){

	setcookie("username","$username",time() + 31536000000);
		setcookie("stat","logged" , time() + 31536000000);
   header("location:index.php");

}
else {

	echo"bye";
}

}




?>




<html>


	<body>
		<div align="center" >
			<br>
			<br>
			<form action="login.php" method="post" >
				<legend border="1" > Login</legend>
				<br>
		<input type="text" name="username" >
		<br>
		<br>
		<input type="password" name="password" > <br><br>
		<input type="submit" value="form1" ">

	</form>
</div>

</body>
</html>