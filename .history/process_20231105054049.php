<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];

    $sql = "SELECT id FROM attendees WHERE first_name = ? AND last_name = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $first_name, $last_name);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        if ($id > 0) {
            echo json_encode(["id" => $id]);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    } else {
        echo json_encode(["error" => "Error in the SQL query: " . $conn->error]);
    }

    $conn->close();
}

?>
