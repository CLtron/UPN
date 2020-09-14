<?php

$servername = "localhost";
$dbUsername = "pi";
$dbPassword = "raspberry";
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

// CREATE TABLE messages (
// 	id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
//     sender longtext NOT NULL,
//     receiver longtext NOT NULL,
//     msg longtext NOT NULL
// );

// CREATE TABLE contacts (
// 	id int(255) PRIMARY KEY AUTO_INCREMENT NOT NULL,
//     uuid longtext NOT NULL,
//     contact longtext NOT NULL,
//     msg longtext NOT NULL
// );

