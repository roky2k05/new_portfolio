<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: messages.php
 * Logged-In User Message Tracker (Strict Ownership Verification)
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

$currentUser = requireUser();
$userId = (int)$currentUser['id'];
$pdo = getDatabaseConnection();

$messages = [];
try {
    // Strictly verify ownership by filtering exclusively with $_SESSION['user_id']
    $stmt = $pdo->prepare("
        SELECT id, subject, message, status, admin_reply, replied_at, created_at 
        FROM contact_messages 
        WHERE user_id = :uid 
        ORDER BY id DESC
    ");
    $stmt->execute([':uid' => $userId]);
    $messages = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("User messages query error: " . $e->getMessage());
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-screen bg-neutral-50/50 dark:bg-[#0b0d13] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto space-y-6">
        
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <a href="dashboard.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 transition-colors flex items-center gap-1 mb-1">
                    ← Back to Dashboard
                </a>
                <h1 class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white">
                    My Project Inquiries & Messages
                </h1>
                <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-0.5">
                    Track communications, project milestones, and direct admin responses.
                </p>
            </div>

            <a 
                href="contact.php" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-all self-start sm:self-auto"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Send New Inquiry</span>
            </a>
        </div>

        <!-- Messages List -->
        <?php if (empty($messages)): ?>
            <div class="p-12 text-center rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h3 class="text-sm font-bold text-neutral-800 dark:text-neutral-200">No inquiries found</h3>
                <p class="text-xs text-neutral-500 mt-1 max-w-sm mx-auto">
                    You haven't submitted any messages yet. Click "Send New Inquiry" to submit your project requirements.
                </p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($messages as $msg): ?>
                    <div class="p-6 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-4">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-neutral-100 dark:border-neutral-800/80 pb-3">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-mono font-bold text-neutral-400">#<?= str_pad($msg['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                <h2 class="text-sm font-bold text-neutral-900 dark:text-white">
                                    <?= sanitize($msg['subject']); ?>
                                </h2>
                            </div>
                            <div class="flex items-center gap-3">
                                <?= renderStatusBadge($msg['status']); ?>
                                <span class="text-xs text-neutral-400">
                                    Sent: <?= formatDateTime($msg['created_at']); ?>
                                </span>
                            </div>
                        </div>

                        <!-- User's Initial Message -->
                        <div class="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800/60">
                            <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">
                                Your Message
                            </span>
                            <p class="text-xs sm:text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
                                <?= sanitize($msg['message']); ?>
                            </p>
                        </div>

                        <!-- Admin Reply Preview (If available) -->
                        <?php if (!empty($msg['admin_reply'])): ?>
                            <div class="p-4 rounded-xl bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                                        <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">
                                            Admin Reply (Rasindu Nawod)
                                        </span>
                                    </div>
                                    <?php if ($msg['replied_at']): ?>
                                        <span class="text-[10px] text-neutral-400">
                                            Replied: <?= formatDateTime($msg['replied_at']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-xs sm:text-sm text-neutral-800 dark:text-neutral-200 leading-relaxed whitespace-pre-line">
                                    <?= sanitize($msg['admin_reply']); ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <!-- Action Footer -->
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a 
                                href="conversation.php?message_id=<?= (int)$msg['id']; ?>" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 text-xs font-semibold hover:opacity-90 transition-opacity"
                            >
                                <span>View Full Conversation & Follow Up</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
