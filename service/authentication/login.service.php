<?php

if(isset($_POST['login-submit'])) {
	
	require '../dbh.service.php';
	
	$mailuid = $_POST['user'];
	$password = $_POST['pwd'];	
	
	if(empty($mailuid) || empty($password)) {
		header("Location: ../login/login.php?error=emptyfields&uid=".$mailuid);
		exit();
	}
	else {
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login/login.php?error=sqlerror");
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['pwdUsers']);
                if($result == false) {
                    header("Location: ../login/login.php?error=wrongpwd&uid=".$mailuid);
                    exit();                        
                }
                else if($result == true) {
                    session_start();
                    $_SESSION['id'] = $row['idUsers'];
                    $_SESSION['uid'] = $row['uidUsers'];
                    $_SESSION['email'] = $row['emailUsers'];
                    $_SESSION['perm'] = $row['perm'];
                    header("Location: ../../index.html");
                    exit();                        
                }
                else {
                    header("Location: ../login/login.php?error=wrongpwd&uid=".$mailuid);
                    exit();                        
                }
            }
            else {
                header("Location: ../login/login.php?error=nouser");
                exit();                    
            }
        }
    }
}
else {
    header("Location: ../login/login.php");
    exit();			
}