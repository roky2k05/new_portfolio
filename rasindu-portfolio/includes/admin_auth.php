<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/admin_auth.php
 * Role-Based Admin Access Guard (Strict Access Control)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

/**
 * Enforce Admin Role Access
 * If user is not logged in => redirect to /admin/login.php
 * If logged in but role is NOT admin => redirect to /dashboard.php (Strict RBAC protection)
 */
function requireAdmin(): array {
    // Prevent browser caching of admin pages
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    // Check if any user is logged in
    $adminId = $_SESSION['admin_id'] ?? ($_SESSION['user_id'] ?? null);
    $adminRole = $_SESSION['admin_role'] ?? ($_SESSION['role'] ?? null);

    if (empty($adminId)) {
        header('Location: login.php?notice=Please+sign+in+with+administrator+credentials');
        exit;
    }

    // If logged in as normal user, strictly deny access and redirect to user dashboard
    if ($adminRole !== 'admin') {
        header('Location: ../dashboard.php?error=Access+denied.+Administrator+privileges+required.');
        exit;
    }

    // Verify admin in database
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT id, full_name, username, email, phone, role, status FROM users WHERE id = :id AND role = 'admin' LIMIT 1");
        $stmt->execute([':id' => $adminId]);
        $admin = $stmt->fetch();

        if (!$admin || $admin['status'] === 'disabled') {
            session_unset();
            session_destroy();
            header('Location: login.php?error=Admin+account+invalid+or+disabled.');
            exit;
        }

        return $admin;
    } catch (Exception $e) {
        error_log("Admin Auth Error: " . $e->getMessage());
        return [
            'id' => $adminId,
            'full_name' => $_SESSION['admin_username'] ?? 'Rasindu Nawod',
            'username' => $_SESSION['admin_username'] ?? 'rasindu',
            'email' => ADMIN_EMAIL,
            'phone' => PHONE_NUMBER,
            'role' => 'admin',
            'status' => 'active',
        ];
    }
}
