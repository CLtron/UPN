<?php

$servername = "localhost";
$dbUsername = "web";
$dbPassword = "BwFr8RQcKnPEHFb8";
$dbName = "web";

$conn = mysqli_connect($servername,$dbUsername,$dbPassword,$dbName);

if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}