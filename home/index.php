<html>
<head>
  <script type="text/javascript" src="chat.js"> </script>
 <?php require 'chat.php'; ?>
</head>
<body onload="Initialize()">

<form action="" method="POST">
<input type="text" id="msg" name="msg" placeholder="Nachricht...">
<p style="display:none;" id="btn_prsd" name="btn">false</p>
<input type="submit" name="btn" value="Senden">
</form>
<button type="submit" onclick="get_msg()">Empfangen</button>

<p id="chat">Test</p>

</body>
</html>
