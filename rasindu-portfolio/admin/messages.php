<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/messages.php
 * Administrative Inquiries & Message Management with Status Filtering & Client Phone Visibility
 */

$pageTitle = 'Project Inquiries';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_once __DIR__ . '/../../includes/csrf.php';

$pdo = getDatabaseConnection();
$currentAdminId = (int)($_SESSION['admin_id'] ?? 1);

$notice = '';
$error = '';

// Handle Status Change or Delete Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation token expired. Please retry.';
    } else {
        $action = $_POST['action'] ?? '';
        $msgId  = (int)($_POST['message_id'] ?? 0);

        if ($action === 'update_status' && $msgId > 0) {
            $allowedStatuses = ['Unread', 'Read', 'In Progress', 'Replied', 'Closed'];
            $newStatus = in_array($_POST['status'], $allowedStatuses) ? $_POST['status'] : 'Read';

            try {
                $up = $pdo->prepare("UPDATE contact_messages SET status = :st, updated_at = NOW() WHERE id = :id");
                $up->execute([':st' => $newStatus, ':id' => $msgId]);

                logAdminAction($pdo, $currentAdminId, 'Update Message Status', 'contact_messages', $msgId, "Updated message #$msgId status to $newStatus");
                $notice = "Inquiry #$msgId status updated to $newStatus.";
            } catch (PDOException $e) {
                error_log("Failed to update status: " . $e->getMessage());
                $error = 'Database error while updating message status.';
            }
        } elseif ($action === 'delete_message' && $msgId > 0) {
            try {
                $del = $pdo->prepare("DELETE FROM contact_messages WHERE id = :id");
                $del->execute([':id' => $msgId]);

                logAdminAction($pdo, $currentAdminId, 'Delete Message', 'contact_messages', $msgId, "Deleted inquiry message #$msgId");
                $notice = "Inquiry #$msgId deleted permanently.";
            } catch (PDOException $e) {
                error_log("Failed to delete message: " . $e->getMessage());
                $error = 'Database error while deleting message.';
            }
        }
    }
}

// Search & Filtering
$statusFilter = $_GET['status'] ?? 'All';
$searchQuery  = trim($_GET['search'] ?? '');

$sql = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];

if ($statusFilter !== 'All' && in_array($statusFilter, ['Unread', 'Read', 'In Progress', 'Replied', 'Closed'])) {
    $sql .= " AND status = :status";
    $params[':status'] = $statusFilter;
}

if (!empty($searchQuery)) {
    $sql .= " AND (name LIKE :q OR email LIKE :q OR phone LIKE :q OR subject LIKE :q OR message LIKE :q)";
    $params[':q'] = "%$searchQuery%";
}

$sql .= " ORDER BY id DESC";

