<?php

session_start();
require 'authentication/dbh.service.php';


if(isset($_GET["with"]) && isset($_GET["msg"])) {
    $user = $_SESSION["uuid"];
    $contact = $_GET["with"];

    if($contact == "") {
        echo '<script type="text/javascript" language="Javascript"> 
        alert("Error1")
        </script>'; 
        header( "refresh:0;url=/overview.php" );
        exit();  
    }

    $sql = "INSERT INTO messages (sender, receiver, msg) VALUES (?, ?, ?);";
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
        mysqli_stmt_bind_param($stmt, "sss", $user, $contact, $_GET["msg"]);
        mysqli_stmt_execute($stmt);
    }

    exit(); //FINISHED

}
else if(isset($_GET["with"])) {
    //tanslate with to auth token
    $contact = $_GET["with"];
    $user = $_SESSION["uuid"];
    $userIndex = 0;
    $contactIndex = 0;

    //validate contact
    if($contact == "") {
        echo '<script type="text/javascript" language="Javascript"> 
        alert("Error1")
        </script>'; 
        header( "refresh:0;url=/overview.php" );
        exit();  
    }

    //build chat
    $sql = "SELECT id, msg FROM messages WHERE sender=? AND receiver=? ORDER BY id ASC;";
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
        mysqli_stmt_bind_param($stmt, "ss", $user, $contact);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        $msgFromUser = array(); // create a variable to hold the information
        while ($row = mysqli_fetch_array($result)){
            $msgFromUser[$row["id"]] = $row["msg"]; // add the row in to the results (data) array
         
            if($row["id"] > $userIndex) {
                $userIndex = $row["id"];
            }
        }
    }

   //build chat
   $sql = "SELECT id, msg FROM messages WHERE sender=? AND receiver=? ORDER BY id ASC;";
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
       mysqli_stmt_bind_param($stmt, "ss", $contact, $user);
       mysqli_stmt_execute($stmt);
       
       $result = mysqli_stmt_get_result($stmt);
       
       $msgFromContact = array(); // create a variable to hold the information
       while ($row = mysqli_fetch_array($result)){
            $msgFromContact[$row["id"]] = $row["msg"]; // add the row in to the results (data) array
            
            if($row["id"] > $contactIndex) {
                $contactIndex = $row["id"];
            }
        }    
    }

    if(count($msgFromUser) == 0 && count($msgFromUser) == 0) {
        echo '<p class="info">Keine Nachrichten<p>';
    }
    else {
        //fill up

        // echo '<div class="adjustment"><p class="line-me">'.$msgFromUser[$j].'<p></div>';
        // echo '<div class="adjustment"><p class="line-other">'.$msgFromContact[$i].'<p></div>';
        if($userIndex < $contactIndex) {
            for($i = 0; $i < $contactIndex; $i++) {
                if(array_key_exists(($i + 1), $msgFromContact)) {
                    echo '<div class="adjustment"><p class="line-other">'.$msgFromContact[$i + 1].'<p></div>';
                }
                else if(array_key_exists(($i + 1), $msgFromUser)) {
                    echo '<div class="adjustment"><p class="line-me">'.$msgFromUser[$i + 1].'<p></div>';
                }
            }

        } else {
            for($i = 0; $i < $userIndex; $i++) {
                if(array_key_exists(($i + 1), $msgFromContact)) {
                    echo '<div class="adjustment"><p class="line-other">'.$msgFromContact[$i + 1].'<p></div>';
                }
                else if(array_key_exists(($i + 1), $msgFromUser)) {
                    echo '<div class="adjustment"><p class="line-me">'.$msgFromUser[$i + 1].'<p></div>';
                }
            }
        }

        
    }

    exit(); //NOT FINISHED -> other messages hasn't loaded yet
}


