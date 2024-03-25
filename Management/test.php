<?php
$date = "2024-01-01";

$abd = date("Y/m/d", strtotime($date));

$bcd = date("Y/m/d", strtotime($abd .'second day of previous month'));
// echo date('Y-m-d', strtotime('first day of last month'));
echo $bcd;


// select data 
/* if (isset($_POST["submit"])) {
	$someshit = $_POST["user_cpr"];

	include"../api/conn.php";
	
	$query = $con->prepare("SELECT user_name , user_password FROM users where user_cpr = ?");
	$query->bind_param("i", $id);
	$id = $someshit;
	$query->execute();
	$result = $query->get_result();
	while ($row = $result->fetch_assoc()) {
		echo "$row[user_name]";
		echo "$someshit";
	}


} */







/* bind variables to prepared statement */



/* 
insert queries + update + delete

$link = new mysqli('localhost','root','root','najahat_db');
$query = $link ->prepare("insert into users (user_cpr , user_password , user_name , user_company  , user_br ,user_type , user_rel_cpr ,user_reg_date , user_init_payment) values (? , ? , ? , ? , ? , ? , ? , ? , ?)");
$query -> bind_param('isssiiisi',$user_cpr , $user_password , $user_name ,  $user_company , $user_br , $user_type , $user_rel_cpr , $user_reg_date , $user_init_payment );
$user_cpr = "121212121";
$user_name = "bind params";
$user_company = "Sabit LLC";
$user_br = "12121212";
$user_type = "1";	
$user_rel_cpr = "212121212";
$user_reg_date = "2024-2-16";
$user_init_payment = "200";
$user_password = "121212121";
if($query -> execute()){
	echo"done";
}
else{
	echo "error";
} */


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	
</body>

</html>