<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted first name and last name
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];

    // In a real application, you would typically connect to a database to retrieve the user's ID
    // For the purpose of this example, we'll use a simple array as a placeholder
    $users = [
        ["id" => 1, "first_name" => "John", "last_name" => "Doe"],
        ["id" => 2, "first_name" => "Jane", "last_name" => "Smith"],
        // Add more user data as needed
    ];

    $userId = null;

    // Search for the user based on the provided first name and last name
    foreach ($users as $user) {
        if ($user["first_name"] === $firstName && $user["last_name"] === $lastName) {
            $userId = $user["id"];
            break;
        }
    }

    if ($userId !== null) {
        echo "User found! ID: $userId";
    } else {
        echo "User not found.";
    }
}
?>
