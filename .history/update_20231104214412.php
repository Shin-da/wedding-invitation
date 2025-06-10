<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showModal = isset($_GET['showModal']) ? $_GET['showModal'] : false;
var_dump($showModal); // Debugging output

if (isset($_POST['id']) && isset($_POST['action'])) {
    $ids = $_POST['id'];
    $action = $_POST['action'];
    $response = '';

    // Convert the array of IDs to a comma-separated string
    $idList = implode(',', $ids);

    // Loop through the array of actions and update each record
    foreach ($action as $id => $action) {
        $sql = "UPDATE attendees SET action='$action' WHERE id = $id";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }

        if ($act === 'Coming') {
            $response = 'Coming';
        }
    }

    if ($response === 'Coming') {
        header("Location: attendees.php?showModal=true");
    } else {
        header("Location: attendees.php");
    }
} else {
    echo "Action or ID not specified in the form data.";
}

$conn->close();
?>
