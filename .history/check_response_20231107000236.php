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
    $action = isset($_POST["action"]) ? $_POST["action"] : "";

    // Check if the user has already submitted a response
    $sql = "SELECT action FROM attendees WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($existingAction);
        $stmt->fetch();
        $stmt->close();

        if ($existingAction === null) {
            // The user has not submitted a response, so insert their response into the database
            $stmt = $conn->prepare($sql);
            $sql = "UPDATE attendees SET action = ? WHERE id = ?";

            if ($stmt) {
                $stmt->bind_param("is", $userId, $action);
                if ($stmt->execute()) {
                    echo "response_added";
                } else {
                    echo "error";
                }
                $stmt->close();
            }
        } else {
            // The user has already submitted a response
            echo "already_submitted";
        }
    }
}

$conn->close();
?>
