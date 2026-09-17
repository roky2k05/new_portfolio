<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/login.php
 * Secure Administrator Authentication Guard
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/csrf.php';

// If already authenticated as admin, redirect to admin dashboard
if (!empty($_SESSION['admin_id']) && isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin') {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$notice = $_GET['notice'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Invalid security token (CSRF). Please refresh.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!empty($username) && !empty($password)) {
            try {
                $pdo = getDatabaseConnection();
                $stmt = $pdo->prepare("
                    SELECT id, full_name, username, email, phone, password, role, status 
                    FROM users 
                    WHERE (username = :u OR email = :e) AND role = 'admin' 
                    LIMIT 1
                ");
                $stmt->execute([':u' => strtolower($username), ':e' => strtolower($username)]);
                $admin = $stmt->fetch();

                if ($admin && password_verify($password, $admin['password'])) {
                    if ($admin['status'] === 'disabled') {
                        $error = 'This administrative account has been deactivated.';
                    } else {
                        // Prevent session fixation
                        session_regenerate_id(true);

                        // Set session variables
                        $_SESSION['admin_id']       = (int)$admin['id'];
                        $_SESSION['admin_username'] = $admin['username'];
                        $_SESSION['admin_role']     = 'admin';
                        $_SESSION['user_id']        = (int)$admin['id'];
                        $_SESSION['username']       = $admin['username'];
                        $_SESSION['full_name']      = $admin['full_name'];
                        $_SESSION['email']          = $admin['email'];
                        $_SESSION['role']           = 'admin';

                        // Log admin login to admin_logs table
                        logAdminAction($pdo, (int)$admin['id'], 'Admin Login', 'users', (int)$admin['id'], 'Admin authenticated successfully.');

                        header('Location: dashboard.php');
                        exit;
                    }
                } else {
                    $error = 'Invalid administrator credentials.';
                }
            } catch (Exception $e) {
                error_log("Admin login error: " . $e->getMessage());
                $error = 'Database authentication error occurred.';
            }
        } else {
            $error = 'Please enter both administrator username and password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In | Rasindu Nawod</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#0b0d13] text-neutral-100 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-rose-500 selection:text-white">

    <div class="max-w-md w-full p-8 rounded-3xl bg-[#121620] border border-neutral-800 shadow-2xl space-y-6">
        
        <div class="text-center">
            <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white font-bold text-xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                RN
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Admin Console</h1>
            <p class="text-xs text-neutral-400 mt-1">Rasindu Nawod Portfolio Management</p>
        </div>

        <?php if (!empty($notice)): ?>
            <div class="p-3.5 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs text-center">
                <?= sanitize($notice); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs text-center">
                <?= sanitize($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <?= getCsrfInput(); ?>

            <div>
                <label for="username" class="block text-xs font-semibold text-neutral-300 mb-1">
                    Administrator Username
                </label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    required 
                    autocomplete="username"
                    placeholder="Enter admin username"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                >
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-neutral-300 mb-1">
                    Administrator Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                >
            </div>

            <button 
                type="submit" 
                class="w-full py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition-colors shadow-xs mt-2"
            >
                Authorize & Enter Console
            </button>
        </form>

        <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between text-xs text-neutral-500">
            <a href="../index.php" class="hover:text-neutral-300 transition-colors">
                ← Return to Public Portfolio
            </a>
            <a href="../login.php" class="hover:text-rose-400 transition-colors">
                Client Sign In
            </a>
        </div>

    </div>

</body>
</html>
