<?php
include("conn.php");

if (isset($_COOKIE["user_cpr"])){
$user_cpr = $_COOKIE["user_cpr"];
$user = $_COOKIE["user_name"];
$user_type = $_COOKIE["type"];
}
else{
header('location:/login');
die();
}

?>