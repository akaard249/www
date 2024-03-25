<?php 
// loan request review 
include('api/conn.php');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // handle GET request
        break;
    case 'POST':
        // handle POST request
	if(isset($_POST["login"])){
		$uname = $_POST["username"];
		$pass = $_POST["password"];

		$query = $con->prepare("select * from users where user_id = ? and user_password = ? ");
		$query->bind_param("is", $uname, $pass);
		$query->execute();
		$result = $query->get_result();

		if(mysqli_num_rows($result)> 0 ){
			$user_data = $result->fetch_assoc();
			$type = $user_data["user_type"];
			setcookie("username","$uname",time() + 31536000000);
			setcookie("stat","logged" , time() + 31536000000);
			setcookie("type","$type" , time() + 31536000000);	
			header("location:index.php");	
		}

		else{
			
			header("location:login.php?error=1");
			}
	  
											}

		
		else{
			
			echo"2";
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