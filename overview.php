<?php
    session_start();
    
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat</title>

    <link rel="stylesheet" href="main.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="jquery-3.5.1.min.js"></script>
</head>

<body>
    
    <?php
        if(isset($_SESSION["uuid"]) && isset($_SESSION["pwd"]) && isset($_SESSION["auth"])) {

            echo '<div class="top-nav">
                <h1 id="h1">ChatBox</h1>
                <ul class="nav-bar">
                    <li><button id="btn-contact">Kontakte</button></li>
                    <li><button id="btn-explore">Hinzufügen</button></li>
                    <button class="btn" onclick="sendToLogout()">Abmelden</button>
                </ul>
                
                </div>';

            echo '<div class="box" id="box"></div>';

            echo '<div class="master" id="master">
            <div class="msg" id="msg">
               
            </div>
            <input type="text" name="msg-input" id="msg-input" placeholder="Nachricht" reqired>
            <button type="button" class="msg-send" id="msg-send"><img src="send.png"></button>
            </div>';
        }
        else {

            echo '<div class="top-nav">
                <h1>ChatBox</h1>
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
                        
                        <div class="container">
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
                        
                        <div class="container">
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


