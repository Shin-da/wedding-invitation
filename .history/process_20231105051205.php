<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted first name and last name
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];

    // Prepare an SQL query to retrieve the user's ID and additional data
    $sql = "SELECT id, first_name, last_name FROM attendees WHERE first_name = ? AND last_name = ?";
    
    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("ss", $first_name, $last_name);
        
        // Execute the statement
        $stmt->execute();
        
        // Bind the result variables
        $stmt->bind_result($id, $fetchedFirstName, $fetchedLastName);
        
        // Fetch the result
        $stmt->fetch();
        
        if ($id !== null) {
            // Return the result as JSON with additional data
            echo json_encode(["id" => $id, "first_name" => $fetchedFirstName, "last_name" => $fetchedLastName]);
        } else {
            echo json_encode(["error" => "User not found"]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["error" => "Error in the SQL query: " . $conn->error]);
    }
    
    // Close the database connection
    $conn->close();
}
?>
