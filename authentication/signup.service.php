<?php

if(isset($_POST['signup-submit'])) {
	
	require 'dbh.service.php';
	
	$username = $_POST['user'];
	$password = $_POST['pwd'];	
	$passwordRepeat = $_POST['pwd-repeat'];

	$cookie_error_key = "error";
	$cookie_user_key = "uuid";
	$cookie_auth_key = "auth";
	
	if(empty($username) || empty($password) || empty($passwordRepeat)) {
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		exit();
	}
	else if($password !== $passwordRepeat) {				
		exit();
	}
	else {

		//cheack for existing users
		$sql = "SELECT uuid FROM users WHERE uuid=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)) {
			//sql error
			echo '<script type="text/javascript" language="Javascript"> 
			alert('.mysqli_error().')
			</script>'; 
			header( "refresh:0;url=/overview.php?action=signup" );
			exit();		
		}
		else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);

			$result = mysqli_stmt_num_rows($stmt);
			if($result > 0) {
				//user taken
				echo '<script type="text/javascript" language="Javascript"> 
				alert("Der Benutzername ist bereits vergeben!")
				</script>'; 
				header( "refresh:0;url=/overview.php?action=signup" );
				exit();		
			}
			else {
				//signup current user
				$sql = "INSERT INTO users (uuid, pwd, auth) VALUES (?, ?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)) {
					//sql error 2
					echo '<script type="text/javascript" language="Javascript"> 
					alert('.mysqli_error().')
					</script>'; 
					header( "refresh:0;url=/overview.php?action=signup" );
		
					exit();	
				}
				else {
					$hashedPwd = password_hash($password, PASSWORD_BCRYPT);
					$auth = md5($username.$password);

					mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPwd, $auth);
					mysqli_stmt_execute($stmt);
					
					session_start();
					$_SESSION["uuid"] = $username;
					$_SESSION["pwd"] = $password;
					$_SESSION["auth"] = $auth;
					header("Location: /overview.php");
					//login
					exit();			
		
				} //end of signup
		
			} // end of user taken check

		} // end of usertaken pre check
		
	} //end of basic error check

	//closing connection to database
	mysqli_stmt_close($close);
	mysqli_close();

} //page access check
else {
	header("Location: /overview.php?action=signup");
	exit();			
}

?>
