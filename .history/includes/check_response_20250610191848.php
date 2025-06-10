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

    // Validate request
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method");
    }

    // Validate CSRF token
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        throw new Exception("Invalid CSRF token");
    }

    $userId = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
    if (!$userId) {
        throw new Exception("Invalid user ID");
    }

    // Check if response exists
    $stmt = $db->prepare("SELECT status FROM attendees WHERE guest_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => $row['status']]);
    } else {
        echo json_encode(['status' => 'not_found']);
    }

} catch (Exception $e) {
    error_log("Error in check_response.php: " . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
