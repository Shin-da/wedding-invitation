<?php
session_start();
require_once '../config/database.php';
require_once 'utils.php';

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

    // Fetch user data
    $stmt = $db->prepare("
        SELECT g.*, a.status, a.dietary_requirements, a.additional_guests, a.comments 
        FROM guests g 
        LEFT JOIN attendees a ON g.id = a.guest_id 
        WHERE g.id = ?
        ORDER BY a.created_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() > 0) {
        $userData = $stmt->fetch();
        
        // Generate HTML response
        $html = '
        <div class="modal-header">
            <h5 class="modal-title">RSVP Details</h5>
            <button type="button" class="close" id="closeModal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="rsvpForm">
                <input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">
                <div class="mb-3">
                    <p><strong>Name:</strong> ' . htmlspecialchars($userData['name']) . '</p>
                    ' . ($userData['email'] ? '<p><strong>Email:</strong> ' . htmlspecialchars($userData['email']) . '</p>' : '') . '
                    ' . ($userData['phone'] ? '<p><strong>Phone:</strong> ' . htmlspecialchars($userData['phone']) . '</p>' : '') . '
                </div>
                <div class="mb-3">
                    <label class="form-label">Will you attend?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="action" value="attending" ' . ($userData['status'] === 'attending' ? 'checked' : '') . '>
                        <label class="form-check-label">Yes, I will attend</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="action" value="not_attending" ' . ($userData['status'] === 'not_attending' ? 'checked' : '') . '>
                        <label class="form-check-label">No, I cannot attend</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="additional_guests" class="form-label">Additional Guests</label>
                    <input type="number" class="form-control" id="additional_guests" name="additional_guests" min="0" max="5" value="' . ($userData['additional_guests'] ?? 0) . '">
                </div>
                <div class="mb-3">
                    <label for="dietary" class="form-label">Dietary Requirements</label>
                    <textarea class="form-control" id="dietary" name="dietary" rows="2">' . htmlspecialchars($userData['dietary_requirements'] ?? '') . '</textarea>
                </div>
                <div class="mb-3">
                    <label for="comments" class="form-label">Additional Comments</label>
                    <textarea class="form-control" id="comments" name="comments" rows="2">' . htmlspecialchars($userData['comments'] ?? '') . '</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Response</button>
            </form>
        </div>';
        
        echo $html;
    } else {
        throw new Exception("User not found");
    }

} catch (Exception $e) {
    error_log("Error in fetch_user_data.php: " . $e->getMessage());
    http_response_code(400);
    echo "Error: " . $e->getMessage();
}
?>
