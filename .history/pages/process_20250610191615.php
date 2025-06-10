<?php
session_start();
require_once '../config/database.php';
require_once '../includes/utils.php';

header('Content-Type: application/json');

try {
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }

    // Validate request method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method");
    }

    // Validate CSRF token
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        throw new Exception("Invalid CSRF token");
    }

    // Sanitize and validate inputs
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');

    if (empty($name)) {
        throw new Exception("Name is required");
    }

    if (!empty($email) && !validateEmail($email)) {
        throw new Exception("Invalid email format");
    }

    if (!empty($phone) && !validatePhone($phone)) {
        throw new Exception("Invalid phone number format");
    }

    // Check if guest already exists
    $stmt = $db->prepare("SELECT id FROM guests WHERE name = ? AND (email = ? OR phone = ?)");
    $stmt->execute([$name, $email, $phone]);
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['id' => $row['id']]);
        exit;
    }

    // Insert new guest
    $stmt = $db->prepare("INSERT INTO guests (name, email, phone) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $phone]);
    
    $newId = $db->lastInsertId();
    echo json_encode(['id' => $newId]);

} catch (Exception $e) {
    error_log("Error in process.php: " . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}