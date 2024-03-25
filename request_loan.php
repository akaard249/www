<?php 
include('conn.php');
include('verf.php');

if (isset($_POST["request_loan"])){
	$loan_amount = $_POST["load_request_amount"];
	$load_query = "insert into loans (user_id,loan_amount,loan_status) values ('$user','$loan_amount','Pending');";
	if($cmd = mysqli_query($con,$load_query)){
		header("location: loan.php?return=1");		
	}
	else{
		header("location: loan.php?return=0");
	}



	
	
	
}


?> 