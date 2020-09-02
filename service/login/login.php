<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <link rel="stylesheet" href="login.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    </head>
    <body>
        
        <div class="login">
            <?php
                echo '<form class="loginbox" action="/service/authentication/login.service.php" method="post">
                <h1>Login</h1>';

                if(isset($_GET['error'])) {

                    if($_GET['error'] == "emptyfields") {
                        echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                        <input type="password" name="pwd" placeholder="Passwort">
                        <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">
                        <p class="msg">Bitte fülle alle Felder aus!</p>';
                    }
                    else if($_GET['error'] == "wrongpwd") {
                        echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                        <input type="password" name="pwd" placeholder="Passwort">
                        <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">
                        <p class="msg">Das Passwort ist falsch!</p>';
                    }
                    else if($_GET['error'] == "nouser") {
                        echo '<input type="text" name="user" placeholder="Benutzername">
                        <input type="password" name="pwd" placeholder="Passwort">
                        <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">
                        <p class="msg">Der angegebende Benutzer existiert nicht!</p>';
                    }
                    else if($_GET['error'] == "sqlerror") {
                        echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                        <input type="password" name="pwd" placeholder="Passwort">
                        <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">
                        <p class="msg">Ein Fehler ist im System aufgetreten!<br>Bitte versuche es später erneut</p>';
                    }
                    else {
                        echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['uid'].'>
                        <input type="password" name="pwd" placeholder="Passwort">
                        <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">
                        <p class="msg">Ein unbekannter Fehler ist im System aufgetreten!<br>Bitte versuche es später erneut</p>';
                    }
                } 
                else if(isset($_GET['mail'])) {
                    echo '<input type="text" name="user" placeholder="Benutzername" value='.$_GET['mail'].'>
                    <input type="password" name="pwd" placeholder="Passwort">
                    <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">
                    <p class="msg" style="color: #2ecc71">Dein Account wurde aktiviert!<br>Gebe hier dein Passwort um dich Anzumelden</p>';
                }
                else {
                    echo '<input type="text" name="user" placeholder="Benutzername">
                    <input type="password" name="pwd" placeholder="Passwort">
                    <input class="animate-box-color" type="submit" name="login-submit" value="Anmelden">';
                }

                echo '<a href="../signup/signup.php">Registrieren</a>
                </form>';
            ?>

        </div>

    </body>
</html>
