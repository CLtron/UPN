<?php


    function sendVerificationMail($name, $email, $vkey) {
        $subject = 'HelfendeEulen.de - Verification'; // Give the email a subject 
        $message = '
        
        Thanks for signing up!
        Your account has been created, you can login with the following credentials after you have activated your account by following the url below.
        
        ------------------------
        Username: '.$name.'
        Password: *****
        ------------------------
        
        Please following this link to activate your account:
        http://HelfendeEulen.de/service/authentication/auth.php?vkey='.$vkey.'
        
        '; // Our message above including the link -> IMPORTANT: THIS LINK HAS TO BE UPDATED FOR EVERY SYSTEM!
                            
        $headers = 'From:noreply@raspberrypi.fritz.box' . "\r\n"; // Set from headers
        mail($email, $subject, $message, $headers); // Send our email    
    }

?>