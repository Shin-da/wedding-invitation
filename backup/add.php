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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && isset($_POST["action"])) {
    $userId = $_POST["id"];
    $action = $_POST["action"];

    // Perform the update of the user's response in the database
    $sql = "UPDATE attendees SET action = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $action, $userId); // Changed "is" to "si" for the correct order
        if ($stmt->execute()) {
            // Update successful
            echo "response_updated"; // Changed to indicate an update
        } else {
            // Update failed
            echo "error";
        }
        $stmt->close();
    } else {
        echo "error";
    }
}

$conn->close();
?>
