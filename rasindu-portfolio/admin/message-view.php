<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/message-view.php
 * Admin Inquiry Inspection, Client Phone Privilege, and Reply Portal with User Notification Dispatch
 */

$pageTitle = 'View & Reply to Inquiry';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_once __DIR__ . '/../../includes/csrf.php';

$pdo = getDatabaseConnection();
$currentAdminId = (int)($_SESSION['admin_id'] ?? 1);

$msgId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($msgId <= 0) {
    header('Location: messages.php?error=Invalid+message+identifier.');
    exit;
}

$notice = '';
$error = '';

// Handle Admin Reply Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation failed (CSRF token invalid). Please refresh.';
    } else {
        $formAction = $_POST['form_action'] ?? 'reply';

        if ($formAction === 'reply') {
            $replyText = trim($_POST['admin_reply'] ?? '');
            $newStatus = trim($_POST['new_status'] ?? 'Replied');

            if (empty($replyText)) {
                $error = 'Please write a reply message before submitting.';
            } else {
                try {
                    // Update contact_messages
                    $up = $pdo->prepare("
                        UPDATE contact_messages 
                        SET admin_reply = :reply, replied_at = NOW(), status = :status, updated_at = NOW() 
                        WHERE id = :id
                    ");
                    $up->execute([
                        ':reply'  => $replyText,
                        ':status' => $newStatus,
                        ':id'     => $msgId,
                    ]);

                    // Fetch message details to check if linked to a registered user
                    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :id LIMIT 1");
                    $stmt->execute([':id' => $msgId]);
                    $msgInfo = $stmt->fetch();

                    if ($msgInfo && !empty($msgInfo['user_id'])) {
                        $targetUserId = (int)$msgInfo['user_id'];

                        // Dispatch user notification into notifications table
                        createNotification(
                            $pdo,
                            $targetUserId,
                            'New Reply to Your Inquiry',
                            'Rasindu Nawod has replied to your message regarding "' . $msgInfo['subject'] . '". View your dashboard to read the response.'
                        );

                        // Find or insert into conversations / messages tables
                        $cStmt = $pdo->prepare("SELECT id FROM conversations WHERE user_id = :uid AND subject = :sub LIMIT 1");
                        $cStmt->execute([':uid' => $targetUserId, ':sub' => $msgInfo['subject']]);
                        $conv = $cStmt->fetch();

                        if ($conv) {
                            $convId = (int)$conv['id'];
                        } else {
                            $inConv = $pdo->prepare("INSERT INTO conversations (user_id, subject, status, created_at) VALUES (:uid, :sub, 'Replied', NOW())");
                            $inConv->execute([':uid' => $targetUserId, ':sub' => $msgInfo['subject']]);
                            $convId = (int)$pdo->lastInsertId();
                        }

                        // Insert admin reply into messages thread
                        $inMsg = $pdo->prepare("
                            INSERT INTO messages (conversation_id, sender_id, sender_role, message, created_at)
                            VALUES (:cid, :sid, 'admin', :msg, NOW())
                        ");
                        $inMsg->execute([
                            ':cid' => $convId,
                            ':sid' => $currentAdminId,
                            ':msg' => $replyText,
                        ]);
                    }

                    // Log admin action to audit logs
                    logAdminAction($pdo, $currentAdminId, 'Admin Replied to Message', 'contact_messages', $msgId, "Sent reply to client for inquiry #$msgId");

                    $notice = 'Reply saved and notification dispatched to user successfully!';
                } catch (PDOException $e) {
                    error_log("Failed to send admin reply: " . $e->getMessage());
                    $error = 'Database error occurred while processing reply.';
                }
            }
        } elseif ($formAction === 'status_only') {
            $newStatus = $_POST['status'] ?? 'Read';
            try {
                $up = $pdo->prepare("UPDATE contact_messages SET status = :st, updated_at = NOW() WHERE id = :id");
                $up->execute([':st' => $newStatus, ':id' => $msgId]);
                logAdminAction($pdo, $currentAdminId, 'Updated Message Status', 'contact_messages', $msgId, "Changed status to $newStatus");
                $notice = "Inquiry status updated to $newStatus.";
            } catch (PDOException $e) {
                error_log("Status change failed: " . $e->getMessage());
                $error = 'Failed to update message status.';
            }
        }
    }
}

// Fetch message details
$msg = null;
$linkedUser = null;
try {
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $msgId]);
    $msg = $stmt->fetch();

    if ($msg && !empty($msg['user_id'])) {
        $uStmt = $pdo->prepare("SELECT id, full_name, username, email, phone, created_at, status FROM users WHERE id = :uid LIMIT 1");
        $uStmt->execute([':uid' => $msg['user_id']]);
        $linkedUser = $uStmt->fetch();
    }
} catch (PDOException $e) {
    error_log("Message fetch error: " . $e->getMessage());
}

