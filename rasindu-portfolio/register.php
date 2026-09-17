<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: register.php
 * User Registration with Server-Side Validation, CSRF, and Password Hashing
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';

// Redirect already logged-in users
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$successMessage = '';
$fullName = '';
$username = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $errors[] = 'Invalid security token (CSRF). Please refresh the page and try again.';
    }

    $fullName = trim($_POST['full_name'] ?? '');
    $username = strtolower(trim($_POST['username'] ?? ''));
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($fullName)) {
        $errors[] = 'Full name is required.';
    }

    if (empty($username)) {
        $errors[] = 'Username is required.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        $errors[] = 'Username must be 3-30 alphanumeric characters and underscores only.';
    }

    if (empty($email)) {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }

    if (empty($phone)) {
        $errors[] = 'Phone number is required.';
    } elseif (!preg_match('/^(\+94|0)?7[0-9]{8}$/', preg_replace('/[\s\-]/', '', $phone))) {
        $errors[] = 'Please enter a valid Sri Lankan mobile number (e.g. +94 74 386 9265 or 0743869265).';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if ($password !== $confirm) {
        $errors[] = 'Password confirmation does not match.';
    }

    // Database uniqueness checks
    if (empty($errors)) {
        try {
            $pdo = getDatabaseConnection();
            
            // Check username
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
            if ($stmt->fetch()) {
                $errors[] = 'This username is already taken. Please choose another.';
            }

            // Check email
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :e LIMIT 1");
            $stmt->execute([':e' => $email]);
            if ($stmt->fetch()) {
                $errors[] = 'An account with this email address already exists.';
            }

            // If still clean, insert with password_hash()
            if (empty($errors)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $insert = $pdo->prepare("
                    INSERT INTO users (full_name, username, email, phone, password, role, status, created_at)
                    VALUES (:full_name, :username, :email, :phone, :password, 'user', 'active', NOW())
                ");
                $insert->execute([
                    ':full_name' => $fullName,
                    ':username'  => $username,
                    ':email'     => $email,
                    ':phone'     => $phone,
                    ':password'  => $passwordHash,
                ]);

                // Create initial welcome notification
                $newUserId = (int)$pdo->lastInsertId();
                createNotification(
                    $pdo, 
                    $newUserId, 
                    'Welcome to Rasindu Nawod Portfolio', 
                    'Your client account has been created. You can submit inquiries and track messages from your dashboard.', 
                    'system'
                );

                // Redirect to login with success flash
                header('Location: login.php?registered=1');
                exit;
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $errors[] = 'A server error occurred during registration. Please try again later.';
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
                Create an Account
            </h1>
            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-2">
                Join Rasindu Nawod's client portal to manage design inquiries & project messages
            </p>
        </div>

        <!-- Card Container -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-sm">
            
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

            <form action="register.php" method="POST" class="space-y-4">
                <?= getCsrfInput(); ?>

                <div>
                    <label for="full_name" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Full Name <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="full_name" 
                        id="full_name" 
                        required
                        value="<?= sanitize($fullName); ?>"
                        placeholder="e.g. Kaveen Jayawardena" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <div>
                    <label for="username" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Username <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        required
                        value="<?= sanitize($username); ?>"
                        placeholder="e.g. kaveen_j" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Email Address <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        required
                        value="<?= sanitize($email); ?>"
                        placeholder="name@example.com" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Phone / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        required
                        value="<?= sanitize($phone); ?>"
                        placeholder="+94 7X XXX XXXX" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                    <p class="text-[11px] text-neutral-500 mt-1">Your phone number is strictly private and visible only to the verified administrator.</p>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Password (Min 8 characters) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        placeholder="••••••••" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <div>
                    <label for="confirm_password" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                        Confirm Password <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="confirm_password" 
                        id="confirm_password" 
                        required
                        placeholder="••••••••" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm shadow-xs transition-colors mt-2"
                >
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-neutral-600 dark:text-neutral-400">
                Already registered? 
                <a href="login.php" class="text-rose-600 dark:text-rose-400 font-semibold hover:underline">
                    Sign in here
                </a>
            </div>

        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
