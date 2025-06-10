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
        $stmt->fetch();
        $stmt->close();

        if ($action !== null) {
            // The user has already submitted a response
                  // Display a modal message saying "you have already submitted a response"
                  $('#alreadySubmittedModal').css('display', 'block');
              }
            echo "already_submitted";
        } else {
            // The user has not submitted a response yet, so add their response to the database
            if (!empty($action)) {
                $sql = "INSERT INTO attendees (id, action) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("is", $userId, $action);
                    if ($stmt->execute()) {
                        echo "response_added";
                    } else {
                        echo "error";
                    }
                    $stmt->close();
                } else {
                    echo "error";
                }
            } else {
                echo "no_action";
            }
        }
    } else {
        echo "error";
    }
}

$conn->close();
?>