$messages = [];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $messages = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Inquiries fetch error: " . $e->getMessage());
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-6">
    
    <!-- Top Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Project Inquiries & Messages
            </h1>
            <p class="text-xs text-neutral-400 mt-0.5">
                Review submitted client specifications, phone numbers (Admin Privilege), and conversation statuses.
            </p>
        </div>

        <span class="text-xs font-mono px-3 py-1.5 rounded-xl bg-neutral-800 text-neutral-300">
            Total Results: <?= count($messages); ?>
        </span>
    </div>

    <?php if (!empty($notice)): ?>
        <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
            ✓ <?= sanitize($notice); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-semibold">
            <?= sanitize($error); ?>
        </div>
    <?php endif; ?>

    <!-- Filter & Search Controls -->
    <div class="p-4 rounded-2xl bg-[#121620] border border-neutral-800 flex flex-col md:flex-row items-center justify-between gap-4">
        
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-1.5 w-full md:w-auto">
            <?php foreach (['All', 'Unread', 'Read', 'In Progress', 'Replied', 'Closed'] as $st): ?>
                <a 
                    href="messages.php?status=<?= urlencode($st); ?><?= !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : ''; ?>"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors <?= $statusFilter === $st ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/80'; ?>"
                >
                    <?= $st; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Search Input -->
        <form action="messages.php" method="GET" class="flex items-center gap-2 w-full md:w-auto">
            <?php if ($statusFilter !== 'All'): ?>
                <input type="hidden" name="status" value="<?= sanitize($statusFilter); ?>">
            <?php endif; ?>
            <input 
                type="text" 
                name="search" 
                value="<?= sanitize($searchQuery); ?>" 
                placeholder="Search name, phone, email..." 
                class="w-full sm:w-64 px-3.5 py-1.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs focus:outline-none focus:ring-2 focus:ring-rose-500"
            >
            <button 
                type="submit" 
                class="px-3.5 py-1.5 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-semibold transition-colors"
            >
                Search
            </button>
            <?php if (!empty($searchQuery)): ?>
                <a href="messages.php?status=<?= urlencode($statusFilter); ?>" class="text-xs text-neutral-400 hover:text-white">Clear</a>
            <?php endif; ?>
        </form>

    </div>

    <!-- Messages Table -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
        <?php if (empty($messages)): ?>
            <div class="py-12 text-center text-neutral-500 text-xs">
                No inquiries matching criteria.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-neutral-400 border-b border-neutral-800 uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-3">Inquiry ID</th>
                            <th class="py-3 px-3">Sender Client</th>
                            <th class="py-3 px-3">Phone (Admin Privilege)</th>
                            <th class="py-3 px-3">Subject & Snippet</th>
                            <th class="py-3 px-3">Date</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                        <?php foreach ($messages as $msg): ?>
                            <tr class="hover:bg-neutral-800/30 transition-colors">
                                <td class="py-3.5 px-3 font-mono font-bold text-neutral-500">
                                    #<?= str_pad($msg['id'], 4, '0', STR_PAD_LEFT); ?>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="font-bold text-white block"><?= sanitize($msg['name']); ?></span>
                                    <span class="text-[11px] text-neutral-400"><?= sanitize($msg['email']); ?></span>
                                    <?php if (!empty($msg['user_id'])): ?>
                                        <span class="inline-block mt-0.5 px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">Registered User #<?= (int)$msg['user_id']; ?></span>
                                    <?php else: ?>
                                        <span class="inline-block mt-0.5 px-1.5 py-0.5 rounded text-[9px] font-medium bg-neutral-800 text-neutral-400">Guest Visitor</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-3 font-mono text-emerald-400 font-semibold whitespace-nowrap">
                                    <?= sanitize($msg['phone']); ?>
                                </td>
                                <td class="py-3.5 px-3 max-w-xs">
                                    <span class="font-bold text-white block truncate"><?= sanitize($msg['subject']); ?></span>
                                    <span class="text-[11px] text-neutral-400 truncate block"><?= sanitize($msg['message']); ?></span>
                                </td>
                                <td class="py-3.5 px-3 text-neutral-500 whitespace-nowrap">
                                    <?= formatDateTime($msg['created_at']); ?>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    <?= renderStatusBadge($msg['status']); ?>
                                </td>
                                <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a 
                                            href="message-view.php?id=<?= (int)$msg['id']; ?>" 
                                            class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-semibold text-[11px] transition-colors"
                                        >
                                            View & Reply
                                        </a>

                                        <!-- Quick Delete -->
                                        <form action="messages.php" method="POST" onsubmit="return confirm('Delete inquiry #<?= (int)$msg['id']; ?> permanently?');" class="inline">
                                            <?= getCsrfInput(); ?>
                                            <input type="hidden" name="action" value="delete_message">
                                            <input type="hidden" name="message_id" value="<?= (int)$msg['id']; ?>">
                                            <button 
                                                type="submit" 
                                                class="p-1.5 rounded-lg bg-neutral-800 hover:bg-red-500/20 hover:text-red-400 text-neutral-400 transition-colors"
                                                title="Delete Message"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
