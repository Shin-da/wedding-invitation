<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['action'])) {
    $ids = $_POST['id'];
    $action = $_POST['action'];

    if (is_array($ids) && is_array($action)) {
        foreach ($ids as $id) {
            $sql = "UPDATE attendees SET action='$action' WHERE id='$id'";
            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // Check if 'Coming' is selected and set the showModal parameter accordingly
    if (in_array('Coming', $action)) {
        header('Location: attendees.php?showModal=true');
    } else {
        // Redirect without the modal
        header('Location: attendees.php');
    }
} else {
    echo "Action or ID not specified in the form data.";
}

$conn->close();
?>
