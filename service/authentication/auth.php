<?php

if(isset($_GET['vkey'])) {

    require '../dbh.service.php';

    $vkey = $_GET['vkey'];

    if(empty($vkey)) {
        header("Location: /home/index.html");
        exit();	
    }
    else {

        $sql = "SELECT uidUsers FROM users WHERE vkey=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: /home/index.html?sql1");
            exit();	
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $vkey);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $result = mysqli_stmt_num_rows($stmt);
			if($result > 1) {
                header("Location: /home/index.html?stmt");
                exit();	
            }
			else {
                $sql = "SELECT * FROM users WHERE vkey=?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: /home/index.html?sql2");
                    exit();	
                }
                else {
                    mysqli_stmt_bind_param($stmt, "s", $vkey);
                    mysqli_stmt_execute($stmt);
                    
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)) {

                        $mail = $row['emailUsers'];
                        $verified = $row['verified'];
                        if($verified == 0) {
                            $verified = 1;

                            $sql = "UPDATE users SET verified=? WHERE vkey=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: /home/index.html?sql3");
                                exit();	
                            }
                            else {
                                mysqli_stmt_bind_param($stmt, "ss", $verified, $vkey);
                                mysqli_stmt_execute($stmt);
                            }
                        }

                        header("Location: ../login/login.php?mail=".$mail);
                        exit();

                    }
                    else {
                        header("Location: /home/index.html?sql4");
                        exit();	
                    }
                }
        
            }
        }
    }

}
else {
    header("Location: /home/index.html");
    exit();			
}