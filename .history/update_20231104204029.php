<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Loop through the arrays and update the database for each attendee
    for ($i = 0; $i < count($ids); $i++) {
        $id = $ids[$i];
        $action = $actions[$id];

        $sql = "UPDATE attendees SET action='$action' WHERE id='$id'";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }
    }

    echo "We are expecting you!";
} else {
    echo "Action or ID not specified in the form data.";
}

$conn->close();
?>