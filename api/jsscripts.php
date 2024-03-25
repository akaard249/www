<?php
include('conn.php');
include('verf.php');

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		break;
	case 'POST':
		if (isset($_POST["query"])) {
			$search = $_POST["query"];
			$query = "select year(user_reg_date) year from users where user_cpr ='$search'";
			$result = mysqli_query($con, $query);
			if (mysqli_num_rows($result) > 0) {
				echo "
					<select name='share_year' id='year_select'>
				";
				$row = mysqli_fetch_array($result);
				$current_year = date("Y");
				for ($i = $row[0]; $i <= $current_year; $i++) {
					echo "
				<option value='$i'> $i </option>
				";
				}
				echo "</select>";
				echo "<select id='share_pay_month'>  ";
				for ($i = 1; $i < 13; $i++) {

					echo "
                                    <option value='$i'>
                                        $i
                                    </option>
                                    ";
				}
				echo "</select>";
				echo "<input type='text' id='share_amount' placeholder='كمية الدفعة ( في حالة تركه فارغا يحسب شهر واحد من التاريخ المدخل )' oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\" >";

			} else {
				echo 'Data Not Found';
			}
		} elseif (isset($_POST["loan_payback_year"])) {
			$search = $_POST["loan_payback_year"];
			$query = $con->prepare("select loan_id , year(loan_acceptance_date) from loans where user_cpr = ? and loan_status = '1' and loan_payback_status = '0';");
			$query->bind_param("i", $search);
			$query->execute();
			$result = $query->get_result();
			if ($result->num_rows > 0) {
				echo "
					<select name='share_year' id='year_payback_select'>
				";
				$row = mysqli_fetch_array($result);
				$current_year = date("Y");
				for ($i = $row["year(loan_acceptance_date)"]; $i <= $current_year; $i++) {
					echo "
				<option value='$i'> $i</option>
				";
				}
				echo "</select>";
				echo "<input id = 'loanId' hidden type = 'text' value = '$row[loan_id]'>";

				echo "<select id='loan_payback_month'>";

				for ($i = 1; $i < 13; $i++) {

					echo "
                                    <option value='$i'>
                                        $i
                                    </option>
                                    ";
				}
				echo "</select>
				";

			} else {
				echo "Data Not Found $query->num_rows";
			}
		} elseif (isset($_POST["br_token"])) {

			$search = $_POST["br_token"];
			$query = $con->prepare("select * from borrowings where user_cpr = ? and borrowing_payback_status = '0';");
			$query->bind_param("i", $search);
			$query->execute();
			$result = $query->get_result();
			$result_data = $result->fetch_assoc();
			$acceptance_date = $result_data["borrowing_acceptance_date"];
			$acceptance_date = date("Y", strtotime($acceptance_date));
			for ($i = $acceptance_date; $i >= date("Y"); $i++) {
				echo "<option value='$i'>$i</option>";
			}

		} elseif (isset($_POST["func"])) {
			switch ($_POST["func"]) {
				case "br_table":
					if ($_POST["user_cpr"] == "whole") {
						$user = "%%";
					} else {
						$user = "%" . trim($_POST["user_cpr"]) . "%";
					}

					if ($_POST["year"] == "whole") {
						$year = "%%";
					} else {
						$year = "%" . trim($_POST["year"]) . "%";
					}
					if ($_POST["month"] == "whole") {
						$month = "%%";
					} else {
						$month = "%" . trim($_POST["month"]) . "%";
					}

					$query = $con->prepare("select users.user_name , borrowings.user_cpr ,borrowings.borrowing_paidback_amount, borrowings.borrowing_request_date , borrowings.borrowing_acceptance_date , borrowings.borrowing_amount , borrowings.borrowing_acceptance_date , borrowings.borrowing_payback_status from borrowings inner join users on users.user_cpr = borrowings.user_cpr where borrowings.user_cpr like ? and borrowings.borrowing_status = '1' and year(borrowing_acceptance_date) like ? and month(borrowing_acceptance_date) like ?;");
					$query->bind_param("sss", $user, $year, $month);
					$query->execute();
					$result = $query->get_result();
					echo $result->num_rows;
					while ($row = $result->fetch_assoc()) {
						if ($row["borrowing_payback_status"] == "0") {
							$stat = "لم يتم السداد";
						} else {
							$stat = "تم السداد";
						}
						echo "<tr>
					<td>
					$row[user_name]	
					</td>
					<td>
					$row[borrowing_amount]
					</td>
					<td>
					$row[borrowing_request_date]
					</td>
					<td>
					$row[borrowing_acceptance_date]
					</td>
					<td>
					$stat
					</td>
					<td>
					$row[borrowing_paidback_amount]
					</td>
					</tr>";
					}
					break;
				case "share_table":
					if ($_POST["user_cpr"] == "whole") {
						$user = "%%";
					} else {
						$user = "%" . trim($_POST["user_cpr"]) . "%";
					}

					if ($_POST["year"] == "whole") {
						$year = "%%";
					} else {
						$year = "%" . trim($_POST["year"]) . "%";
					}
					if ($_POST["month"] == "whole") {
						$month = "%%";
					} else {
						$month = "%" . trim($_POST["month"]) . "%";
					}
					$query = $con->prepare("select users.user_name , shares.user_cpr , shares.share_date from shares inner join users on users.user_cpr = shares.user_cpr where shares.user_cpr like ? and year(share_date) like ? and month(share_date) like ? order by share_date desc;");
					$query->bind_param("sss", $user, $year, $month);
					$query->execute();
					$result = $query->get_result();
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td> $row[user_cpr] </td>";
						echo "<td> $row[user_name] </td>";
						echo "<td> $row[share_date]";
						echo "</tr>";

					}
					break;
				case "share_sub":
					$user_cpr = trim($_POST["user_cpr"]);
					$user_month = trim($_POST["month"]);
					$user_year = $_POST["year"];
					$share_amount = $_POST["amount"];
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
						echo "<div  class=\"alert alert-warning alert-dismissible\">
  							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  							<strong>العميل دفع بالفعل لهذا الشهر</strong> 
							</div>";
					} else {
						$check_prev = "select max(share_date) from shares where user_cpr = '$user_cpr';";
						$check_prev_query = mysqli_query($con, $check_prev);
						$row = mysqli_fetch_assoc($check_prev_query);
						if (isset($row["max(share_date)"])) {
							$new_date = date("Y/m/d", strtotime($row["max(share_date)"]));
							if ($new_date == $prev) {
								if($share_amount != ""){
									if ($share_amount % 20 != 0 ) {
										echo"<div class=\"alert alert-danger alert-dismissible\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									<strong>حدث خطأ الرجاء مراجعة المدخلات </strong> 
									</div>";
									}else{
										$occur = $share_amount / 20 ;
										$loop_date = date("Y/m/d",strtotime($share_date));
										for($i = 1 ; $i <= $occur ; $i++){
											$insert = "insert into shares (user_cpr , share_date) values ('$user_cpr','$loop_date');";
											$query = mysqli_query($con, $insert);
											$loop_date = date("Y/m/d", strtotime($loop_date."first day of next month"));
											
										}
										echo "<div class=\"alert alert-success alert-dismissible\">
												<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
												<strong>تم تسجيل ". $occur ."دفعة بنجاح</strong> 
												</div>";
									}
								}else{
									$insert = "insert into shares (user_cpr , share_date) values ('$user_cpr','$date');";
									$query = mysqli_query($con, $insert);
									echo "<div class=\"alert alert-success alert-dismissible\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									<strong>تم تسجيل الدفعة بنجاح</strong> 
									</div>";
								}
								
							} else {
								echo "<div  class=\"alert alert-warning alert-dismissible\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									<strong>العميل لم يدفع للشهر السابق </strong> آخر تاريخ تم الدفع للعميل هو : $new_date
									</div>";
							}
						} else {
							$date_month = date('m', $todate);
							$date_year = date('Y', $todate);
							$check_first = "select year(user_reg_date) , month(user_reg_date) from users where user_cpr = '$user_cpr'";
							$check_first_query = mysqli_query($con, $check_first);
							$row = mysqli_fetch_assoc($check_first_query);
							if ($row["year(user_reg_date)"] == $date_year and $row["month(user_reg_date)"] == $date_month) {
								$insert = "insert into shares (user_cpr , share_date) values ('$user_cpr','$date');";
								$query = mysqli_query($con, $insert);
								echo "<div class=\"alert alert-success alert-dismissible\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									<strong>تم تسجيل الدفعة بنجاح</strong> 
									</div>";
							} else {
								echo "
									<div  class=\"alert alert-warning alert-dismissible\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									<strong>العميل لم يبدأ الدفع  </strong> 
									</div>";
							}


						}

					}
					break;
				case "loans_result":
					if ($_POST["user_cpr"] == "whole") {
						$user = "%%";
					} else {
						$user = "%" . trim($_POST["user_cpr"]) . "%";
					}
					if ($_POST["year"] == "whole") {
						$year = "%%";
					} else {
						$year = "%" . trim($_POST["year"]) . "%";
					}
					if ($_POST["month"] == "whole") {
						$month = "%%";
					} else {
						$month = "%" . trim($_POST["month"]) . "%";
					}
					$query = $con->prepare("
						select users.user_name , loans_payback.user_cpr,loans_payback.loan_id , loans_payback.loan_id , loans.loan_amount,loans_payback.loan_payback_amount , loans_payback.loan_payback_date from loans_payback inner join users on users.user_cpr = loans_payback.user_cpr inner JOIN loans on loans.loan_id = loans_payback.loan_id where loans_payback.user_cpr like ? and year(loan_payback_date) like ? and month(loan_payback_date) like ? order by loan_payback_date desc ;");
					$query->bind_param("sss", $user, $year, $month);
					$query->execute();
					$result = $query->get_result();
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo " <td>$row[user_cpr]</td>  <td>$row[user_name]</td> <td>$row[loan_id]</td> <td>$row[loan_amount]</td>  <td>$row[loan_payback_amount]</td>  <td>$row[loan_payback_date]</td>";
						echo "</tr>";
					}
					break;
				case "loan_payback_fun":
					$user_cpr = trim($_POST["user_cpr"]);
					$loanId = $_POST["loanId"];
					$user_month = trim($_POST["month"]);
					$user_year = trim($_POST["year"]);
					$share_date = "1-" . $user_month . "-" . $user_year;
					$date = date('Y/m/d', strtotime($share_date));
					$user_prev = date("Y/m/d", strtotime($share_date . 'first day of previous month'));


					$query = $con ->prepare("select * from loans where loan_id = ?;");
					$query->bind_param("i", $loanId);
					$query->execute();
					$row = $query -> get_result() -> fetch_assoc();
					$amount = $row["loan_payback_quota"];

					$checkdub = $con->prepare("select * from loans_payback where user_cpr=? and loan_payback_date =? order by loan_payback_date asc;");
					$checkdub->bind_param("is", $user_cpr, $date);
					$checkdub->execute();
					$result = $checkdub->get_result();
					$row = mysqli_fetch_array($result);
					
					if ($result->num_rows > 0) {
						echo "4";
					} else {
						$query = $con->prepare("select * from loans_payback where user_cpr = ? and loan_payback_date = ?");
						$query->bind_param("is", $user_cpr, $user_prev);
						$query->execute();
						$result = $query->get_result();
						if ($result->num_rows > 0) {
							$insert = $con->prepare("insert into loans_payback (user_cpr , loan_payback_amount,loan_id , loan_payback_date ) values ( ?, ? , ? , ? );");
							$insert->bind_param("iiis", $user_cpr, $amount,$loanId, $date);
							$insert->execute();
							echo "1";
						} else {
							$query = $con->prepare("select loan_payback_date from loans_payback where loan_id = ? order by loan_payback_date desc;");
							$query->bind_param("i", $loanId);
							$query->execute();
							$result = $query->get_result();
							if (mysqli_num_rows($result) > 0) {
								$row = $result->fetch_assoc();
								$latest_date = date("Y/M", strtotime($row["loan_payback_date"]));
								echo "$latest_date";

							} else {
								$query = $con->prepare("select * from loans where user_cpr = ? and loan_status = '1' and loan_payback_status = '0'");
								$query->bind_param("i", $user_cpr);
								$query->execute();
								$result = $query->get_result();
								$row = mysqli_fetch_array($result);
								$reg_date = $row["loan_acceptance_date"];

								$year_month_reg = date("Y/m", strtotime($reg_date));
								$year_month_user = date("Y/m", strtotime($date));
								if ($year_month_user == $year_month_reg) {
									$insert = $con->prepare("insert into loans_payback (user_cpr , loan_payback_amount ,loan_id , loan_payback_date ) values ( ? , ? , ?. ? );");
									$insert->bind_param("iiis", $user_cpr, $amount, $loanId , $date);
									$insert->execute();
									echo "2";
								} else {
									echo "3";
								}
							}

						}
					}
					break;
				case "br_sub_fun":
					$br_user_cpr = $_POST["user_cpr"];
					$amount = $_POST["amount"];
					$check_prev_query = $con->prepare("select * from borrowings where user_cpr = ? and borrowing_status = '1' and borrowing_payback_status = '0'; ");
					$check_prev_query->bind_param("i",$br_user_cpr);
					$check_prev_query->execute();
					$result = $check_prev_query->get_result();
					$row = mysqli_fetch_array($result);
					$br_id = $row["borrowing_id"];
					$paid = $row["borrowing_paidback_amount"];
					$br_amount = $row["borrowing_amount"];
					$suppose = $br_amount - $paid ;

					if($amount > $suppose){
						echo "Greater";
					}elseif($amount == $suppose ){
						$query = $con->prepare("update borrowings set borrowing_paidback_amount = ? , borrowing_payback_status = '1' , borrowing_payback_date = now() where borrowing_id=? ");
						$query->bind_param("ii",$br_amount , $br_id);
						$query->execute();
						echo "success";

					}else{
						
						$query = $con->prepare("update borrowings set borrowing_paidback_amount = borrowing_paidback_amount + ? where borrowing_id=? ");
						$query->bind_param("ii", $amount, $br_id);
						$query->execute();
						echo "success";
					}
					break;
				case "par_br_sub":
					$user_id = $_POST["user_cpr"];
					$br_amount = $_POST["amount"];

					$check_br = $con->prepare("select * from borrowings where user_cpr = ? and borrowing_status <> '0' and borrowing_payback_status = '0' ;");
					$check_br->bind_param("i", $user_id);
					$check_br->execute();
					$check_result = $check_br->get_result();
					if ($check_result->num_rows > 0) {
						echo "<div class=\"alert alert-danger alert-dismissible\">
  										<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  										<strong>لديك سلفة سابقة غير مدفوعة </strong> 
											</div>";
					} else {
						$check_pend = $con->prepare("SELECT * FROM `borrowings` WHERE user_cpr = ? and ( borrowing_status = '2'  or  borrowing_status = '2' );");
						$check_pend->bind_param("i", $user_id);
						$check_pend->execute();
						$pend_result = $check_pend->get_result();
						if ($pend_result->num_rows > 0) {
							echo "<div class=\"alert alert-warning alert-dismissible\">
  										<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  										<strong>لديك طلب سابق معلق </strong> 
											</div>";
						} else {
							$insert_query = $con->prepare("insert into borrowings (user_cpr , borrowing_amount , borrowing_status , borrowing_request_date ) values ( ? , ? ,'2', now()) ;");
							$insert_query->bind_param("ii", $user_id, $br_amount);
							$insert_query->execute();
							echo "<div class=\"alert alert-success alert-dismissible\">
  										<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  										<strong> تم تسجيل الطلب ! </strong> 
											</div>";
						}
					}
					break;
				case "brFinanceAccept":
					$brId = $_POST["brId"];
					$brComment = $_POST["brFinanceComment"];

					$accept_query = $con->prepare("update borrowings set borrowing_status = '3' , borrowing_finance_comment = ? where borrowing_id = ?");
					$accept_query->bind_param("si", $brComment , $brId );
					if($accept_query->execute()){
						echo"success";
					}else{
						echo "error";
					}
					break;
				case "brFinanceReject":
					$brId = $_POST["brId"];
					$brComment = $_POST["brFinanceComment"];
					$reject_query = $con->prepare("update borrowings set borrowing_status = '0' , borrowing_finance_comment = ? where borrowing_id = ?");
					$reject_query->bind_param("si", $brComment, $brId);
					if($reject_query->execute()){
						echo "success";
					}else{
						echo "error";
					}
					break;
				case "par_br_list":
					$user_id = $_POST["user_cpr"];
					$query = $con->prepare("select * from borrowings where user_cpr = ? ORDER BY `borrowings`.`borrowing_request_date` DESC;");
					$query->bind_param("i", $user_id);
					$query->execute();
					$cmd = $query->get_result();
					while ($result = mysqli_fetch_assoc($cmd)) {
						switch ($result["borrowing_status"]) {
							case 0:
								$stat = "مرفوض";
								break;

							case 1:
								$stat = "مقبول";
								break;
							case 2:
								$stat = "يراجع من المالية";
								break;
							default:
								$stat = "يراجع من الادارة";
								break;
						}
						echo "
						<tr align='center'>
						<td>$result[borrowing_request_date]</td>
						<td>$result[borrowing_amount]</td>
						<td> $stat </td>
						<td > <a id='$result[borrowing_id]'  onclick='fetch_details(event)' ><i class='fa fa-circle-info'></i> التفاصيل </a> </td> 
						</tr>
						";
					}
					break;
				case "par_loan_request":
					$user_id = $_POST["user_cpr"];
					$loan_amount = $_POST["loan_amount"];
					$check_loan = $con->prepare("select * from loans where user_cpr = ? and loan_status <> '0' and loan_payback_status = '0';");
					$check_loan->bind_param("i", $user_id);
					$check_loan->execute();
					$check_result = $check_loan->get_result();
					if ($check_result->num_rows > 0) {
						echo "<div class=\"alert alert-danger alert-dismissible\">
							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
							<strong>لديك قرض سابق غير مدفوع </strong> 
							</div>";
					} else {
						$check_pend = $con->prepare("SELECT * FROM `loans` WHERE user_cpr = ? and ( loan_status = '2'  or  loan_status = '3' );");
						$check_pend->bind_param("i", $user_id);
						$check_pend->execute();
						$pend_result = $check_pend->get_result();
						if ($pend_result->num_rows > 0) {
							echo "<div class=\"alert alert-warning alert-dismissible\">
								<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
								<strong>لديك طلب سابق معلق </strong> 
								</div>";
						} else {
							$insert_query = $con->prepare("insert into loans (user_cpr , loan_amount , loan_status , loan_submition_date ) values ( ? , ? ,'2', now()) ;");
							$insert_query->bind_param("ii", $user_id, $loan_amount);
							$insert_query->execute();
							echo "<div class=\"alert alert-success alert-dismissible\">
								<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
								<strong> تم تسجيل الطلب ! </strong> 
								</div>";
						}
					}

					break;
				case "par_loan_list":

					$user_cpr = $_POST["user_cpr"];
					$query = $con->prepare("select * from loans where user_cpr = ? ORDER BY `loans`.`loan_submition_date` DESC;");
					$query->bind_param("i", $user_cpr);
					$query->execute();
					$cmd = $query->get_result();
					while ($result = mysqli_fetch_assoc($cmd)) {
						switch ($result["loan_status"]) {

							case 0:
								$stat = "مرفوض";
							break;

							case 1:
								$stat = "مقبول";
							break;

							case 2:
								$stat = "يراجع من المالية";
							break;

							default:
								$stat = "يراجع من الإدارة";
							break;
						}
						echo "
					<tr align='center'>
				<td>$result[loan_submition_date]</td>
				<td>$result[loan_amount]</td>
				<td> $stat </td>
				<td> <a id='$result[loan_id]' onclick='loan_details(event)'> التفاصيل </a> </td>
				</tr>
	";

					}

					break;
				case "add_user":
					$user_cpr = trim($_POST["user_cpr"]);
					$user_name = trim($_POST["user_name"]);
					$user_company = trim($_POST["user_company"]);
					$user_init_payment = trim($_POST["user_init_payment"]);
					$user_phone = trim($_POST["user_phone"]);
					$user_rel = trim($_POST["user_rel"]);
					$user_rel_phone = trim($_POST["user_rel_phone"]);
					$user_reg_year = "1-1-".trim($_POST["user_reg_year"]);
					$user_init_share = trim($_POST["user_init_share"]);
					$date = date("Y/m/d",strtotime($user_reg_year));
					
					$check_username = "select * from users where user_cpr = '$user_cpr' ";
					$check_result = mysqli_query($con, $check_username);
					if (mysqli_num_rows($check_result) < 1) {
						$insert_query = $con->prepare("insert into users (user_cpr , user_name , user_password , user_company, user_init_payment , user_type , user_phone , user_reg_date , user_status , user_rel , user_rel_phone) values (? , ? , ? , ? , ? , '1' , ? , ? , '1' , ? , ?);");
						$hashed_password = password_hash($user_cpr, PASSWORD_DEFAULT);
						$insert_query->bind_param("isssiissi", $user_cpr, $user_name, $hashed_password, $user_company, $user_init_payment, $user_phone , $date , $user_rel , $user_rel_phone );
						$insert_query->execute();
						$insert_result = $insert_query->get_result();
						$months_w = $user_init_share / 20;
						$months_w = (int)$months_w ;
						$share_date = date("Y/m/d",strtotime($user_reg_year)) ;
						for ($i = 1 ; $i <= $months_w ; $i++ ) {

							$insert = $con->prepare("insert into shares (user_cpr , share_date ) values ( ? , ? );");
							$insert->bind_param("is",$user_cpr, $share_date);
							$insert->execute();
							$insert_result = $insert->get_result();
							$share_date = date("Y/m/d",strtotime($share_date.'first day of next month')) ;
							
						}

						echo "success";
					} else {

						echo "user_cpr_dup";

					}

					break;
				case "del_user":
					$user_cpr = trim($_POST["user_cpr"]);
					$delete = $con->prepare("update users set user_status = '0' where user_cpr = ? ;");
					$delete->bind_param("i", $user_cpr, );
					if ($delete->execute() === true) {
						echo "success";
					} else {
						echo "error";
					}
					break;
				case "password_confirm":
					$user_cpr = trim($_POST["user_cpr"]);
					$password = $_POST["password"];

					$pass_check = $con->prepare("select * from users where user_cpr = ? ;");
					$pass_check->bind_param("i", $user_cpr);
					$pass_check->execute();
					$result = $pass_check->get_result();
					$row = $result->fetch_assoc();
					if(password_verify( $password, $row["user_password"])){
						$user_company = trim($_POST["user_company"]);
						$user_phone = trim($_POST["user_phone"]);
						$user_rel = trim($_POST["user_rel"]);
						$user_rel_phone = trim($_POST["user_rel_phone"]);

						$update = $con->prepare("UPDATE users SET user_phone = ? , user_rel = ? , user_company = ? , user_rel_phone = ? WHERE user_cpr = ? ;");
						$update->bind_param("isssi", $user_phone, $user_rel, $user_company,$user_rel_phone, $user_cpr);
						if ($update->execute() === true) {
							echo "success";
						} else {
							echo "error";
						}
					} else {
						echo "password wrong";
					}

					break;
					case "borrowings_data":
						$search = $_POST["user_cpr"];
						$query = $con->prepare("select borrowing_status , borrowing_paidback_amount , borrowing_request_date , borrowing_amount from borrowings where user_cpr = ? and borrowing_status ='1' and borrowing_payback_status='0';");
						$query->bind_param("i", $search);
						$query->execute();
						$result = $query->get_result();
						if ($result->num_rows > 0) {
							$row = mysqli_fetch_array($result);
							echo "
								<table width='100%'>
									<tr>
										<td width='30%' align='right'><label for='br_amount'> كمية السلفة </label></td>
										<td align='left'><input type='text' id='br_amount' name='br_amount' value='$row[borrowing_amount]' readonly></td>
									</tr>
					
									<tr>
										<td align='right'> <label for='br_date'> تاريخ قبول السلفة </label></td>
										<td align='left'> <input type='date' id='br_date' name='br_date' value='$row[borrowing_request_date]' readonly></td>
					
									</tr>

									<tr>
						
										<td align='right'> <label for='br_status'> حالة سداد السلفة </label> </td>
										<td align='left'> <input type='text' id='br_status' name='br_status' value='لم يتم السداد' readonly></td>
									</tr>

									<tr>
						
										<td align='right'> <label for='br_status'>المسدد من السلفة  </label> </td>
										<td align='left'> <input type='text' id='br_paid' name='br_paid' value='$row[borrowing_paidback_amount]' readonly></td>
									</tr>

									<tr>
						
										<td align='right'> <label for='br_status'> الرجاء ادخال قيمة السداد  </label> </td>
										<td align='left'> <input type='text' id='br_payback_amount' oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\" ></td>
									</tr>

								</table>
								<br><br>";
					} else {
						echo "<div class=\"alert alert-danger alert-dismissible\">
  					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  					<strong> لا توجد سلفة متأخرة للعميل </strong> 
					</div>";
					}


					break;
					case "first_password_submit":
						$user_cpr = $_POST["user_cpr"];
						$password = $_POST["password"];
						$query = $con->prepare("UPDATE users SET user_password = ? , user_first_signin = '1' WHERE user_cpr = ? ;");
						$hashed_password = password_hash($password, PASSWORD_DEFAULT);
						$query->bind_param("si", $hashed_password,$user_cpr);
						if($query->execute()){
							echo "success";
						}else{
							echo "error";
						}
						
											
						

					break;
				case "edit_password":
					$user_cpr = $_POST["user_cpr"];
					$old_password = $_POST["old_password"];
					$new_password = $_POST["new_password"];
					$check_old = $con->prepare("select user_password from users where user_cpr = ?");
					$check_old->bind_param("i", $user_cpr);
					$check_old->execute();
					$result = $check_old->get_result();
					$row = $result ->fetch_assoc();
					if (password_verify($old_password,$row["user_password"])) {
						$edit_pass = $con -> prepare("update users set user_password = ? where user_cpr = ?;");
						$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
						$edit_pass->bind_param("si", $hashed_password , $user_cpr);
						if($edit_pass->execute() === true){
							echo "success";
						}else{
							echo '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>حدث خطأ الرجاء مراجعة البيانات</strong></div>';
						}
					}else{
						echo"wrong password";
					}
					
				break;
				case "user_br_details":
				$br_id = $_POST["br_id"];
				$query = $con -> prepare("SELECT * from borrowings where borrowing_id = ?;");
				$query ->bind_param("i", $br_id);
				$query ->execute();
				$result = $query -> get_result();
				$row = $result -> fetch_assoc();
				if($row["borrowing_status"] == 0 ){
					$stat = "مرفوض";
				}else if($row["borrowing_status"] == 1){
					$stat = "مقبول";
				}else if($row["borrowing_status"] == 2){
					$stat = "يراجع من المالية";
				}else if($row["borrowing_status"] == 3){
					$stat = "يراجع من الادارة";
				}
				echo"
					
									
									<div class='table table-striped'>
									<div class='br_results'>
									<h4>تفاصيل السلفة</h4>
									<table width='100%' id='br_table'>
										<tr>
											<td> كمية السلفة :</td>
											<td> $row[borrowing_amount]</td>
										</tr>
										<tr>
											<td> تاريخ رفع الطلب :</td>
											<td> $row[borrowing_request_date]</td>
										</tr>
										<tr>
											<td>  حالة الطلب :</td>
											<td> $stat</td>
										</tr>
										<tr>
											<td>  المدفوع من السلفة الطلب :</td>
											<td> $stat</td>
										</tr>

										<tr>
											<td>   تعليق الإدارة :</td>
											<td> $row[borrowing_admin_comment]</td>
										</tr>
										<tr>
											<td>  تعليق المالية :</td>
											<td> $row[borrowing_finance_comment]</td>
										</tr>

									</table>
									</div>
									</div>
				";
				break;
				case "user_loan_details":
					$loan_id = $_POST["loan_id"];
					$query = $con->prepare("SELECT * from loans where loan_id = ?;");
					$query->bind_param("i", $loan_id);
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					if ($row["loan_status"] == 0) {
						$stat = "مرفوض";
					} else if ($row["loan_status"] == 1) {
						$stat = "مقبول";
					} else if ($row["loan_status"] == 2) {
						$stat = "يراجع من المالية";
					} else if ($row["loan_status"] == 3) {
						$stat = "يراجع من الادارة";
					}
					echo "
					
									
									<div class='table table-striped'>
									<div class='br_results'>
									<h4>تفاصيل السلفة</h4>
									<table width='100%' id='br_table'>
										<tr>
											<td> كمية السلفة :</td>
											<td> $row[loan_amount]</td>
										</tr>
										<tr>
											<td> تاريخ رفع الطلب :</td>
											<td> $row[loan_submition_date]</td>
										</tr>
										<tr>
											<td>  حالة الطلب :</td>
											<td> $stat</td>
										</tr>
										<tr>
											<td>   تعليق الإدارة :</td>
											<td> $row[loan_admin_comment]</td>
										</tr>
										<tr>
											<td>  تعليق المالية :</td>
											<td> $row[loan_finance_comment]</td>
										</tr>

									</table>
									</div>
									</div>
				";
					break;

				case "numOfClients":
					$num_users = "SELECT user_cpr FROM `users` where user_type = '1';";
					$num_users_cmd = mysqli_query($con, $num_users);
					$numbTotal = mysqli_num_rows($num_users_cmd);
					$num_users = "SELECT user_cpr FROM `users` where user_type = '1' and user_status = '0';";
					$num_users_cmd = mysqli_query($con, $num_users);
					$numbDeact = mysqli_num_rows($num_users_cmd);
					$numbAct = $numbTotal - $numbDeact;
					echo "$numbAct \ $numbTotal";
					
					break;
				case "numbShares":
					$num_users = $con-> prepare("select * from users where user_type = '1' and user_status = '1'");
					$num_users->execute();
					$result = $num_users -> get_result();
					$numOfusers = $result->num_rows;

					$num_shares_stmt = $con-> prepare("SELECT share_id FROM `shares` where year(share_date) = '".date("Y")."' and month(share_date) = '".date("m")."';");
					$num_shares_stmt -> execute();
					$num_shares_cmd = $num_shares_stmt -> get_result();
					$num_shares = $num_shares_cmd -> num_rows;
					
					echo "$num_shares \ $numOfusers";

				break;
				case "numbLoans":
					$num_users = $con->prepare("select * from Loans where Loan_status = '1'");
					$num_users->execute();
					$result = $num_users->get_result();
					$numOfusers = $result->num_rows;

					// echo "$num_shares \ $numOfusers";

				break;
				case "adminLoanAccept":
					$loan_id = $_POST["loan_id"];
					if($user_type == 3){
						$adminComment = $_POST["adminComment"];
						$monthlyPayment = trim($_POST["monthlyPayment"]);
						if($monthlyPayment == ""){
							echo"null monthly payment";
						}else{
							$query = $con->prepare("update loans set loan_status = '1' ,loan_acceptance_date = now(),loan_payback_status = '0' , loan_payback_quota = ? , loan_admin_comment = ? where loan_id = ? ");
							$query -> bind_param("isi",$monthlyPayment,$adminComment,$loan_id);
							if($query -> execute()){
								echo"success";
							}else{
								echo"error";
							}

						}
						
					}
					break;
					case "financeLoanAccept":
						$loan_id = $_POST["loanId"];
						$financeComment = trim($_POST["financeComment"]);
						if($financeComment == ""){
							echo"finance comment empty ";
						}else{
							// echo $financeComment . $loan_id;
							$query = $con->prepare("update loans set loan_status = '3' , loan_finance_comment = ? where loan_id = ?	;");
							$query -> bind_param("si",$financeComment,$loan_id);
							if($query -> execute()){
								echo "success";
							}else{
								echo "error";
							}
						}
					break;
					case "adminLoanReject":
						$loanId = $_POST["loanId"];
						$adminComment = $_POST["adminComment"];
						if($adminComment == ""){
						echo" تعليق المدير لا يمكن أن يكون خاليا ";
						}else{
							$query = $con->prepare("update loans set loan_status = '0' , loan_admin_comment = ? where loan_id = ? ;");
							$query -> bind_param("si",$adminComment,$loanId);
							if($query -> execute()){
								echo "success";
							}else{
								echo "error";
							}
						}
						
					break;
					case "financeLoanReject":
						$loanId = $_POST["loanId"];
						$financeComment = $_POST["financeComment"];
						if($financeComment == ""){
						echo" تعليق أمين الصندوق لا يمكن أن يكون خاليا ";
						}else{
							$query = $con->prepare("update loans set loan_status = '0' , loan_finance_comment = ? where loan_id = ? ;");
							$query -> bind_param("si",$financeComment,$loanId);
							if($query -> execute()){
								echo "success";
							}else{
								echo "error";
							}
						}
					break;
					case "brAdminAccept":
						$brId = $_POST["brId"];
						$adminComment = $_POST["brAdminComment"];
						if($adminComment == ""){
						echo '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق الإدارة لا يمكن أن يكون خاليا</strong></div>';

					}
						else{
							$query = $con->prepare("update borrowings set borrowing_status = '1' , borrowing_payback_status = '0' , borrowing_paidback_amount = '0' , borrowing_acceptance_date = now() , borrowing_admin_comment = ? where borrowing_id = ? ;");
							$query -> bind_param("si",$adminComment , $brId);
							if($query -> execute()){
								echo "success";
							}else{
								echo "error";
							}
						}
						
					break;
					case "brAdminReject":
					$brId = $_POST["brId"];
					$adminComment = $_POST["brAdminComment"];
					if ($adminComment == "") {
						echo '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق الإدارة لا يمكن أن يكون خاليا</strong></div>';

					} else {
						$query = $con->prepare("update borrowings set borrowing_status = '1' , borrowing_admin_comment = ? where borrowing_id = ? ;");
						$query->bind_param("si", $adminComment, $brId);
						if ($query->execute()) {
							echo "success";
						} else {
							echo "error";
						}
					}
					break;

					case "report_loan_result":
						$user_cpr = $_POST["user_cpr"];
						if($user_cpr == "whole"){
							$user_cpr ="%%";
						}else{
						$user_cpr = "%".$user_cpr."%";
						}
						$stat =  $_POST["state"];
						$date_from = date("Y/m/d", strtotime($_POST["date_from"]));
						$date_to = date("Y/m/d", strtotime($_POST["date_to"]));
						
						if($stat == "whole"){
						$stat = "%%";
						}else{
						$stat = "%" . $_POST["state"] . "%";
						}
						$query = $con->prepare("
						select users.user_name , loans.loan_status, loans.loan_id,loans.loan_payback_status , loans.loan_submition_date , loans.loan_finance_comment , loans.loan_admin_comment , loans.loan_amount from loans inner join users on users.user_cpr = loans.user_cpr 
						where 
						loans.user_cpr like ? and
						 loans.loan_submition_date >= ? and
						  loans.loan_submition_date <= ? and
						   loans.loan_status ='1' and loans.loan_payback_status like ?;
						   ");
						$query -> bind_param("ssss", $user_cpr,$date_from,$date_to, $stat );
						$query -> execute();
						$result = $query-> get_result();
						if ( $result -> num_rows > 0) {
							$loan_amount_sum = 0 ;
							$loan_payback_sum = 0;
							while($row = $result -> fetch_assoc() ) {

								switch ($row["loan_payback_status"]){
									case "1":
										$stat = "قرض منتهي";
									break;
									case "0":
										$sum = 0;
										$loan_id = $row["loan_id"];
										$query = $con -> prepare("select * from loans_payback where loan_id = ? ;");
										$query -> bind_param("i",$loan_id);
										$query -> execute();
										$res = $query ->get_result();
										while($payback_table = $res -> fetch_assoc()){
											$sum = $sum + $payback_table["loan_payback_amount"];
										}
										$stat = $sum;
									$loan_amount_sum = $loan_amount_sum + $row["loan_amount"];
									$loan_payback_sum = $loan_payback_sum + $stat;
									break;
									

								}

								echo "<tr>";
								echo"<td>$row[user_name]</td>";
							echo "<td>$row[loan_amount]</td>";
							echo "<td>$stat</td>";
							echo "<td>$row[loan_submition_date]</td>";
							
							echo "<td>$row[loan_finance_comment]</td>";
							echo "<td>$row[loan_admin_comment]</td>";
								echo"</tr>";
								
							}
						echo "<tr style='background-color:#0db694;color:#fff;'>";
						echo "<td>مجموع القروض القائمة</td>";
						echo "<td>$loan_amount_sum</td>";
						
						echo "<td>  المدفوعات من القروض القائمة </td>";
						echo "<td>$loan_payback_sum</td>";
						echo "<td> المتأخرات </td>";
						echo "<td> ".$loan_amount_sum - $loan_payback_sum." </td>";
						echo "</tr>";

							
							
						} else {
							echo "<tr ><td colspan='5'> لا توجد نتيجة </td</tr>";
							
							
						}
						
					break;

					case "report_borrowing_result" :
					$user_cpr = $_POST["user_cpr"];
					if ($user_cpr == "whole") {
						$user_cpr = "%%";
					} else {
						$user_cpr = "%" . $user_cpr . "%";
					}
					$stat = $_POST["state"];
					$date_from = date("Y/m/d", strtotime($_POST["date_from"]));
					$date_to = date("Y/m/d", strtotime($_POST["date_to"]));

					if ($stat == "whole") {
						$stat = "%%";
					} else {
						$stat = "%" . $_POST["state"] . "%";
					}
					$query = $con->prepare("
					select users.user_name , borrowing_payback_status ,borrowings.borrowing_id ,  borrowings.borrowing_paidback_amount ,borrowings.borrowing_status , borrowings.borrowing_request_date , borrowings.borrowing_finance_comment , borrowings.borrowing_admin_comment , borrowings.borrowing_amount from borrowings
					 inner join users on users.user_cpr = borrowings.user_cpr 
					 where borrowings.user_cpr like ? and 
					 borrowings.borrowing_request_date >= ? and 
					 borrowings.borrowing_request_date <= ? and 
					 borrowings.borrowing_status = '1' and borrowing_payback_status like ?;");
					$query->bind_param("ssss", $user_cpr, $date_from, $date_to, $stat);
					$query->execute();
					$result = $query->get_result();
					if ($result->num_rows > 0) {
						$borrowings_sum = 0 ;
						$borrowings_payback_sum = 0 ;
						while ($row = $result->fetch_assoc()) {
							
							switch ($row["borrowing_payback_status"]) {
								case "1":
									$stat = "سلفة منتهية";
								break;
								case "0":
									
									$stat = $row["borrowing_paidback_amount"];
									$borrowings_sum = $borrowings_sum + $row["borrowing_amount"] ;
									$borrowings_payback_sum = $borrowings_payback_sum + $stat ; 

								break;

							}

							echo "<tr>";
							echo "<td>$row[user_name]</td>";
							echo "<td>$row[borrowing_amount]</td>";
							echo "<td>$stat</td>";
							echo "<td>$row[borrowing_request_date]</td>";
							echo "<td>$row[borrowing_finance_comment]</td>";
							echo "<td>$row[borrowing_admin_comment]</td>";
							echo "</tr>";
						}
						
						echo "<tr style='background-color:#0db694;color:#fff;'>";
						echo "<td>مجموع السلفات القائمة</td>";
						echo "<td> $borrowings_sum </td>";
						echo "<td> الدفعات للسلفات القائمة </td>";
						echo "<td> $borrowings_payback_sum </td>";
						echo "<td> المتأخرات </td>";
						echo "<td>".$borrowings_sum - $borrowings_payback_sum." </td>";
						echo "</tr>";

					} else {
						echo "<tr ><td colspan='5'> لا توجد نتيجة </td</tr>";


					}

					break;

					case "monthly_report":
					$user_cpr = $_POST["user_cpr"];
					if ($user_cpr == "whole") {
						$user_cpr = "%%";
					} else {
						$user_cpr = "%" . $user_cpr . "%";
					}
					
					$date_from = date("Y/m/d", strtotime($_POST["date_from"]));
					$date_to = date("Y/m/d", strtotime($_POST["date_to"]));

					

					

					$query = $con -> prepare("
select users.user_name , count(shares.share_id) ,users.user_reg_date, max(shares.share_date) from shares inner join users on users.user_cpr = shares.user_cpr where shares.user_cpr like ? and shares.share_date >= ? and shares.share_date <= ?  group by users.user_cpr;					");
					$query -> bind_param("sss" , $user_cpr , $date_from , $date_to);
					$query -> execute();
					$result = $query->get_result();
					$paid_sum = 0 ;
					$not_paid_sum = 0 ;
					while($row = $result -> fetch_assoc()){
						$date1 = $row["max(shares.share_date)"];
						$date2 = date("Y-m");

						$ts1 = strtotime($date1);
						$ts2 = strtotime($date2);

						$year1 = date('Y', $ts1);
						$year2 = date('Y', $ts2);

						$month1 = date('m', $ts1);
						$month2 = date('m', $ts2);

						$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						if($diff < 0 ){
							$diff = 0 ;
						}
						
						echo"<tr>";
						echo "<td>$row[user_name]</td>";
						echo "<td>$row[user_reg_date]</td>";
						echo "<td>".$row["count(shares.share_id)"]."</td>";
						echo "<td>". $row["count(shares.share_id)"] * 20 ." د.ب</td>";
						echo "<td>".$row["max(shares.share_date)"]."</td>";
						echo"<td>" . $diff . "</td>";
						echo "<td>" . $diff * 20 . " د.ب</td>";
						echo"</tr>";
						$paid_sum += $row["count(shares.share_id)"] * 20;
						$not_paid_sum += $diff * 20;
					}
					echo "<tr style='background-color:#0db694;z-index: 15;' >";
					echo "<td style='position: sticky;bottom: 0px' colspan='2'>مجموع المدفوعات الشهرية </td>";
					echo "<td style='position: sticky;bottom: 0px'>$paid_sum د.ب</td>";
					echo "<td style='position: sticky;bottom: 0px' colspan='2'>مجموع المتأخرات الشهرية </td>";
					echo "<td style='position: sticky;bottom: 0px' colspan='2'>$not_paid_sum د.ب</td>";
					echo "</tr>";


					break;
					case"treasury":
					$query = $con->prepare("select sum(user_init_payment) sum from users where  user_type = '1';");
					$query ->execute();
					$result = $query -> get_result();
					$row = $result -> fetch_assoc();
					$init_sum = $row["sum"];

					$query = $con->prepare("select count(shares.user_cpr)*20 sum from shares inner join users on users.user_cpr = shares.user_cpr where users.user_type = '1';");
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					$shares = $row["sum"];

					$query = $con->prepare("select sum(loan_amount) sum from loans where loan_status = '1' ;");
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					$loans_given = $row["sum"];

					$query = $con->prepare("select sum(borrowing_amount) sum from borrowings where borrowing_status = '1' ;");
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					$borrowings_given = $row["sum"];

					$query = $con->prepare("select sum(loan_payback_amount) sum from loans_payback ;");
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					$loans_payback = $row["sum"];

					$query = $con->prepare("select sum(borrowing_paidback_amount) sum from borrowings ;");
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					$borrowings_payback = $row["sum"];

					$treasury = 0 ;
					$treasury = $init_sum + $shares + $loans_payback + $borrowings_payback - $loans_given - $borrowings_given ;

						echo "$treasury";
						break;
				case"arrears":
					$query = $con->prepare("select users.user_name , count(shares.share_id) , max(shares.share_date) from shares inner join users on users.user_cpr = shares.user_cpr group by users.user_name;");	
					$query->execute();
					$result = $query->get_result();
					
					$not_paid_sum = 0;
					while ($row = $result->fetch_assoc()) {
						$date1 = $row["max(shares.share_date)"];
						$date2 = date("Y-m");

						$ts1 = strtotime($date1);
						$ts2 = strtotime($date2);

						$year1 = date('Y', $ts1);
						$year2 = date('Y', $ts2);

						$month1 = date('m', $ts1);
						$month2 = date('m', $ts2);

						$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						if ($diff < 0) {
							$diff = 0;
						}
						$not_paid_sum += $diff * 20;
					}
					$shares = $not_paid_sum ;
					$not_paid_sum = 0 ;

					$query = $con -> prepare("select loans.loan_id , loans.loan_status ,loans.loan_payback_quota , sum(loans_payback.loan_payback_amount) , max(loans_payback.loan_payback_date) from loans inner join loans_payback on loans.loan_id = loans_payback.loan_id where loans.loan_status= '1' and loans.loan_payback_status = '0' GROUP by loans.loan_id;");
					$query->execute();
					$result = $query->get_result();
					while ($row = $result->fetch_assoc()){
						$date1 = $row["max(loans_payback.loan_payback_date)"];
						$date2 = date("Y-m");

						$ts1 = strtotime($date1);
						$ts2 = strtotime($date2);

						$year1 = date('Y', $ts1);
						$year2 = date('Y', $ts2);

						$month1 = date('m', $ts1);
						$month2 = date('m', $ts2);

						$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						if ($diff < 0) {
							$diff = 0;
						}
						$not_paid_sum += $diff * $row["loan_payback_quota"];

					}
					$loans_not_paid = $not_paid_sum ;

					$query = $con->prepare("select sum(borrowing_amount) - sum(borrowing_paidback_amount) sum from borrowings where borrowing_status = '1';");
					$query->execute();
					$result = $query->get_result();
					$row = $result->fetch_assoc();
					$borrowing_not_paid = $row["sum"];

					echo $shares + $loans_not_paid + $borrowing_not_paid ;

					
					break;
				default:
					echo "123";
				break;

			}





		} else {
			echo "2 ";
		}





		break;
	default:

		break;
}