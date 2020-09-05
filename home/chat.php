<?php
	echo "php";
	echo $_POST['msg'];
	if (isset($_POST['btn'])) {
	  $chatfile = fopen("chat.txt", "w") or die("Unable to open file!");
	  $message = $_POST["msg"];
	  fwrite($chatfile, $message);
	};
?>
