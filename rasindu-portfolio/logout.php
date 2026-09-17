<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: logout.php
 * Secure User Logout & Session Destruction
 */

require_once __DIR__ . '/config/database.php';

// Prevent browser caching of protected states
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (session_status() === PHP_SESSION_ACTIVE) {
    // Unset all session keys
    $_SESSION = [];

    // Delete session cookie if active
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

header('Location: login.php?notice=You+have+been+successfully+logged+out.');
exit;
