<?php

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'mydb';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableName = "mytable";
