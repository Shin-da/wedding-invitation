<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST["id"]; // Retrieve the user's ID from the AJAX request

    // Fetch user data from the database based on $userId
    // This assumes you have a table structure similar to this:
    // Table: attendees
    // Columns: id (INT, primary key), first_name (VARCHAR), last_name (VARCHAR)

    $sql = "SELECT first_name, last_name FROM attendees WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($firstName, $lastName);
        $stmt->fetch();
        $stmt->close();

        // Format the user data as HTML
        $userData = "<tr><td>$firstName</td><td>$lastName</td><td>";
        $userData .= "<input type='radio' name='action[$userId]' id='comingRadio' value='Coming'> Coming ";
        $userData .= "<input type='radio' name='action[$userId]' id='notComingRadio' value='Not Coming'> Not Coming </td></tr>";

        echo $userData;
    } else {
        echo json_encode(["error" => "Error in the SQL query: " . $conn->error]);
        // Log a message to the error log for debugging
error_log("fetch_user_data.php accessed with ID: " . $userId);

    }

    $conn->close();
}
?>
