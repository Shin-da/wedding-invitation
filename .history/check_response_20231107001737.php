<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $userId = $_POST["id"]; // Retrieve the user's ID from the AJAX request

    // Check if the user has already submitted a response
    $sql = "SELECT action FROM attendees WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($action);
        $stmt->fetch();
        $stmt->close();

        if ($action == null) {
            // The user has already submitted a response
        } else {
            // The user has not submitted a response yet
            echo "not_submitted";
            echo "already_submitted";
        }
    } else {
        echo "error";
    }
}

$conn->close();
?>
