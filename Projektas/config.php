<?php
// config.php

// config.php

$servername = "localhost";          // Often 'localhost' for XAMPP
$db_username = "root";             // Default XAMPP MySQL user is 'root'
$db_password = "";                 // By default, XAMPP sets an empty password for 'root'
$dbname = "vilnius_guide";         // The database name you created in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

?>
