<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/auth.php
 * User Authentication & Session Verification Guards
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

/**
 * Set HTTP no-cache headers to prevent back-button access to authenticated content
 */
function setNoCacheHeaders(): void {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
}

/**
 * Guard: Require logged-in user session
 */
function requireUser(): array {
    setNoCacheHeaders();

    if (empty($_SESSION['user_id'])) {
        header('Location: login.php?notice=Please+login+to+access+your+dashboard');
        exit;
    }

    // Verify user still exists in database and account is active
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT id, full_name, username, email, phone, role, status, profile_image, created_at FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!$user) {
            session_unset();
            session_destroy();
            header('Location: login.php?error=Account+not+found.+Please+sign+in+again.');
            exit;
        }

        if ($user['status'] === 'disabled') {
            session_unset();
            session_destroy();
            header('Location: login.php?error=Your+account+has+been+disabled.+Please+contact+the+administrator.');
            exit;
        }

        return $user;
    } catch (Exception $e) {
        error_log("User Auth Guard Error: " . $e->getMessage());
        return [
            'id' => $_SESSION['user_id'],
            'full_name' => $_SESSION['full_name'] ?? 'User',
            'username' => $_SESSION['username'] ?? '',
            'email' => $_SESSION['email'] ?? '',
            'phone' => $_SESSION['phone'] ?? '',
            'role' => $_SESSION['role'] ?? 'user',
            'status' => 'active',
            'profile_image' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}

/**
 * Check if a normal user or admin is currently logged in
 */
function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

/**
 * Check if the currently logged-in user is an admin
 */
function isUserAdmin(): bool {
    return !empty($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
