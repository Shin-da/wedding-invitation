<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the action/response from the database based on your query
$sql = "SELECT * FROM attendees WHERE action = 'Coming'";
$result = $conn->query($sql);

// Initialize the response variable
$response = '';

if ($result->num_rows > 0) {
    // If there's at least one "Coming" response in the database, set the $response variable
    $response = 'Coming';
} else {
    $response = 'Not Coming';
}

$conn->close();
?>
