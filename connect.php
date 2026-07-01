<?php
$servername = "localhost:3301";
$username = "eventify_user";
$password = "eventify2026";
$dbname = "utem_eventify";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
