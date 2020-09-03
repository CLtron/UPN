<?php

if(isset($_POST['signup-submit'])) {
	
	require '../dbh.service.php';
	
	$username = $_POST['user'];
	$password = $_POST['pwd'];	
	$passwordRepeat = $_POST['pwd-repeat'];
	
	if(empty($username) || empty($password) || empty($passwordRepeat)) {
		header("Location: /service/signup/signup.php?error=emptyfields&uid=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: /service/signup/signup.php?error=invaliduid");
		exit();
	}
	else if($password !== $passwordRepeat) {				
		header("Location: /service/signup/signup.php?error=pwdcheck&uid=".$username);
		exit();
	}
	else {

		//cheack for existing users
		$sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: /service/signup/signup.php?error=sqlerror&id=1");
			exit();	
		}
		else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);

			$result = mysqli_stmt_num_rows($stmt);
			if($result > 0) {
				header("Location: /service/signup/signup.php?error=usertaken");
				exit();		
			}
			else {
				//signup current user
				$sql = "INSERT INTO users (uidUsers, pwdUsers) VALUES (?, ?);";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: /service/signup/signup.php?error=sqlerror&id=2");
					exit();	
				}
				else {
					$hashedPwd = password_hash($password, PASSWORD_BCRYPT);

					mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPwd);
					mysqli_stmt_execute($stmt);
		
					header("Location: /service/signup/signup.php?signup=success");
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
	header("Location: /service/signup/signup.php");
	exit();			
}

?>
