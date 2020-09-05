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
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['send']))
    {
        letsGo();
    }
    function letsGo()
    {
      $chatfile = fopen("chat.txt", "w");
      $message = $_POST("msg");
      fwrite($chatfile, $message);
    }
?>

</body>
</html>
