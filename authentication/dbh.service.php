<?php

$servername = "localhost";
$dbUsername = "web";
$dbPassword = "dqIQ1OEPqUOi56tl";
$dbName = "web";

$conn = mysqli_connect($servername,$dbUsername,$dbPassword,$dbName);

if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

// CREATE TABLE users (
// 	id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
//     uuid varchar(255) NOT NULL,
//     pwd longtext NOT NULL,
//     auth longtext NOT NULL
// );