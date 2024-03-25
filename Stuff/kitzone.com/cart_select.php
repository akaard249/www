<?php
include('conn.php');
if(isset($_POST["color"]))
{
$P_name=$_POST["P_name"];
$P_company=$_POST["P_company"];
$color = $_POST["color"];
 $query = "update cart set P_color = '$color' where username = '$_COOKIE[username]' and P_name = '$P_name' and P_company = '$P_company'  
 ";
 mysqli_query($con, $query);
 


}
if(isset($_POST["size"]))
{
$P_name=$_POST["P_name"];
$P_company=$_POST["P_company"];
$size = $_POST["size"];
 $query = "update cart set P_size = '$size' where username = '$_COOKIE[username]' and P_name = '$P_name' and P_company = '$P_company'  
 ";
 mysqli_query($con, $query);
 


}
?>