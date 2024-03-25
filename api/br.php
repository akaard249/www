<?php
include("conn.php");
include("verf.php");

if(isset($_POST["br_token"])) {
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
		}
		else{
			foreach ($_POST as $key => $value) {
				echo"<option>". $key ."=>". $value."</option>";
				echo"1";
			}
		}
		?>