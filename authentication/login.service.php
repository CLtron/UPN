<?php

if(isset($_POST['login-submit'])) {
	
	require 'dbh.service.php';
	
	$username = $_POST['user'];
	$password = $_POST['pwd'];	
	
	if(empty($username) || empty($password)) {
		exit();
	}
	else {
        $sql = "SELECT * FROM users WHERE uuid=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php?action=login" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['pwd']);
                if($pwdCheck == false) {
                    //wrong pwd
                    echo '<script type="text/javascript" language="Javascript"> 
                    alert("Das Passwort ist falsch!")
                    </script>'; 
                    header( "refresh:0;url=/overview.php?action=login" );
        
                    exit();                        
                }
                else if($pwdCheck == true) {
                    session_start();
                    $_SESSION['uuid'] = $row['uuid'];
                    $_SESSION['pwd'] = $row['pwd'];
                    $_SESSION['auth'] = $row['auth'];
                    header("Location: /overview.php");
                    exit();                        
                }
                else {
                    //wrong pwd
                    echo '<script type="text/javascript" language="Javascript"> 
                    alert("Das Passwort ist falsch!")
                    </script>'; 
                    header( "refresh:0;url=/overview.php?action=login" );
                    exit();                        
                }
            }
            else {
                //no user
                echo '<script type="text/javascript" language="Javascript"> 
                alert("Der Benutzername existiert nicht!")
                </script>'; 
                header( "refresh:0;url=/overview.php?action=login" );
                exit();                    
            }
        }
    }
}
else {
    header("Location: /overview.php?action=login");
    exit();			
}
