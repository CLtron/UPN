<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>
<html>

<head>
  <script type="text/javascript" src="chat.js"> </script>
  <?php require 'chat.php'; ?>
  <link rel="stylesheet" href="css/main.css">
</head>

<body onload="Initialize(); get_msg()">

  <form id="chat_line" action="" method="POST">
    <input type="text" id="msg" name="msg" placeholder="Nachricht...">
    <p style="display:none;" id="btn_prsd" name="btn">false</p>
    <input type="submit" name="btn" value="Senden">
  </form>

  <p id="chat">Test</p>

</body>

</html>
