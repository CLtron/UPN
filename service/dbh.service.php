<?php

$servername = "localhost";
$dbUsername = "your_username";
$dbPassword = "your_password";
$dbName = "your_database";

$conn = mysqli_connect($servername,$dbUsername,$dbPassword,$dbName);

if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}
