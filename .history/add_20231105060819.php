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

    // Loop through the array of actions and update each record
    foreach ($action as $id => $action) {
        // You should use an UPDATE statement to modify existing records
        $sql = "INSERT INTO attendees (action) VALUES ('$action') where id="$id?";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }

        if ($act === 'Coming') {
            $response = 'Coming';
        }
    }

    if ($response === 'Coming') {
        header("Location: rsvp.php?showModal=true");
    } else {
        header("Location: rsvp.php");
    }
}
$conn->close();
?>
