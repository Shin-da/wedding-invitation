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

    // Check if the user already exists
    $checkSql = "SELECT id FROM attendees WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);

    if ($checkStmt) {
        $checkStmt->bind_param("i", $userId);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows == 0) {
            // The user doesn't exist, perform an INSERT
            $insertSql = "INSERT INTO attendees (id, action) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);

            if ($insertStmt) {
                $insertStmt->bind_param("is", $userId, $action);
                if ($insertStmt->execute()) {
                    echo "response_added";
                } else {
                    echo "error";
                }
                $insertStmt->close();
            } else {
                echo "error";
            }
        } else {
            echo "already_submitted";
        }

        $checkStmt->close();
    } else {
        echo "error";
    }
}


?>
