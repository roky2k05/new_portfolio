<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: dashboard.php
 * Private Client Dashboard with Session Scoping, Message Stats, and Notifications
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

// Enforce authentication
$currentUser = requireUser();
$userId = (int)$currentUser['id'];

$pdo = getDatabaseConnection();

// Fetch counts and messages securely scoped strictly by $_SESSION['user_id']
$stats = [
    'total_messages'   => 0,
    'replied_messages' => 0,
    'unread_notifs'    => 0,
];

$recentMessages = [];
$recentNotifications = [];

try {
    // Total messages sent by this user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_messages WHERE user_id = :uid");
    $stmt->execute([':uid' => $userId]);
    $stats['total_messages'] = (int)$stmt->fetchColumn();

    // Replied messages
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_messages WHERE user_id = :uid AND status = 'Replied'");
    $stmt->execute([':uid' => $userId]);
    $stats['replied_messages'] = (int)$stmt->fetchColumn();

    // Unread notifications
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :uid AND is_read = 0");
    $stmt->execute([':uid' => $userId]);
    $stats['unread_notifs'] = (int)$stmt->fetchColumn();

    // Fetch latest 5 contact messages / conversations
    $stmt = $pdo->prepare("
        SELECT id, subject, message, status, admin_reply, replied_at, created_at 
        FROM contact_messages 
        WHERE user_id = :uid 
        ORDER BY id DESC 
        LIMIT 5
    ");
    $stmt->execute([':uid' => $userId]);
    $recentMessages = $stmt->fetchAll();

    // Fetch latest unread notifications
    $stmt = $pdo->prepare("
        SELECT id, title, message, created_at 
        FROM notifications 
        WHERE user_id = :uid AND is_read = 0 
        ORDER BY id DESC 
        LIMIT 3
    ");
    $stmt->execute([':uid' => $userId]);
    $recentNotifications = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Dashboard query error: " . $e->getMessage());
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-screen bg-neutral-50/50 dark:bg-[#0b0d13] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Breadcrumb / Header Row -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-8 border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400 uppercase tracking-wider">
                    Client Portal
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight mt-1">
                    Welcome, <?= sanitize($currentUser['full_name']); ?>
                </h1>
                <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                    Manage your project inquiries, direct conversations, and profile details with Rasindu Nawod.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a 
                    href="contact.php" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-all"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>New Project Inquiry</span>
                </a>
                <a 
                    href="logout.php" 
                    class="inline-flex items-center px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                >
                    Sign Out
                </a>
            </div>
        </div>

        <!-- Dashboard Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mt-8">
            
            <!-- Sidebar Navigation -->
            <aside class="lg:col-span-1 space-y-6">
                <!-- User Profile Card -->
                <div class="p-5 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 text-white flex items-center justify-center font-heading font-bold text-lg shadow-xs">
                            <?= strtoupper(substr($currentUser['full_name'], 0, 1)); ?>
                        </div>
                        <div class="overflow-hidden">
                            <h2 class="text-sm font-bold text-neutral-900 dark:text-white truncate">
                                <?= sanitize($currentUser['full_name']); ?>
                            </h2>
                            <p class="text-xs text-neutral-500 truncate">@<?= sanitize($currentUser['username']); ?></p>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs border-t border-neutral-100 dark:border-neutral-800/80 pt-3 text-neutral-600 dark:text-neutral-400">
                        <div class="flex justify-between">
                            <span class="text-neutral-400">Email:</span>
                            <span class="font-medium text-neutral-800 dark:text-neutral-200 truncate ml-2"><?= sanitize($currentUser['email']); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-400">Phone:</span>
                            <span class="font-medium text-neutral-800 dark:text-neutral-200"><?= sanitize($currentUser['phone']); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-400">Member Since:</span>
                            <span class="font-medium text-neutral-800 dark:text-neutral-200"><?= date('M Y', strtotime($currentUser['created_at'])); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-3 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 space-y-1 text-xs font-semibold shadow-xs">
                    <a href="dashboard.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Overview</span>
                        </span>
                    </a>

                    <a href="messages.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition-colors">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            <span>My Messages</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] bg-neutral-100 dark:bg-neutral-800 text-neutral-500 font-bold"><?= $stats['total_messages']; ?></span>
                    </a>

                    <a href="notifications.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition-colors">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span>Notifications</span>
                        </span>
                        <?php if ($stats['unread_notifs'] > 0): ?>
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-rose-600 text-white font-bold"><?= $stats['unread_notifs']; ?></span>
                        <?php endif; ?>
                    </a>

                    <a href="profile.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition-colors">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>My Profile</span>
                        </span>
                    </a>

                    <a href="account-settings.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition-colors">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Account Settings</span>
                        </span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="lg:col-span-3 space-y-6">
                
                <!-- Unread Reply Notification Banner -->
                <?php if (!empty($recentNotifications)): ?>
                    <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-xl bg-rose-600 text-white mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wide">
                                    You have a new reply!
                                </h2>
                                <p class="text-xs sm:text-sm text-neutral-800 dark:text-neutral-200 mt-0.5">
                                    <?= sanitize($recentNotifications[0]['message']); ?>
                                </p>
                            </div>
                        </div>
                        <a 
                            href="messages.php" 
                            class="shrink-0 text-xs font-semibold px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white transition-colors"
                        >
                            Open Conversation
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Key Metrics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-5 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs">
                        <span class="text-xs font-semibold text-neutral-500">Inquiries Sent</span>
                        <div class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white mt-2">
                            <?= $stats['total_messages']; ?>
                        </div>
                        <p class="text-[11px] text-neutral-400 mt-1">Submitted project briefs</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs">
                        <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Replied Messages</span>
                        <div class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white mt-2">
                            <?= $stats['replied_messages']; ?>
                        </div>
                        <p class="text-[11px] text-neutral-400 mt-1">Admin answered directly</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs">
                        <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">Active Notifications</span>
                        <div class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white mt-2">
                            <?= $stats['unread_notifs']; ?>
                        </div>
                        <p class="text-[11px] text-neutral-400 mt-1">Unread alerts & responses</p>
                    </div>
                </div>

                <!-- Recent Messages Section -->
                <div class="p-6 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-neutral-100 dark:border-neutral-800">
                        <div>
                            <h2 class="text-sm font-bold text-neutral-900 dark:text-white">Recent Project Messages</h2>
                            <p class="text-xs text-neutral-500">Track current status and direct admin feedback</p>
                        </div>
                        <a href="messages.php" class="text-xs font-semibold text-rose-600 dark:text-rose-400 hover:underline">
                            View All Messages →
                        </a>
                    </div>

                    <?php if (empty($recentMessages)): ?>
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-400 mx-auto flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold text-neutral-800 dark:text-neutral-200">No project messages yet</h3>
                            <p class="text-xs text-neutral-500 mt-1 max-w-sm mx-auto">
                                Have a web development or graphic design requirement? Submit your inquiry to initiate a private conversation.
                            </p>
                            <a href="contact.php" class="inline-block mt-4 px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-semibold hover:bg-rose-700 transition-colors">
                                Start an Inquiry
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            <?php foreach ($recentMessages as $msg): ?>
                                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-neutral-900 dark:text-white">
                                                <?= sanitize($msg['subject']); ?>
                                            </span>
                                            <?= renderStatusBadge($msg['status']); ?>
                                        </div>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-1">
                                            <?= sanitize($msg['message']); ?>
                                        </p>
                                        <div class="text-[11px] text-neutral-400">
                                            Sent on <?= formatDateTime($msg['created_at']); ?>
                                        </div>
                                    </div>

                                    <div class="shrink-0 flex items-center gap-2">
                                        <a 
                                            href="conversation.php?message_id=<?= (int)$msg['id']; ?>" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 dark:border-neutral-700 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:border-rose-500 hover:text-rose-600 transition-colors"
                                        >
                                            <span>View Conversation</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </main>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
