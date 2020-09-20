<?php

session_start();
require 'authentication/dbh.service.php';
$stmt = mysqli_stmt_init($conn);

if(isset($_GET["action"])) {
    
    if($_GET["action"] == "contactlist") {
        //return contactlist order by user
        $user = $_SESSION["uuid"];
        $sql = "SELECT * FROM contacts WHERE uuid=?;";
        
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
                    <img src="user.png" alt="Profile">';   
                    if($row["newMsgCount"] > 0) {
                        echo '<p>'.$row["newMsgCount"].'</p>'; 
                    }
                echo '</div>
                <div class="latest" id="chat">
                    <h3 class="name" id="name">'.$row["contact"].'</h3>
                    <p class="last-msg">'.$row["msg"].'</p>    
                </div>
                <button type="button" class="delete" id="delete" onclick="deleteFromContact(&quot;'.$row["contact"].'&quot;)"><img src="delete.png" alt="delete"></img></button>
            </div>'; // add the row in to the results (data) array
            }
        }
        exit();
    
    }
    else if($_GET["action"] == "list") {
        //return everyone except yourself and everyone who has been added already to you contactlist
        $user = $_SESSION["uuid"];
        $sql = "SELECT * FROM contacts WHERE uuid=?;";
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
            $contacts = array(); // create a variable to hold the information
            while ($row = mysqli_fetch_array($result)){
                $contacts[$row["contact"]] = 1;
            }
        }

        
        $sql = "SELECT * FROM users;";
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
                if($row["uuid"] != $_SESSION["uuid"] && !array_key_exists($row["uuid"], $contacts)) { //can't add youself and can't add anyone twice
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
        $temp = "Neuer Chat";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "sss", $user, $_GET["contact"], $temp);
            mysqli_stmt_execute($stmt);
        }

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "sss", $_GET["contact"], $user, $temp);
            mysqli_stmt_execute($stmt);
        }

        exit();
    }
    else if($_GET["action"] == "delete" && isset($_GET["contact"])) {
        $user = $_SESSION["uuid"];
        $sql = "DELETE FROM contacts WHERE uuid=? AND contact=?;";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $user, $_GET["contact"]);
            mysqli_stmt_execute($stmt);
        }

        $sql = "DELETE FROM contacts WHERE uuid=? AND contact=?;";
        
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {

            mysqli_stmt_bind_param($stmt, "ss", $_GET["contact"], $user);
            mysqli_stmt_execute($stmt);
        }

        exit();

    }

}
else {
    exit();
}

