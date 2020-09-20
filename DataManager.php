<?php

session_start();
require 'authentication/dbh.service.php';

//function send message -------------------------------------------------------------
if(isset($_GET["with"]) && isset($_GET["msg"])) {
    $user = $_SESSION["uuid"]; // msg sender
    $contact = $_GET["with"]; // msg receiver

    if($contact == "") { // error handling -> Note: This JS-Alert doesn't work any more at this point!
        echo '<script type="text/javascript" language="Javascript"> 
        alert("Error1")
        </script>'; 
        header( "refresh:0;url=/overview.php" );
        exit();  
    }

    // first sql statement -> write down msg order by sender (current user) and receiver (contact)
    $sql = "INSERT INTO messages (sender, receiver, msg) VALUES (?, ?, ?);"; // use prepared statement to avoid sql injections
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        //sql error handling
        echo '<script type="text/javascript" language="Javascript"> 
        alert('.mysqli_error().')
        </script>'; 
        header( "refresh:0;url=/overview.php" );
        exit();                
    }
    else { // if preparation was successful bind parameters to statement and execute it
        mysqli_stmt_bind_param($stmt, "sss", $user, $contact, $_GET["msg"]);
        mysqli_stmt_execute($stmt);

        //graphical part (last msg function)
        $msgStringMe = "Du: ".$_GET["msg"];
        $msgStringOther = $user.": ".$_GET["msg"];

        // update last msg display for the current user
        $sql = "UPDATE contacts SET msg=? WHERE uuid=? AND contact=?"; // sql statement. The variable msg in this table is temporarily and overwrite able
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) { // also use prepared statement to avoid sql injection
            //sql error handling -> Note: This JS-Alert doesn't work any more at this point!
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "sss", $msgStringMe, $user, $contact);
            mysqli_stmt_execute($stmt); // execute statement
        }

        // update last msg display for contact user
        $sql = "UPDATE contacts SET msg=? WHERE uuid=? AND contact=?";  // sql statement. The variable msg in this table is temporarily and overwrite able
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error handling -> Note: This JS-Alert doesn't work any more at this point!
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "sss", $msgStringOther, $contact, $user); // Note: This step is very similar to the previous step. Only $user and $contact switched the place
            mysqli_stmt_execute($stmt); // execute statement
        }
            
        //add 1 to newMsgCount variable to the same table in reason of an "newMsg" alert
        $sql = "UPDATE contacts SET newMsgCount=newMsgCount+1 WHERE uuid=? AND contact=?"; // sql syntax
        $stmt = mysqli_stmt_init($conn); // also use prepared statement
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error handling -> Note: This JS-Alert doesn't work any more at this point!
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $contact, $user);
            mysqli_stmt_execute($stmt); // execute statement 
        }
    }
    exit(); //FINISHED

    //summary
    //TABLE messages should look like this (if test1 has sent a message to test2):

    //sender    receiver    msg
    //test1     test2       Hello

    //TABLE contacts should look like this (msg represents the latest msg that has been sent and newMsgCount counts the nummber of messages that has been sent till the contact opens this chatroom):

    //uuid      contact     msg             newMsgCount
    //test1     test2       -               0
    //test2     test1       test1: Hello    1

} //function send message -------------------------------------------------------------
else if(isset($_GET["with"])) { //function load chat -------------------------------------------------------------
    //tanslate with to auth token
    $contact = $_GET["with"];
    $user = $_SESSION["uuid"];
    $count = 0; // each of both has his own Index

    //validate contact
    if($contact == "") { // error handling
        echo '<script type="text/javascript" language="Javascript"> 
        alert("Error1")
        </script>'; 
        header( "refresh:0;url=/overview.php" );
        exit();  
    }

    //build chat
    $sql = "SELECT id, msg FROM messages WHERE sender=? AND receiver=? ORDER BY id ASC;"; // sql statement that returns all messages from the current user to the contact (latest->newest) 
    $stmt = mysqli_stmt_init($conn); // use prepared statements again
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        //sql error handling -> Note: This JS-Alert doesn't work any more at this point!
        echo '<script type="text/javascript" language="Javascript"> 
        alert('.mysqli_error().')
        </script>'; 
        header( "refresh:0;url=/overview.php" );
        exit();                
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $user, $contact);
        mysqli_stmt_execute($stmt); //execute statement
        
        $result = mysqli_stmt_get_result($stmt);
        
        $msgFromUser = array(); // create a variable to hold the information
        while ($row = mysqli_fetch_array($result)){
            $msgFromUser[$row["id"]] = $row["msg"]; // add the row in to the results (data) array
        
            if($row["id"] > $count) { // count highest possible number
                $count = $row["id"];
            }
        }
    }

   //build chat
   $sql = "SELECT id, msg FROM messages WHERE sender=? AND receiver=? ORDER BY id ASC;"; //sql statement that returns all messages from the contact to current user (latest->newest) 
   $stmt = mysqli_stmt_init($conn);
   if(!mysqli_stmt_prepare($stmt, $sql)) {
       //sql error handling -> Note: This JS-Alert doesn't work any more at this point!
       echo '<script type="text/javascript" language="Javascript"> 
       alert('.mysqli_error().')
       </script>'; 
       header( "refresh:0;url=/overview.php" );
       exit();                
   }
   else {
       mysqli_stmt_bind_param($stmt, "ss", $contact, $user);
       mysqli_stmt_execute($stmt); //execute statement
       
       $result = mysqli_stmt_get_result($stmt);
       
       $msgFromContact = array(); // create a variable to hold the information
       while ($row = mysqli_fetch_array($result)){
            $msgFromContact[$row["id"]] = $row["msg"]; // add the row in to the results (data) array
            
            if($row["id"] > $count) { // count highest possible number
                $count = $row["id"];
            }
        }    
    }

    if($count == 0) { // if count is 0 no message is available. If it is higher than 0 it contains the highest index of all messages order by id
        echo '<div id="info">Keine Nachrichten</div>';
    }
    else {

        // echo '<div class="adjustment"><p class="line-me">'.$msgFromUser[$j].'<p></div>';         this line shows the messages whitch the user has sent
        // echo '<div class="adjustment"><p class="line-other">'.$msgFromContact[$i].'<p></div>';   this line shows the messages whitch the contact has sent
        for($i = 0; $i <= $count; $i++) { // simple cound through till the count-value is reached
            if(array_key_exists(($i), $msgFromContact)) {   //check if a message is bound to the index
                echo '<div class="adjustment"><p class="line-other">'.$msgFromContact[$i].'</p></div>'; //print them out
            }
            else if(array_key_exists(($i), $msgFromUser)) {
                echo '<div class="adjustment"><p class="line-me">'.$msgFromUser[$i].'</p></div>';    //print them out
            }
        }

        //also the user has opened the chatroom. So this step resets the newMsg alert from the messages send function
        $sql = "UPDATE contacts SET newMsgCount=0 WHERE uuid=? AND contact=?";  // sql statement
        $stmt = mysqli_stmt_init($conn);    // also a prepared statement
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error handling -> Note: This JS-Alert doesn't work any more at this point!
            echo '<script type="text/javascript" language="Javascript"> 
            alert('.mysqli_error().')
            </script>'; 
            header( "refresh:0;url=/overview.php" );
            exit();                
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $user, $contact);
            mysqli_stmt_execute($stmt); //execute
        }

        
    }

    exit(); 
}   //function load chat -------------------------------------------------------------


