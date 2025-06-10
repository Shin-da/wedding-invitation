<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id']) && is_array($_POST['id']) && isset($_POST['action']) && is_array($_POST['action'])) {
    $ids = $_POST['id'];
    $actions = $_POST['action'];

    if (count($ids) === count($actions)) {
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $action = $actions[$i];

            $sql = "UPDATE attendees SET action='$action' WHERE id='$id'";
            
            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // Check if 'Coming' is selected and set the showModal parameter accordingly
    if (in_array('Coming', $actions)) {
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
