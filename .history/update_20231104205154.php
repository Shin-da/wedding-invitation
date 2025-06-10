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

    // Loop through the arrays and update the database for each attendee
    foreach ($ids as $id) {
        if (isset($actions[$id])) {
            $action = $actions[$id];
            $sql = "UPDATE attendees SET action='$action' WHERE id='$id'";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

   // Redirect to attendees.php after updates
   header("Location: attendees.php");
   header("Location: attendees.php?showModal=true");

   exit; // Make sure to exit to prevent further execution
} else {
    echo "Action or ID not specified in the form data.";
}

$conn->close();

?>
