<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
f (isset($_POST['action'])) {
    $action = $_POST['action'];


$sql = "UPDATE attendees SET action='$action' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "We are expecting you!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}
else {
    echo "Action not specified in the form data.";
}
$conn->close();
?>