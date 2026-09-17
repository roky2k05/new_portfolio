<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: account-settings.php
 * Manage Account Profile, Phone, and Password Change with Strict Security
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

$currentUser = requireUser();
$userId = (int)$currentUser['id'];
$pdo = getDatabaseConnection();

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $errors[] = 'Invalid security token (CSRF). Please refresh the page.';
    } else {
        $formType = $_POST['form_type'] ?? 'profile';

        if ($formType === 'profile') {
            $fullName = trim($_POST['full_name'] ?? '');
            $email    = strtolower(trim($_POST['email'] ?? ''));
            $phone    = trim($_POST['phone'] ?? '');

            if (empty($fullName)) {
                $errors[] = 'Full name is required.';
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Valid email is required.';
            }

            if (empty($phone)) {
                $errors[] = 'Phone number is required.';
            }

            if (empty($errors)) {
                try {
                    // Check email uniqueness if changed
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :e AND id != :id LIMIT 1");
                    $stmt->execute([':e' => $email, ':id' => $userId]);
                    if ($stmt->fetch()) {
                        $errors[] = 'This email address is already in use by another account.';
                    } else {
                        $up = $pdo->prepare("UPDATE users SET full_name = :fn, email = :em, phone = :ph WHERE id = :id");
                        $up->execute([
                            ':fn' => $fullName,
                            ':em' => $email,
                            ':ph' => $phone,
                            ':id' => $userId,
                        ]);

                        $_SESSION['full_name'] = $fullName;
                        $_SESSION['email'] = $email;
                        $_SESSION['phone'] = $phone;
                        $currentUser['full_name'] = $fullName;
                        $currentUser['email'] = $email;
                        $currentUser['phone'] = $phone;

                        $successMessage = 'Profile information updated successfully.';
                    }
                } catch (PDOException $e) {
                    error_log("Profile update error: " . $e->getMessage());
                    $errors[] = 'Failed to update profile due to a database error.';
                }
            }
        } elseif ($formType === 'password') {
            $currentPass = $_POST['current_password'] ?? '';
            $newPass     = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            if (empty($currentPass)) {
                $errors[] = 'Current password is required.';
            }

            if (empty($newPass) || strlen($newPass) < 8) {
                $errors[] = 'New password must be at least 8 characters.';
            }

            if ($newPass !== $confirmPass) {
                $errors[] = 'New password confirmation does not match.';
            }

            if (empty($errors)) {
                try {
                    // Verify current password against database
                    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
                    $stmt->execute([':id' => $userId]);
                    $dbPass = $stmt->fetchColumn();

                    if (!password_verify($currentPass, $dbPass)) {
                        $errors[] = 'Your current password was incorrect.';
                    } else {
                        $newHash = password_hash($newPass, PASSWORD_BCRYPT);
                        $up = $pdo->prepare("UPDATE users SET password = :p WHERE id = :id");
                        $up->execute([':p' => $newHash, ':id' => $userId]);

                        $successMessage = 'Password changed successfully.';
                    }
                } catch (PDOException $e) {
                    error_log("Password change error: " . $e->getMessage());
                    $errors[] = 'Failed to change password. Please try again.';
                }
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-screen bg-neutral-50/50 dark:bg-[#0b0d13] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="pb-6 border-b border-neutral-200 dark:border-neutral-800">
            <a href="dashboard.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 transition-colors flex items-center gap-1 mb-1">
                ← Back to Dashboard
            </a>
            <h1 class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white">
                Account Settings
            </h1>
            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-0.5">
                Update personal details, communication preferences, and security credentials.
            </p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs sm:text-sm space-y-1">
                <?php foreach ($errors as $err): ?>
                    <div>• <?= sanitize($err); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm font-semibold">
                ✓ <?= sanitize($successMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Profile Information Form -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-neutral-900 dark:text-white">
                Personal Information
            </h2>

            <form action="account-settings.php" method="POST" class="space-y-4">
                <?= getCsrfInput(); ?>
                <input type="hidden" name="form_type" value="profile">

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Username (Fixed)</label>
                    <input 
                        type="text" 
                        disabled
                        value="@<?= sanitize($currentUser['username']); ?>" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-800/60 text-neutral-500 text-sm cursor-not-allowed"
                    >
                </div>

                <div>
                    <label for="full_name" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Full Name</label>
                    <input 
                        type="text" 
                        name="full_name" 
                        id="full_name" 
                        required
                        value="<?= sanitize($currentUser['full_name']); ?>" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                    >
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        required
                        value="<?= sanitize($currentUser['email']); ?>" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                    >
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Phone Number</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        required
                        value="<?= sanitize($currentUser['phone']); ?>" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                    >
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-colors">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Change Form -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-neutral-900 dark:text-white">
                Change Password
            </h2>
            <p class="text-xs text-neutral-500">
                Ensure your account is using a secure password of at least 8 characters.
            </p>

            <form action="account-settings.php" method="POST" class="space-y-4">
                <?= getCsrfInput(); ?>
                <input type="hidden" name="form_type" value="password">

                <div>
                    <label for="current_password" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Current Password</label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        required
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                    >
                </div>

                <div>
                    <label for="new_password" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">New Password (Min 8 chars)</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        required
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                    >
                </div>

                <div>
                    <label for="confirm_password" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Confirm New Password</label>
                    <input 
                        type="password" 
                        name="confirm_password" 
                        id="confirm_password" 
                        required
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                    >
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 text-xs font-semibold hover:opacity-90 transition-opacity">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
