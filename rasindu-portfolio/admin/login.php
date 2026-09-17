<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/login.php
 */
session_start();
require_once __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        // Check default admin credentials or database table
        if ($username === 'admin' && $password === 'rasindu@2026') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = 'admin';
            header('Location: index.php');
            exit;
        }

        try {
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $user['username'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } catch (Exception $e) {
            $error = 'Database authentication error.';
        }
    } else {
        $error = 'Please enter both username and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Rasindu Nawod</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-950 text-white min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full p-8 rounded-3xl bg-neutral-900 border border-neutral-800 shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white font-bold text-xl flex items-center justify-center mx-auto mb-3">RN</div>
            <h1 class="text-2xl font-bold">Admin Portal</h1>
            <p class="text-xs text-neutral-400 mt-1">Rasindu Nawod Portfolio Management</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="p-3.5 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs mb-6">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1">Username</label>
                <input type="text" name="username" required value="admin" class="w-full px-4 py-2.5 rounded-xl text-sm bg-neutral-800 border border-neutral-700 text-white focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1">Password</label>
                <input type="password" name="password" required placeholder="rasindu@2026" class="w-full px-4 py-2.5 rounded-xl text-sm bg-neutral-800 border border-neutral-700 text-white focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl font-semibold text-sm text-white bg-rose-600 hover:bg-rose-700 transition-all cursor-pointer">
                Sign In
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-neutral-800 text-center text-xs text-neutral-500">
            Default credentials: <code class="text-rose-400">admin</code> / <code class="text-rose-400">rasindu@2026</code>
        </div>
    </div>
</body>
</html>
