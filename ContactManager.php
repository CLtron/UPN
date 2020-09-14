<?php

session_start();
require 'authentication/dbh.service.php';

if(isset($_GET["action"])) {
    
    if($_GET["action"] == "contactlist") {
        //return contactlist order by user
        $user = $_SESSION["uuid"];
        $sql = "SELECT * FROM contacts WHERE uuid=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
         
            $result = mysqli_stmt_get_result($stmt);
            // $msgFromUser = array(); // create a variable to hold the information
            while ($row = mysqli_fetch_array($result)){
                echo ' <div class="contact" id="contact">
                <div class="photo">
                    <img src="user.png" alt="Profile">    
                </div>
                <div class="latest" id="chat">
                    <h3 class="name" id="name">'.$row["contact"].'</h3>
                    <p class="last-msg">'.$row["msg"].'</p>    
                </div>
            </div>'; // add the row in to the results (data) array
            }
        }
        exit();
    
    }
    else if($_GET["action"] == "list") {
        //return everyone
        $sql = "SELECT * FROM users;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            
            // $msgFromUser = array(); // create a variable to hold the information
            while ($row = mysqli_fetch_array($result)){
                if($row["uuid"] != $_SESSION["uuid"]) {
                    echo ' <div class="contact" id="contact">
                    <div class="photo">
                        <img src="user.png" alt="Profile">    
                    </div>
                    <div class="latest" id="chat">
                        <h3 class="name">'.$row["uuid"].'</h3> 
                    </div>
                </div>'; // add the row in to the results (data) array    
                }
            }
        }

        exit();
    }
    else if($_GET["action"] == "add" && isset($_GET["contact"]) && isset($_GET["msg"])) {
        $user = $_SESSION["uuid"];
        $sql = "INSERT INTO contacts (uuid, contact, msg) VALUES (?, ?, ?);";
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {

            $temp = "Letzte Nachricht";
            mysqli_stmt_bind_param($stmt, "sss", $user, $_GET["contact"], $temp);
            mysqli_stmt_execute($stmt);
        
            echo $_GET["contact"] + " wurde erflogreich zu deinen Kontakten hinzugefügt";
        
        }

        exit();
    }

}
else {
    exit();
}

