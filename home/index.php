<html>
<head>
  <script type="text/javascript" src="chat.js"> </script>
</head>
<body onload="Initialize()">

<input type="text" id="msg" name="msg" placeholder="Nachricht...">
<button type="submit" onclick="get_msg()">Senden</button>
<button type="button" name="send">Senden</button>
<p id="chat">Test</p>

<?php
        if(array_key_exists('send', $_POST)) {
            button1();
          }
        function button1() {
          $chatfile = fopen("chat.txt", "w");
          $message = $_GET("msg");
          fwrite($chatfile, $message);
        }
    ?>

</body>
</html>
