<?php
if(isset($_GET["logout"])){
	
	 setcookie("user_cpr","12",1);
     setcookie("user_name","abc",1);
    setcookie("stat","logged out",1);
    session_start();
    session_destroy() ;
	header("location: index.php");
	
}
else{
header("location: index.php");	
}
?>
