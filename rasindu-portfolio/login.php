<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: login.php
 * Secure User Authentication with password_verify(), CSRF, and Session Fixation Protection
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';

// Redirect if already authenticated
if (!empty($_SESSION['user_id'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

$errors = [];
$notice = $_GET['notice'] ?? '';
$isJustRegistered = isset($_GET['registered']) && $_GET['registered'] == '1';
$usernameInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $errors[] = 'Invalid security token (CSRF). Please refresh and try again.';
    }

    $usernameInput = trim($_POST['username'] ?? '');
    $passwordInput = $_POST['password'] ?? '';

    if (empty($usernameInput)) {
        $errors[] = 'Username or registered email is required.';
    }

    if (empty($passwordInput)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        try {
            $pdo = getDatabaseConnection();

            // Query by username OR email (strict authentication, never phone number alone)
            $stmt = $pdo->prepare("
                SELECT id, full_name, username, email, phone, password, role, status 
                FROM users 
                WHERE username = :u OR email = :e 
                LIMIT 1
            ");
            $stmt->execute([
                ':u' => strtolower($usernameInput),
                ':e' => strtolower($usernameInput),
            ]);
            $user = $stmt->fetch();

            if ($user && password_verify($passwordInput, $user['password'])) {
                // Check if account status is disabled
                if ($user['status'] === 'disabled') {
                    $errors[] = 'Your account has been disabled. Please contact the administrator.';
                } else {
                    // Prevent session fixation
                    session_regenerate_id(true);

                    // Establish authenticated session variables
                    $_SESSION['user_id']   = (int)$user['id'];
                    $_SESSION['username']  = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['email']     = $user['email'];
                    $_SESSION['phone']     = $user['phone'];
                    $_SESSION['role']      = $user['role'];

                    // If user is admin, also set admin session variables
                    if ($user['role'] === 'admin') {
                        $_SESSION['admin_id']       = (int)$user['id'];
                        $_SESSION['admin_username'] = $user['username'];
                        $_SESSION['admin_role']     = 'admin';
                    }

                    // Update last login timestamp
                    $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
                    $updateStmt->execute([':id' => $user['id']]);

                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        header('Location: admin/dashboard.php');
                    } else {
                        header('Location: dashboard.php');
                    }
                    exit;
                }
            } else {
                $errors[] = 'Invalid username or password. Please check your credentials.';
            }

        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $errors[] = 'A server error occurred during login. Please try again later.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="min-h-[80vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-500 border border-rose-500/20 mb-4 font-bold font-heading text-xl">
                RN
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Client Portal Sign In
            </h1>
            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-2">
                Access your private messages, quotations, and active project threads
            </p>
        </div>

        <!-- Card Container -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-sm">
            
            <?php if ($isJustRegistered): ?>
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm font-semibold">
                    ✓ Registration successful. You can now login with your username and password.
                </div>
            <?php endif; ?>

            <?php if (!empty($notice)): ?>
                <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 text-xs sm:text-sm">
                    <?= sanitize($notice); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs sm:text-sm space-y-1">
                    <?php foreach ($errors as $err): ?>
                        <div class="flex items-center gap-2">
                            <span>•</span>
                            <span><?= sanitize($err); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-4">
                <?= getCsrfInput(); ?>

                <div>
                    <label for="username" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Username or Email <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        required
                        value="<?= sanitize($usernameInput); ?>"
                        placeholder="Enter your username or email" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">
                            Password <span class="text-rose-500">*</span>
                        </label>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        placeholder="••••••••" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm shadow-xs transition-colors mt-2"
                >
                    Sign In to Dashboard
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-neutral-100 dark:border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-neutral-500">
                <div>
                    Don't have an account? 
                    <a href="register.php" class="text-rose-600 dark:text-rose-400 font-semibold hover:underline">
                        Register
                    </a>
                </div>
                <div>
                    <a href="admin/login.php" class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 underline">
                        Admin Sign In
                    </a>
                </div>
            </div>

        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
