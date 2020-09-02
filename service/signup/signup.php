<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>

        <link rel="stylesheet" href="signup.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    </head>
    <body>
        

        <div class="login">
            <?php
            if(isset($_GET['error'])) {
                echo '<form autocomplete="off" class="loginbox" action="/service/authentication/signup.service.php" method="post">
                <h1>Registrieren</h1>';                                
                //display form

                if($_GET['error'] == "emptyfields") {
                    echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Bitte fülle alle Felder aus!</p>';
                }
                else if($_GET['error'] == "invalidmailuid") {
                    echo '<input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">E-Mail und Benutzername sind ungültig!</p>';
                }
                else if($_GET['error'] == "invalidmail") {
                    echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Die E-Mail ist ungültig!</p>';
                }
                else if($_GET['error'] == "invaliduid") {
                    echo '<input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Der Benutzername ist nicht erlaubt!<br>Erlaubt sind folgende Zeichen: 0-9 a-z A-Z</p>';
                }
                else if($_GET['error'] == "pwdcheck") {
                    echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Die Passwörter stimmen nicht überein!</p>';
                }
                else if($_GET['error'] == "usertaken") {
                    echo '<input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Der Benutzername ist bereits vergeben!</p>';
                }
                else if($_GET['error'] == "sqlerror") {
                    echo '<input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Ein Fehler ist im System aufgetreten!<br>Bitte versuche es später erneut</p>';
                }
                else {
                    echo '<input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">
                    <p class="msg">Ein unbekannter Fehler ist im System aufgetreten!<br>Bitte versuche es später erneut</p>';
                }

                echo '</form>';

            }
            else if(isset($_GET['signup'])) { // error handler
                if($_GET['signup'] == "success") {
                    echo '<div class="success">
                    <p>Dein Account wurde erfolgreich erstellt!<br>Eine Email mit einem Aktivierungslink wurde an dich versendet.<br>Bitte prüfe nun dein Postfach.<br><br><a href="../authentication/logout.service.php>Zur Startseite</a></p>                          
                    </div>';
                            
                }
                else {
                    echo '<form autocomplete="off" class="loginbox" action="/service/authentication/signup.service.php" method="post">
                    <h1>Registrieren</h1>
                    <input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                    <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">

                    </form>';                                                        
                }
            }
            else {
                echo '<form autocomplete="off" class="loginbox" action="/service/authentication/signup.service.php" method="post">
                <h1>Registrieren</h1>
                <input type="text" name="user" placeholder="Benutzername">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwd-repeat" placeholder="Password wiederholen">
                <input class="animate-box-color" type="submit" name="signup-submit" value="Registrieren">

                <a href="../login/login.php">Anmelden</a>
                </form>';                                
            }


        ?> 
        </div>

    </body>
</html>
