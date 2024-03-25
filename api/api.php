<?php
// loan request review 
include('conn.php');
include('verf.php');

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		if (isset($_GET["del_user"])) {

			$user_cpr = trim($_GET["del_user"]);
			$delete = $con->prepare("delete from users where user_cpr = ? ;");
			$delete->bind_param("i", $user_cpr, );

			if ($delete->execute() === true) {
				header("location: ../management/users.php?del_success=1");
			} else {
				header("location :../management/single_user.php?user_cpr=$user_cpr&error=1");
			}

		}
		// handle GET request
		break;
	case 'POST':
		// handle POST request
		if (isset($_POST["request_accept_btn"])) {
			$loan_id = trim($_POST["loan_id"]);
			$loan_name = trim($_POST["applicant"]);
			$company = trim($_POST["company_name"]);
			$loan_amount = trim($_POST["amount"]);
			if ($user_type == "2") {
				$comment = trim($_POST["finance_comment"]);
			} elseif ($user_type == "3") {
				$payback_quota = trim($_POST["payback"]);
				$comment = trim($_POST["admin_comment"]);
			}
			if ($user_type == "2") {
				$update = $con->prepare("update loans set loan_finance_comment = ?,loan_status = '3' where loan_id = ?");
				$update->bind_param("si", $comment, $loan_id);
			} elseif ($user_type == "3") {
				$update = $con->prepare("update loans set loan_admin_comment = ?,loan_status = '1' ,loan_acceptance_date ='" . date("Y/m/d") . "' , loan_payback_quota = ? , loan_payback_status = '0' where loan_id = ?");
				$update->bind_param("sii", $comment, $payback_quota, $loan_id);
			}
			if ($update->execute()) {

				header("location: ../management/requests?success=1");
			} else {
				header("location: ../management/requests?success=0");
			}
		} elseif (isset($_POST["share_payment"])) {
			$user_cpr = trim($_POST["user_cpr"]);
			$user_month = trim($_POST["share_month"]);
			$user_year = $_POST["share_year"];
			$share_date = "1-" . $user_month . "-" . $user_year;
			$todate = strtotime($share_date);
			$date = date('Y/m/d', $todate);
			$date_month = date('m', $todate);
			$date_year = date('Y', $todate);
			$prev = date('Y/m/d', strtotime($share_date . 'first day of previous month'));
			$prev_month = date("Y/m/d", strtotime('first day of previous month'));

			$check_dup = "select * from shares where user_cpr = '$user_cpr' and share_date = '$date' ";
			$check_dup_query = mysqli_query($con, $check_dup);
			
			if (mysqli_num_rows($check_dup_query) > 0) {
				header("location: /management/shares?dup=1");
			}
			else{
				$check_prev = "select max(share_date) from shares where user_cpr = '$user_cpr';";
				$check_prev_query = mysqli_query($con, $check_prev);
				$row = mysqli_fetch_assoc($check_prev_query);
				if(isset($row["max(share_date)"])) {
					$new_date = date("Y/m/d", strtotime($row["max(share_date)"]));
					if($new_date == $prev ) {
						$insert = "insert into shares (user_cpr , share_date) values ('$user_cpr','$date');";
						$query = mysqli_query($con, $insert);
						header("location: /management/shares?success=1");
				}
				else{
						header("location: /management/shares?error=1&&user_cpr=$user_cpr");
				}
			}else{
					$date_month = date('m', $todate);
					$date_year = date('Y', $todate);
					$check_first = "select year(user_reg_date) , month(user_reg_date) from users where user_cpr = '$user_cpr'";
					$check_first_query = mysqli_query($con, $check_first);
					$row = mysqli_fetch_assoc($check_first_query);
					if($row["year(user_reg_date)"] == $date_year and $row["month(user_reg_date)"] == $date_month ){
						$insert = "insert into shares (user_cpr , share_date) values ('$user_cpr','$date');";
						$query = mysqli_query($con, $insert);
						header("location: /management/shares?success=1");
					}
					else{
						header("location: /management/shares?error=1&&user_cpr=$user_cpr");
					}


				}

			}
		} elseif (isset($_POST["requests_back"])) {
			header("location: /management/requests");
		} elseif (isset($_POST["request_reject_btn"])) {
			$loan_id = trim($_POST["loan_id"]);
			if ($user_type == 2) {
				$comment = trim($_POST["finance_comment"]);
				$update = $con->prepare("update loans set loan_finance_comment = ? ,loan_status = '0'  where loan_id = ?");
			} elseif ($user_type == 3) {
				$comment = trim($_POST["admin_comment"]);
				$update = $con->prepare("update loans set loan_admin_comment = ? ,loan_status = '0'  where loan_id = ?");
			}
			$update->bind_param("si", $comment, $loan_id);


			if ($update->execute()) {
				header("location: /management/requests.php?decline=1");
			} else {
				header("location: /management/requests.php?decline=0");
			}

		} elseif (isset($_POST["par_request_loan"])) {
			$loan_amount = $_POST["load_request_amount"];

			$load_query = $con->prepare("insert into loans (user_cpr,loan_amount,loan_status,loan_submition_date) values (?,?,'2','" . date('Y-m-d') . "');");
			$load_query->bind_param("ii", $user_cpr, $loan_amount);

			if ($load_query->execute()) {
				header("location: ../loan.php?return=1");
			} else {
				header("location: ../loan.php?return=0");
			}
		} elseif (isset($_POST["add_user"])) {
			$user_name = $_POST["user_name"];
			$user_cpr = $_POST["user_cpr"];
			$user_company = $_POST["user_company"];
			$user_rel_cpr = $_POST["user_rel_cpr"];
			$user_br = $_POST["user_br"];
			$user_init_payment = $_POST["user_init_payment"];

			$check_username = "select * from users where user_cpr = '$user_cpr' ";
			$check_result = mysqli_query($con, $check_username);
			if (mysqli_num_rows($check_result) < 1) {
				$insert_query = "insert into users (user_cpr , user_password , user_name , user_company  , user_br ,user_type , user_rel_cpr ,user_reg_date , user_init_payment) values ('$user_cpr' , '$user_cpr' , '$user_name' , '$user_company' , '$user_br' , '1' , '$user_rel_cpr' ,'" . date("Y-m-d") . "', '$user_init_payment');";


				if (mysqli_query($con, $insert_query)) {

					header("location: ../management/users.php?user_success=1");
				}

			} else {

				header("location: ../management/add_user.php?error=0");

			}


		} elseif (isset($_POST["login"])) {
			$uname = $_POST["username"];
			$pass = $_POST["password"];
			$result = mysqli_query($con, "select * from users where user_id = '$uname' and user_password = '$pass' ");
			if (mysqli_num_rows($result) > 0) {
				$user_data = mysqli_fetch_assoc($result);
				$type = $user_data["user_type"];
				setcookie("username", "$uname", time() + 31536000000);
				setcookie("stat", "logged", time() + 31536000000);
				setcookie("type", "$type", time() + 31536000000);
				header("location: ../index.php");
			} else {

				header("location: ../login.php?error=1");
			}

		} elseif (isset($_POST["query"])) {
			$search = $_POST["query"];
			$query = "select year(user_reg_date) year from users where user_cpr ='$search'";
			$result = mysqli_query($con, $query);
			if (mysqli_num_rows($result) > 0) {
				echo "
					<select name='share_year' id='year_select2'>
				";
				$row = mysqli_fetch_array($result);
				$current_year = date("Y");
				for ($i = $row[0]; $i <= $current_year; $i++) {
					echo "
				<option value='$i'> $i </option>
				";
				}
				echo "</select>";

			} else {
				echo 'Data Not Found';
			}


		} elseif (isset($_POST["loan_payback_year"])) {
			$search = $_POST["loan_payback_year"];
			$query = $con->prepare("select DISTINCT(year(loan_acceptance_date)) from loans where user_cpr = ? and loan_status = '1' and loan_payback_status = '0' ORDER by year(loan_acceptance_date) DESC;");
			$query->bind_param("i", $search);
			$query->execute();
			$result = $query->get_result();
			if ($result->num_rows > 0) {
				echo "
					<select name='share_year' id='loan_payback_year'>
				";
				$row = mysqli_fetch_array($result);
				$current_year = date("Y");
				for ($i = $row[0]; $i <= $current_year; $i++) {
					echo "
				<option value='$i'> $i </option>
				";
				}
				echo "</select>";

			} else {
				echo "Data Not Found $query->num_rows";
			}
		} elseif (isset($_POST["loan_payback"])) {
			$user_cpr = trim($_POST["user_cpr"]);
			$user_month = trim($_POST["share_month"]);
			$user_year = $_POST["share_year"];
			$share_date = "1-" . $user_month . "-" . $user_year;
			$todate = strtotime($share_date);
			$date = date('Y/m/d', $todate);
			$prev = date('Y/m/d', strtotime($share_date . 'first day of previous month'));
			$prev_month = date("Y/m/d", strtotime('first day of previous month'));

			$check_dup = "select * from loans_payback where user_cpr = '$user_cpr' and loan_payback_date = '$date' ";
			$check_dup_query = mysqli_query($con, $check_dup);
			if (mysqli_num_rows($check_dup_query) > 0) {
				header("location: /management/loan_payback?dup=1#focus");
			} else {

				$prev_check = "select * from loans_payback where user_cpr = '$user_cpr' and loan_payback_date = '$prev_month' ";
				$prev_check_query = mysqli_query($con, $prev_check);
				if (mysqli_num_rows($prev_check_query) > 0) {
					$insert_sql = "insert into loans_payback (user_cpr , loan_payback_date ) values ('$user_cpr','$date')";
					if ($result = mysqli_query($con, $insert_sql)) {
						header("location: /management/loan_payback?success=1#focus");
					} else {
						header("location: /management/loan_payback?success=0");
					}
				} else {
					$first_payment = "select month(loan_acceptance_date) month , year(loan_acceptance_date)  year from loans where user_cpr = '$user_cpr'  and loan_payback_status = '0';";
					$first_payment_query = mysqli_query($con, $first_payment);
					$row = mysqli_fetch_array($first_payment_query);
					if ($user_month == $row["month"] && $user_year == $row["year"]) {
						$insert_sql = "insert into loans_payback (user_cpr , loan_payback_date ,loan_payback_amount ) values ('$user_cpr','$date' , '20')";
						if ($result = mysqli_query($con, $insert_sql)) {
							header("location: /management/loan_payback?success=1#focus");
						} else {
							header("location: /management/loan_payback?success=0");
						}
					} else {
						echo"$date , $user_cpr";
						header("location: /management/loan_payback?prev_check=0&&user_cpr=$user_cpr");

					}




				}
			}
		} 
		elseif(isset($_POST["borrowings_data"])){
			}
		
		else {

			echo "2";
		}


		break;
	case 'PUT':
		// handle PUT request
		break;
	case 'DELETE':
		// handle DELETE request
		break;
}



?>