<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/csrf.php
 * CSRF Protection Token Generation and Validation
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate a cryptographically secure CSRF token and store it in session
 */
function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate submitted CSRF token
 */
function validateCsrfToken(?string $token): bool {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Render a hidden HTML CSRF input field
 */
function getCsrfInput(): string {
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}
