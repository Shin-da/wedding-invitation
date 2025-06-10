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

    // Prepare the SQL statement for insertion
    $sql = "INSERT INTO attendees (id, action) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("is", $userId, $action);
        if ($stmt->execute()) {
            // Insertion successful
            echo "response_added";
        } else {
            // Insertion failed
            echo "error";
        }
        $stmt->close();
    } else {
        echo "error";
    }
}

?>
