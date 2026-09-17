<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/index.php
 * Admin Dashboard - View and Manage Inquiries
 */
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDatabaseConnection();

// Handle Status Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $msgId = (int)$_POST['message_id'];
    $newStatus = in_array($_POST['status'], ['Unread', 'Read', 'Replied']) ? $_POST['status'] : 'Read';
    
    $stmt = $pdo->prepare("UPDATE contact_messages SET status = :s WHERE id = :id");
    $stmt->execute([':s' => $newStatus, ':id' => $msgId]);
    header('Location: index.php?updated=1');
    exit;
}

// Handle Message Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $msgId = (int)$_POST['message_id'];
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = :id");
    $stmt->execute([':id' => $msgId]);
    header('Location: index.php?deleted=1');
    exit;
}

// Fetch Messages
$filter = isset($_GET['status']) ? $_GET['status'] : 'All';
if ($filter === 'All') {
    $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE status = :st ORDER BY created_at DESC");
    $stmt->execute([':st' => $filter]);
}
$messages = $stmt->fetchAll();

// Counts
$totalCount = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$unreadCount = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'Unread'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Rasindu Nawod Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-950 text-neutral-100 min-h-screen">
    
    <!-- Top Navigation -->
    <header class="border-b border-neutral-800 bg-neutral-900/80 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-600 font-bold flex items-center justify-center text-sm">RN</div>
                <span class="font-bold text-sm">Rasindu Nawod Admin Console</span>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <a href="../index.php" target="_blank" class="text-neutral-400 hover:text-white">View Live Site ↗</a>
                <a href="logout.php" class="px-3 py-1.5 rounded-lg bg-neutral-800 text-neutral-300 hover:bg-neutral-700">Logout</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 space-y-6">
        
        <!-- Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 rounded-2xl bg-neutral-900 border border-neutral-800">
                <div class="text-xs text-neutral-400 uppercase font-semibold">Total Inquiries</div>
                <div class="text-2xl font-bold text-white mt-1"><?= $totalCount; ?></div>
            </div>
            <div class="p-5 rounded-2xl bg-neutral-900 border border-neutral-800">
                <div class="text-xs text-rose-400 uppercase font-semibold">Unread Messages</div>
                <div class="text-2xl font-bold text-rose-500 mt-1"><?= $unreadCount; ?></div>
            </div>
            <div class="p-5 rounded-2xl bg-neutral-900 border border-neutral-800">
                <div class="text-xs text-emerald-400 uppercase font-semibold">Database Status</div>
                <div class="text-base font-bold text-emerald-400 mt-1">Connected (MySQL)</div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-bold">Inquiries & Contact Requests</h2>
            <div class="flex gap-2 text-xs">
                <a href="index.php?status=All" class="px-3 py-1.5 rounded-lg <?= $filter === 'All' ? 'bg-rose-600 text-white' : 'bg-neutral-800 text-neutral-400' ?>">All</a>
                <a href="index.php?status=Unread" class="px-3 py-1.5 rounded-lg <?= $filter === 'Unread' ? 'bg-rose-600 text-white' : 'bg-neutral-800 text-neutral-400' ?>">Unread</a>
                <a href="index.php?status=Read" class="px-3 py-1.5 rounded-lg <?= $filter === 'Read' ? 'bg-rose-600 text-white' : 'bg-neutral-800 text-neutral-400' ?>">Read</a>
                <a href="index.php?status=Replied" class="px-3 py-1.5 rounded-lg <?= $filter === 'Replied' ? 'bg-rose-600 text-white' : 'bg-neutral-800 text-neutral-400' ?>">Replied</a>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="bg-neutral-900 rounded-2xl overflow-hidden border border-neutral-800 shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-neutral-800 text-neutral-400 uppercase font-mono">
                        <tr>
                            <th class="p-4">Sender</th>
                            <th class="p-4">Subject & Message</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800">
                        <?php if (empty($messages)): ?>
                            <tr>
                                <td colspan="5" class="p-8 text-center text-neutral-500">No inquiries found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($messages as $msg): ?>
                            <tr class="hover:bg-neutral-850">
                                <td class="p-4">
                                    <div class="font-bold text-white"><?= htmlspecialchars($msg['name']); ?></div>
                                    <div class="text-neutral-400 text-[11px]"><?= htmlspecialchars($msg['email']); ?></div>
                                    <?php if (!empty($msg['phone'])): ?>
                                        <div class="text-neutral-500 text-[10px]"><?= htmlspecialchars($msg['phone']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 max-w-sm">
                                    <div class="font-semibold text-neutral-200"><?= htmlspecialchars($msg['subject']); ?></div>
                                    <div class="text-neutral-400 text-[11px] mt-1 whitespace-pre-line"><?= htmlspecialchars($msg['message']); ?></div>
                                </td>
                                <td class="p-4 text-neutral-400 font-mono text-[11px]"><?= $msg['created_at']; ?></td>
                                <td class="p-4">
                                    <form action="index.php" method="POST" class="inline-block">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="message_id" value="<?= $msg['id']; ?>">
                                        <select name="status" onchange="this.form.submit()" class="bg-neutral-800 border border-neutral-700 rounded px-2 py-1 text-[11px]">
                                            <option value="Unread" <?= $msg['status'] === 'Unread' ? 'selected' : ''; ?>>Unread</option>
                                            <option value="Read" <?= $msg['status'] === 'Read' ? 'selected' : ''; ?>>Read</option>
                                            <option value="Replied" <?= $msg['status'] === 'Replied' ? 'selected' : ''; ?>>Replied</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <a href="mailto:<?= htmlspecialchars($msg['email']); ?>?subject=Re:%20<?= urlencode($msg['subject']); ?>" class="text-rose-400 hover:underline">Email</a>
                                    <?php if (!empty($msg['phone'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $msg['phone']); ?>" target="_blank" class="text-emerald-400 hover:underline">WhatsApp</a>
                                    <?php endif; ?>
                                    <form action="index.php" method="POST" class="inline-block" onsubmit="return confirm('Delete this inquiry?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="message_id" value="<?= $msg['id']; ?>">
                                        <button type="submit" class="text-neutral-500 hover:text-rose-500">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>
