<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST["id"]; // Retrieve the user's ID from the AJAX request

    // Fetch user data from the database based on $userId

    $userData = [
        "first_name" => $fetchedFirstName,
        "last_name" => $fetchedLastName,
    ];

    echo json_encode($userData);
}

$conn->close();
?>