if (!$msg) {
    echo "<div class='p-8 text-white'>Message not found. <a href='messages.php' class='text-rose-500'>Return to messages</a></div>";
    require_once __DIR__ . '/includes/admin_footer.php';
    exit;
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-6">
    
    <!-- Top Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <a href="messages.php" class="text-xs font-semibold text-neutral-400 hover:text-rose-400 transition-colors flex items-center gap-1 mb-1">
                ← Back to Inquiries List
            </a>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Inquiry #<?= str_pad($msg['id'], 4, '0', STR_PAD_LEFT); ?>: <?= sanitize($msg['subject']); ?>
            </h1>
            <p class="text-xs text-neutral-400 mt-0.5">
                Submitted on <?= formatDateTime($msg['created_at']); ?>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <?= renderStatusBadge($msg['status']); ?>
        </div>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Message Thread & Reply Form -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Original Client Message Card -->
            <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                    <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider">
                        Client Message Details
                    </span>
                    <span class="text-xs font-mono text-neutral-500">
                        <?= formatDateTime($msg['created_at']); ?>
                    </span>
                </div>

                <div class="text-xs font-semibold text-rose-400">
                    Subject: <span class="text-white"><?= sanitize($msg['subject']); ?></span>
                </div>

                <div class="p-4 rounded-xl bg-neutral-900/60 border border-neutral-800/80 text-neutral-200 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                    <?= sanitize($msg['message']); ?>
                </div>
            </div>

            <!-- Existing Admin Reply Preview (If Already Replied) -->
            <?php if (!empty($msg['admin_reply'])): ?>
                <div class="p-6 rounded-2xl bg-rose-500/5 border border-rose-500/20 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-rose-500/20 pb-3">
                        <span class="text-xs font-bold text-rose-400 uppercase tracking-wider">
                            Existing Admin Reply
                        </span>
                        <span class="text-xs text-neutral-400">
                            Replied at <?= formatDateTime($msg['replied_at']); ?>
                        </span>
                    </div>

                    <p class="text-xs sm:text-sm text-neutral-200 leading-relaxed whitespace-pre-line">
                        <?= sanitize($msg['admin_reply']); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Reply Form Card -->
            <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
                <h2 class="text-sm font-bold font-heading text-white">
                    <?= !empty($msg['admin_reply']) ? 'Update or Append Reply' : 'Send Direct Reply to Client'; ?>
                </h2>
                <p class="text-xs text-neutral-400">
                    Your response will update the inquiry status to 'Replied' and immediately post to the client's private conversation portal.
                </p>

                <form action="message-view.php?id=<?= (int)$msg['id']; ?>" method="POST" class="space-y-4">
                    <?= getCsrfInput(); ?>
                    <input type="hidden" name="form_action" value="reply">

                    <div>
                        <label for="admin_reply" class="block text-xs font-semibold text-neutral-300 mb-1">
                            Reply Message <span class="text-rose-500">*</span>
                        </label>
                        <textarea 
                            name="admin_reply" 
                            id="admin_reply" 
                            rows="5" 
                            required
                            placeholder="Write your professional response, quote estimate, or project milestones..."
                            class="w-full px-3.5 py-3 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                        ><?= sanitize($msg['admin_reply'] ?? ''); ?></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
                        <div class="flex items-center gap-2">
                            <label for="new_status" class="text-xs text-neutral-400">Set Status:</label>
                            <select 
                                name="new_status" 
                                id="new_status" 
                                class="px-3 py-1.5 rounded-lg bg-neutral-900 border border-neutral-700 text-xs text-white"
                            >
                                <option value="Replied" <?= $msg['status'] === 'Replied' ? 'selected' : ''; ?>>Replied</option>
                                <option value="In Progress" <?= $msg['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Closed" <?= $msg['status'] === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                            </select>
                        </div>

                        <button 
                            type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors shadow-xs"
                        >
                            <span>Send Reply & Dispatch Alert</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right Column: Client Details & Admin Privileges -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Sender Information Card -->
            <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
                <h2 class="text-xs font-bold text-neutral-400 uppercase tracking-wider border-b border-neutral-800 pb-3">
                    Sender Credentials
                </h2>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="block text-[11px] text-neutral-500">Full Name:</span>
                        <span class="font-bold text-white"><?= sanitize($msg['name']); ?></span>
                    </div>

                    <div>
                        <span class="block text-[11px] text-neutral-500">Email Address:</span>
                        <a href="mailto:<?= sanitize($msg['email']); ?>" class="text-rose-400 hover:underline">
                            <?= sanitize($msg['email']); ?>
                        </a>
                    </div>

                    <!-- Client Phone (Admin Privilege: Only Admin Can See This) -->
                    <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                        <span class="block text-[11px] font-bold text-emerald-400 uppercase tracking-wider mb-0.5">
                            Phone / WhatsApp (Admin Privilege)
                        </span>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $msg['phone']); ?>" target="_blank" class="font-mono font-bold text-white hover:text-emerald-300 transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.302c-.087.086-.177.181-.076.355.101.173.449.741.964 1.201.662.591 1.221.774 1.394.861.173.086.275.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.203c.044.072.044.419-.1.824z"/></svg>
                            <span><?= sanitize($msg['phone']); ?></span>
                        </a>
                        <span class="block text-[10px] text-neutral-400 mt-1">Normal users cannot see this data.</span>
                    </div>

                    <?php if ($linkedUser): ?>
                        <div class="pt-3 border-t border-neutral-800 space-y-1">
                            <span class="block text-[11px] text-neutral-500">Account Type:</span>
                            <span class="font-bold text-white">Registered Client</span>
                            <div class="text-[11px] text-neutral-400">Username: @<?= sanitize($linkedUser['username']); ?></div>
                            <div class="text-[11px] text-neutral-400">Member Since: <?= date('M Y', strtotime($linkedUser['created_at'])); ?></div>
                        </div>
                    <?php else: ?>
                        <div class="pt-3 border-t border-neutral-800">
                            <span class="text-[11px] text-neutral-400">Visitor Type: <strong>Guest</strong></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Status Change Form -->
            <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-3">
                <h2 class="text-xs font-bold text-neutral-400 uppercase tracking-wider">
                    Quick Status Management
                </h2>

                <form action="message-view.php?id=<?= (int)$msg['id']; ?>" method="POST" class="space-y-3">
                    <?= getCsrfInput(); ?>
                    <input type="hidden" name="form_action" value="status_only">

                    <select name="status" class="w-full px-3 py-2 rounded-xl bg-neutral-900 border border-neutral-700 text-xs text-white">
                        <?php foreach (['Unread', 'Read', 'In Progress', 'Replied', 'Closed'] as $st): ?>
                            <option value="<?= $st; ?>" <?= $msg['status'] === $st ? 'selected' : ''; ?>><?= $st; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="w-full py-2 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-semibold transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

        </div>

    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
