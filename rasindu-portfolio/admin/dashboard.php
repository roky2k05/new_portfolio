<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/dashboard.php
 * Administrator Executive Dashboard & Analytics
 */

$pageTitle = 'Dashboard Overview';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

$pdo = getDatabaseConnection();

$stats = [
    'users'    => 0,
    'unread'   => 0,
    'replied'  => 0,
    'projects' => 0,
    'blogs'    => 0,
];

$recentMessages = [];
$recentLogs = [];

try {
    $stats['users']    = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
    $stats['unread']   = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'Unread'")->fetchColumn();
    $stats['replied']  = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'Replied'")->fetchColumn();
    $stats['projects'] = (int)$pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $stats['blogs']    = (int)$pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();

    // Latest 6 messages
    $stmt = $pdo->query("
        SELECT id, name, email, phone, subject, status, created_at 
        FROM contact_messages 
        ORDER BY id DESC 
        LIMIT 6
    ");
    $recentMessages = $stmt->fetchAll();

    // Latest 5 Audit Logs
    $stmt = $pdo->query("
        SELECT * FROM admin_logs 
        ORDER BY id DESC 
        LIMIT 5
    ");
    $recentLogs = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Admin dashboard query error: " . $e->getMessage());
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Control Hub Overview
            </h1>
            <p class="text-xs text-neutral-400 mt-1">
                Real-time portfolio inquiries, client accounts, and administrative event logs.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a 
                href="messages.php" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span>View All Inquiries</span>
            </a>
            <a 
                href="projects.php" 
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-neutral-800 text-neutral-300 hover:bg-neutral-800/80 text-xs font-semibold transition-colors"
            >
                <span>Manage Projects</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <div class="p-5 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-neutral-400">Registered Clients</span>
                <div class="p-2 rounded-xl bg-blue-500/10 text-blue-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-white mt-3"><?= $stats['users']; ?></div>
            <span class="text-[11px] text-neutral-500">Active accounts</span>
        </div>

        <div class="p-5 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-rose-400">Unread Messages</span>
                <div class="p-2 rounded-xl bg-rose-500/10 text-rose-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-rose-500 mt-3"><?= $stats['unread']; ?></div>
            <span class="text-[11px] text-neutral-500">Require direct reply</span>
        </div>

        <div class="p-5 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-400">Replied Messages</span>
                <div class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-emerald-400 mt-3"><?= $stats['replied']; ?></div>
            <span class="text-[11px] text-neutral-500">Delivered responses</span>
        </div>

        <div class="p-5 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-purple-400">Portfolio Projects</span>
                <div class="p-2 rounded-xl bg-purple-500/10 text-purple-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-white mt-3"><?= $stats['projects']; ?></div>
            <span class="text-[11px] text-neutral-500">Live showcase items</span>
        </div>

        <div class="p-5 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-400">Published Articles</span>
                <div class="p-2 rounded-xl bg-amber-500/10 text-amber-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-white mt-3"><?= $stats['blogs']; ?></div>
            <span class="text-[11px] text-neutral-500">Insights & design posts</span>
        </div>

    </div>

    <!-- Recent Inquiries Section -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-neutral-800">
            <div>
                <h2 class="text-base font-bold font-heading text-white">Recent Client Inquiries</h2>
                <p class="text-xs text-neutral-400">Contact submissions and project requests with client phone details (Admin Only)</p>
            </div>
            <a href="messages.php" class="text-xs font-semibold text-rose-400 hover:underline">
                View All Messages (<?= $stats['unread'] + $stats['replied']; ?>) →
            </a>
        </div>

        <?php if (empty($recentMessages)): ?>
            <div class="py-8 text-center text-xs text-neutral-500">
                No inquiries submitted yet.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-neutral-400 border-b border-neutral-800 uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-3">ID</th>
                            <th class="py-3 px-3">Client</th>
                            <th class="py-3 px-3">Phone (Admin Privilege)</th>
                            <th class="py-3 px-3">Subject</th>
                            <th class="py-3 px-3">Date</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                        <?php foreach ($recentMessages as $msg): ?>
                            <tr class="hover:bg-neutral-800/30 transition-colors">
                                <td class="py-3 px-3 font-mono font-bold text-neutral-500">#<?= $msg['id']; ?></td>
                                <td class="py-3 px-3">
                                    <span class="font-bold text-white block"><?= sanitize($msg['name']); ?></span>
                                    <span class="text-[11px] text-neutral-500"><?= sanitize($msg['email']); ?></span>
                                </td>
                                <td class="py-3 px-3 font-mono text-emerald-400">
                                    <?= sanitize($msg['phone']); ?>
                                </td>
                                <td class="py-3 px-3 max-w-xs truncate font-medium">
                                    <?= sanitize($msg['subject']); ?>
                                </td>
                                <td class="py-3 px-3 text-neutral-500 whitespace-nowrap">
                                    <?= date('M d, H:i', strtotime($msg['created_at'])); ?>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <?= renderStatusBadge($msg['status']); ?>
                                </td>
                                <td class="py-3 px-3 text-right whitespace-nowrap">
                                    <a 
                                        href="message-view.php?id=<?= (int)$msg['id']; ?>" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-semibold text-[11px] transition-colors"
                                    >
                                        <span>View & Reply</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Audit Logs Section -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-neutral-800">
            <div>
                <h2 class="text-base font-bold font-heading text-white">System Security Audit Trail</h2>
                <p class="text-xs text-neutral-400">Recent administrative operations recorded in <code class="text-rose-400">admin_logs</code> table</p>
            </div>
            <span class="text-xs font-mono text-neutral-500">Live Logging Active</span>
        </div>

        <?php if (empty($recentLogs)): ?>
            <div class="py-6 text-center text-xs text-neutral-500">
                No audit log entries recorded yet.
            </div>
        <?php else: ?>
            <div class="space-y-2">
                <?php foreach ($recentLogs as $log): ?>
                    <div class="p-3 rounded-xl bg-neutral-900/50 border border-neutral-800/80 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="font-bold text-white"><?= sanitize($log['action']); ?></span>
                            <span class="text-neutral-400"><?= sanitize($log['details']); ?></span>
                        </div>
                        <div class="flex items-center gap-4 text-neutral-500 font-mono text-[11px]">
                            <span>IP: <?= sanitize($log['ip_address'] ?? '127.0.0.1'); ?></span>
                            <span><?= formatDateTime($log['created_at']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
