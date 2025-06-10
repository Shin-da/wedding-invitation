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
    $action = $_POST['action'];

    $sql = "UPDATE attendees SET action='$action' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        if ($action === 'Coming') {
            header("Location: attendees.php?showModal=true");
        } else {
            // Redirect without the modal
            header("Location: attendees.php");
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

$conn->close();

?>
