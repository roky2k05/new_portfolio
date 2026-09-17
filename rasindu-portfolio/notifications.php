<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: notifications.php
 * User Notifications Feed with Read State Management
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

$currentUser = requireUser();
$userId = (int)$currentUser['id'];
$pdo = getDatabaseConnection();

// Mark all as read if requested
if (isset($_GET['action']) && $_GET['action'] === 'mark_all_read') {
    try {
        $up = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :uid");
        $up->execute([':uid' => $userId]);
        header("Location: notifications.php");
        exit;
    } catch (Exception $e) {
        error_log("Failed to mark notifications read: " . $e->getMessage());
    }
}

// Fetch user notifications
$notifications = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :uid ORDER BY id DESC LIMIT 50");
    $stmt->execute([':uid' => $userId]);
    $notifications = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Notifications error: " . $e->getMessage());
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-screen bg-neutral-50/50 dark:bg-[#0b0d13] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between pb-6 border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <a href="dashboard.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 transition-colors flex items-center gap-1 mb-1">
                    ← Back to Dashboard
                </a>
                <h1 class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white">
                    Notifications
                </h1>
                <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-0.5">
                    Real-time alerts regarding inquiry updates, quotes, and admin replies.
                </p>
            </div>

            <a 
                href="notifications.php?action=mark_all_read" 
                class="text-xs font-semibold px-3.5 py-2 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
            >
                Mark All as Read
            </a>
        </div>

        <?php if (empty($notifications)): ?>
            <div class="p-12 text-center rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-sm font-bold text-neutral-800 dark:text-neutral-200">All caught up</h3>
                <p class="text-xs text-neutral-500 mt-1">You have no new notifications.</p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($notifications as $n): ?>
                    <div class="p-4 rounded-2xl border transition-all <?= $n['is_read'] ? 'bg-white dark:bg-[#121620] border-neutral-200 dark:border-neutral-800' : 'bg-rose-500/5 dark:bg-rose-500/10 border-rose-500/30'; ?> flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-xl <?= $n['is_read'] ? 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500' : 'bg-rose-600 text-white'; ?> mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <h2 class="text-xs sm:text-sm font-bold text-neutral-900 dark:text-white">
                                    <?= sanitize($n['title']); ?>
                                </h2>
                                <p class="text-xs text-neutral-600 dark:text-neutral-300">
                                    <?= sanitize($n['message']); ?>
                                </p>
                                <span class="block text-[10px] text-neutral-400 mt-1">
                                    <?= formatDateTime($n['created_at']); ?>
                                </span>
                            </div>
                        </div>

                        <a 
                            href="messages.php" 
                            class="shrink-0 text-xs font-semibold px-3 py-1.5 rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 hover:opacity-90 transition-opacity"
                        >
                            View
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
