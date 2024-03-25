<?php
include('../api/verf.php');
include('../api/conn.php');
include('../api/admin_ver.php');
if(isset($_POST["func"])){
	switch($_POST["func"]){
		case "init":
			$from = $_POST["from"];
			$from = date($from , strtotime($from));
			$sum = 0;
			$query = $con ->prepare("select sum(user_init_payment) from users where user_type = '1' and user_reg_date >= ? ");
			$query -> bind_param("s",$from);
			if($query -> execute()){
				$result = $query -> get_result();
				$row = $result ->fetch_assoc();
				$sum = $row["sum(user_init_payment)"];

			}
			echo"$sum";
		break;
		case "loans":
			$from = $_POST["from"];
			$to = $_POST["to"];
			$to = date($to, strtotime($to));
			$from = date($from, strtotime($from));
			$sum = 0;
			$query = $con->prepare("select sum(loan_amount) from loans where loan_status = '1' and loan_acceptance_date >= ? and loan_acceptance_date <= ? ");

			$query->bind_param("ss", $from , $to);
			if ($query->execute()) {
				$result = $query->get_result();
				$row = $result->fetch_assoc();
				$sum = $row["sum(loan_amount)"];
			}
			echo"$sum";

		break;
		case "borrowings":
			$from = $_POST["from"];
			$to = $_POST["to"];
			$to = date($to, strtotime($to));
			$from = date($from, strtotime($from));
			$sum = 0;
			$query = $con->prepare("select sum(borrowing_amount) from borrowings where borrowing_status = '1' and borrowing_acceptance_date >= ? and borrowing_acceptance_date <= ? ");

			$query->bind_param("ss", $from, $to);
			if ($query->execute()) {
				$result = $query->get_result();
				$row = $result->fetch_assoc();
				$sum = $row["sum(borrowing_amount)"];
			}
			echo "$sum";
			break;
		case "borrowings_payback":
			$from = $_POST["from"];
			$to = $_POST["to"];
			$to = date($to, strtotime($to));
			$from = date($from, strtotime($from));
			$sum = 0;
			$query = $con->prepare("select sum(borrowing_paidback_amount) from borrowings where borrowing_acceptance_date >= ? and borrowing_acceptance_date <= ? ");

			$query->bind_param("ss", $from, $to);
			if ($query->execute()) {
				$result = $query->get_result();
				$row = $result->fetch_assoc();
				$sum = $row["sum(borrowing_paidback_amount)"];
			}
			echo "$sum";
			break;
		case "loan_payback":
			$from = $_POST["from"];
			$to = $_POST["to"];
			$to = date($to, strtotime($to));
			$from = date($from, strtotime($from));
			$sum = 0;
			$query = $con->prepare("select sum(loan_payback_amount) from loans_payback where  loan_payback_date >= ? and loan_payback_date <= ? ");

			$query->bind_param("ss", $from, $to);
			if ($query->execute()) {
				$result = $query->get_result();
				$row = $result->fetch_assoc();
				$sum = $row["sum(loan_payback_amount)"];
			}
			echo "$sum";
			break;
		case"shares":
			$from = $_POST["from"];
			$to = $_POST["to"];
			$to = date($to, strtotime($to));
			$from = date($from, strtotime($from));
			$sum = 0;
			$query = $con->prepare("select count(user_cpr)*20 from shares where  share_date >= ? and share_date <= ? ");

			$query->bind_param("ss", $from, $to);
			if ($query->execute()) {
				$result = $query->get_result();
				$row = $result->fetch_assoc();
				$sum = $row["count(user_cpr)*20"];
			}
			echo "$sum";
			break;		

	}
	
}