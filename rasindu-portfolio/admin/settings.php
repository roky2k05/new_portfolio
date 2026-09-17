<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/settings.php
 * Administrator Credential Management & Master Password Modification
 */

$pageTitle = 'Security & Settings';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_once __DIR__ . '/../../includes/csrf.php';

$pdo = getDatabaseConnection();
$currentAdminId = (int)($_SESSION['admin_id'] ?? 1);

$notice = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation failed (CSRF token invalid). Please refresh.';
    } else {
        $currentPass = $_POST['current_password'] ?? '';
        $newPass     = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
            $error = 'All password fields are strictly required.';
        } elseif (strlen($newPass) < 8) {
            $error = 'New administrator password must be at least 8 characters long.';
        } elseif ($newPass !== $confirmPass) {
            $error = 'New password and confirmation do not match.';
        } else {
            try {
                // Verify existing password
                $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id AND role = 'admin' LIMIT 1");
                $stmt->execute([':id' => $currentAdminId]);
                $dbPass = $stmt->fetchColumn();

                if (!password_verify($currentPass, $dbPass)) {
                    $error = 'Current administrator password verification failed.';
                } else {
                    $newHash = password_hash($newPass, PASSWORD_BCRYPT);
                    $up = $pdo->prepare("UPDATE users SET password = :p WHERE id = :id");
                    $up->execute([':p' => $newHash, ':id' => $currentAdminId]);

                    logAdminAction($pdo, $currentAdminId, 'Admin Password Changed', 'users', $currentAdminId, 'Administrator master password was updated.');
                    $notice = 'Administrator password has been successfully updated!';
                }
            } catch (PDOException $e) {
                error_log("Password update error: " . $e->getMessage());
                $error = 'Database error while modifying credentials.';
            }
        }
    }
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-6">
    
    <!-- Header -->
    <div class="pb-6 border-b border-neutral-800">
        <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
            Security & Administrator Settings
        </h1>
        <p class="text-xs text-neutral-400 mt-0.5">
            Update your master administrative credentials and manage environment security policies.
        </p>
    </div>

    <?php if (!empty($notice)): ?>
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
            ✓ <?= sanitize($notice); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-semibold">
            <?= sanitize($error); ?>
        </div>
    <?php endif; ?>

    <!-- Password Modification Card -->
    <div class="max-w-xl p-6 sm:p-8 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <div>
            <h2 class="text-sm font-bold font-heading text-white">
                Change Master Admin Password
            </h2>
            <p class="text-xs text-neutral-400 mt-0.5">
                Always ensure a strong, complex passphrase. The password is encrypted with Bcrypt before persistence.
            </p>
        </div>

        <form action="settings.php" method="POST" class="space-y-4 pt-2">
            <?= getCsrfInput(); ?>

            <div>
                <label for="current_password" class="block text-xs font-semibold text-neutral-300 mb-1">
                    Current Password <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="current_password" 
                    id="current_password" 
                    required 
                    placeholder="Enter current password"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                >
            </div>

            <div>
                <label for="new_password" class="block text-xs font-semibold text-neutral-300 mb-1">
                    New Master Password (Min 8 characters) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="new_password" 
                    id="new_password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                >
            </div>

            <div>
                <label for="confirm_password" class="block text-xs font-semibold text-neutral-300 mb-1">
                    Confirm New Master Password <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm_password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                >
            </div>

            <div class="pt-2">
                <button 
                    type="submit" 
                    class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors shadow-xs"
                >
                    Save & Apply Password
                </button>
            </div>
        </form>
    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
