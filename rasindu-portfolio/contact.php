<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: contact.php
 * Form Processing & Secure MySQL Insertion
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false, 
        'message' => 'Method Not Allowed'
    ]);
    exit;
}

// Check if request is JSON or standard FormData
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!$data) {
    $data = $_POST;
}

// Extract fields
$name    = isset($data['name']) ? trim($data['name']) : '';
$email   = isset($data['email']) ? trim($data['email']) : '';
$phone   = isset($data['phone']) ? trim($data['phone']) : '';
$subject = isset($data['subject']) ? trim($data['subject']) : '';
$message = isset($data['message']) ? trim($data['message']) : '';

// Validation checks
$errors = [];

if (empty($name)) {
    $errors[] = 'Please enter your name.';
} elseif (strlen($name) > 100) {
    $errors[] = 'Name must not exceed 100 characters.';
}

if (empty($email)) {
    $errors[] = 'Please enter your email address.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
} elseif (strlen($email) > 150) {
    $errors[] = 'Email must not exceed 150 characters.';
}

if (empty($subject)) {
    $errors[] = 'Please enter a subject.';
} elseif (strlen($subject) > 200) {
    $errors[] = 'Subject must not exceed 200 characters.';
}

if (empty($message)) {
    $errors[] = 'Please enter your message.';
} elseif (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'errors'  => $errors,
        'message' => $errors[0]
    ]);
    exit;
}

// Client IP for logging
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;

try {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (name, email, phone, subject, message, status, ip_address)
        VALUES (:name, :email, :phone, :subject, :message, 'Unread', :ip)
    ");

    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':phone'   => !empty($phone) ? $phone : null,
        ':subject' => $subject,
        ':message' => $message,
        ':ip'      => $ipAddress,
    ]);

    // Return success
    echo json_encode([
        'success'   => true,
        'message'   => 'Thank you! Your message has been sent successfully. Rasindu will get back to you shortly.',
        'insert_id' => $pdo->lastInsertId()
    ]);
    exit;

} catch (PDOException $e) {
    error_log("Insert Message Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while saving your message. Please reach out via WhatsApp at ' . PHONE_NUMBER
    ]);
    exit;
}
