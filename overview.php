<!DOCTYPE html>

<?php
    session_start();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat</title>

    <link rel="stylesheet" href="main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    
    <?php
        if(isset($_SESSION["uuid"]) && isset($_SESSION["pwd"]) && isset($_SESSION["auth"])) {
            
            
            echo '<div class="top-nav">
                <h1>Ulricianum ChatBox</h1>
                <ul class="nav-bar">
                    <li><h2 class="nav-clickable contacts" id="underline">Kontakte</h2></li>
                    <li><h2 class="nav-clickable stat">Erkunden</h2></li>
                    <li><button onclick="sendToLogout()">Abmelden</button></li>
                </ul>
            </div>';

            echo '<div class="box">
                <div class="contact">
                    <div class="photo">
                        <img src="user.png" alt="Profile">    
                    </div>
                    <div class="latest">
                        <h3 class="name">Bob</h3>
                        <p class="last-msg">Bis morgen</p>    
                    </div>
                </div>
                <div class="contact">
                    <div class="photo">
                        <img src="user.png" alt="Profile">    
                    </div>
                    <div class="latest">
                        <h3 class="name">Alice</h3>
                        <p class="last-msg">ok</p>    
                    </div>
                </div>
            </div>';
        }
        else {

            echo '<div class="top-nav">
                <h1>Ulricianum ChatBox</h1>
            </div>';

            if(isset($_GET["action"])) {
                if($_GET["action"] == "login") {
                    echo '<div class="action">
                        <div class="imgcontainer">
                            <img src="user.png" alt="Avatar" class="avatar">
                        </div>
                        
                        <form class="container" action="/authentication/login.service.php" method="POST">
                            <label for="uname"><b>Benutzername</b></label>
                            <input type="text" placeholder="Gebe deinen Benutzernamen ein" name="user" required>
                        
                            <label for="psw"><b>Passwort</b></label>
                            <input type="password" placeholder="Gebe dein Passwort" name="pwd" required>
                        
                            <button type="submit" name="login-submit" id="login-submit">Login</button>
                            <label>
                        
                        </form>
                        
                        <div class="container" style="background-color:#f1f1f1">
                            <button type="button" class="cancelbtn">Abbrechen</button>
                            <button type="button" class="pagebtn content-register" onclick="sendToSignup()">Erstelle einen Account</button>
                        </div>
                    </div>';    
                }
                else {
                    echo '<div class="action">
                        <div class="imgcontainer">
                            <img src="user.png" alt="Avatar" class="avatar">
                        </div>
                        
                        <form class="container" action="/authentication/signup.service.php" method="POST">
                            <label for="uid"><b>Benutzername</b></label>
                            <input type="text" placeholder="Gebe einen Benutzernamen ein" name="user" required>
                        
                            <label for="pwd"><b>Passwort</b></label>
                            <input type="password" placeholder="Gebe ein Passwort ein" name="pwd" required>
                
                            <label for="pwd-repeat"><b>Passwort Wiederholen</b></label>
                            <input type="password" placeholder="Wiederhole dein Passwort" name="pwd-repeat" required>
                        
                            <button type="submit" name="signup-submit" id="signup-submit">Registrieren</button>
                            <label>
                        
                        </form>
                        
                        <div class="container" style="background-color:#f1f1f1">
                            <button type="button" class="cancelbtn">Abbrechen</button>
                            <button type="button" class="pagebtn content-login" onclick="sendToLogin()">Melde dich an</button>
                        </div>
                    </div>';
                }
            }
            else {
                header("Location: overview.php?action=login");
            }
        }
    ?>

    <script src="UIManager.js"></script>
</body>


</html>