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

    // Perform a check to see if the user has already submitted a response
    $check_sql = "SELECT id FROM attendees WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);

    if ($check_stmt) {
        $check_stmt->bind_param("i", $userId);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "already_submitted"; // User has already submitted a response
        } else {
            // Proceed to insert the response
            $insert_sql = "INSERT INTO attendees (id, action) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);

            if ($insert_stmt) {
                $insert_stmt->bind_param("is", $userId, $action);
                if ($insert_stmt->execute()) {
                    echo "response_added";
                } else {
                    echo "error";
                }
                $insert_stmt->close();
            } else {
                error_log($conn->error);
                echo "error";
            }
        }
        $check_stmt->close();
    } else {
        echo "error";
    }
}

?>
