<?php

if(isset($_POST['login-submit'])) {
	
	require '../dbh.service.php';
	
	$uid = $_POST['user'];
	$password = $_POST['pwd'];	
	
	if(empty($uid) || empty($password)) {
		header("Location: ../login/login.php?error=emptyfields&uid=".$uid);
		exit();
	}
	else {
        $sql = "SELECT * FROM users WHERE uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login/login.php?error=sqlerror");
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)) {
                
                $pwdCheck = password_verify($password, $row['pwdUsers']);
                if($pwdCheck == false) {
                    header("Location: ../login/login.php?error=wrongpwd&uid=".$uid);
                    exit();                        
                }
                else if($pwdCheck == true) {
                    session_start();
                    $_SESSION['id'] = $row['idUsers'];
                    $_SESSION['uid'] = $row['uidUsers'];
                    header("Location: /home/index.html");
                    exit();                        
                }
                else {
                    header("Location: ../login/login.php?error=wrongpwd&uid=".$uid);
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
