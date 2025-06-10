<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted first name and last name
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];

    // Prepare an SQL query to retrieve the user's ID
    $sql = "SELECT id FROM attendees WHERE first_name = ? AND last_name = ?";
    
    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {if ($idExists) {
        echo json_encode(["id" => $userId]);
    } else {
        echo json_encode(["error" => "User not found"]);
    }
}
    
    // Close the database connection
    $conn->close();
}
?>
