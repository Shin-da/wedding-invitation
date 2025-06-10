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

// Check if the request is received and retrieve the user ID
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $userId = $_POST["id"]; // Retrieve the user's ID from the AJAX request

    // Debugging: Log received data and user ID
    error_log("Received POST data: " . print_r($_POST, true));
    error_log("User ID: " . $userId);

    // Check if the user has already submitted a response
    $sql = "SELECT action FROM attendees WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($action);
        $stmt->fetch();
        $stmt->close();

        if ($action !== null) {
            // The user has already submitted a response
            echo "already_submitted";
        } else {
            // The user has not submitted a response yet
            echo "not_submitted";
        }
    } else {
        // Debugging: Log any SQL errors
        error_log("SQL Error: " . $conn->error);
        echo "error";
    }
}

// Close the database connection
$conn->close();
?>
