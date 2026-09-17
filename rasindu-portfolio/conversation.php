<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: conversation.php
 * Two-Way Conversation & Follow-Up Portal with Strict IDOR Protection
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

$currentUser = requireUser();
$userId = (int)$currentUser['id'];
$pdo = getDatabaseConnection();

$messageId = isset($_GET['message_id']) ? (int)$_GET['message_id'] : 0;
$conversationId = isset($_GET['conversation_id']) ? (int)$_GET['conversation_id'] : 0;

$error = '';
$success = '';

// Strict IDOR Security: Must verify the requested inquiry belongs to this logged-in user!
$contactMsg = null;
if ($messageId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :id AND user_id = :uid LIMIT 1");
    $stmt->execute([':id' => $messageId, ':uid' => $userId]);
    $contactMsg = $stmt->fetch();
}

// Check by conversation ID if provided
$conversation = null;
if ($contactMsg) {
    // Find or link corresponding conversation in conversations table
    $cStmt = $pdo->prepare("SELECT * FROM conversations WHERE user_id = :uid AND subject = :sub LIMIT 1");
    $cStmt->execute([':uid' => $userId, ':sub' => $contactMsg['subject']]);
    $conversation = $cStmt->fetch();
    if (!$conversation) {
        // Auto-create conversation container if not already created
        $createConv = $pdo->prepare("INSERT INTO conversations (user_id, subject, status, created_at) VALUES (:uid, :sub, :st, :cat)");
        $createConv->execute([
            ':uid' => $userId,
            ':sub' => $contactMsg['subject'],
            ':st'  => $contactMsg['status'],
            ':cat' => $contactMsg['created_at'],
        ]);
        $convId = (int)$pdo->lastInsertId();
        
        // Insert initial message
        $inMsg = $pdo->prepare("INSERT INTO messages (conversation_id, sender_id, sender_role, message, created_at) VALUES (:cid, :sid, 'user', :msg, :cat)");
        $inMsg->execute([
            ':cid' => $convId,
            ':sid' => $userId,
            ':msg' => $contactMsg['message'],
            ':cat' => $contactMsg['created_at'],
        ]);

        // If admin reply exists, also insert
        if (!empty($contactMsg['admin_reply'])) {
            $inAdmin = $pdo->prepare("INSERT INTO messages (conversation_id, sender_id, sender_role, message, created_at) VALUES (:cid, 1, 'admin', :msg, :cat)");
            $inAdmin->execute([
                ':cid' => $convId,
                ':msg' => $contactMsg['admin_reply'],
                ':cat' => $contactMsg['replied_at'] ?? date('Y-m-d H:i:s'),
            ]);
        }

        $cStmt->execute([':uid' => $userId, ':sub' => $contactMsg['subject']]);
        $conversation = $cStmt->fetch();
    }
} elseif ($conversationId > 0) {
    // IDOR Protection on conversationId
    $cStmt = $pdo->prepare("SELECT * FROM conversations WHERE id = :cid AND user_id = :uid LIMIT 1");
    $cStmt->execute([':cid' => $conversationId, ':uid' => $userId]);
    $conversation = $cStmt->fetch();
}

// If no matching message/conversation owned by this user, deny access!
if (!$contactMsg && !$conversation) {
    header("Location: messages.php?error=" . urlencode("Access denied: You do not have permission to access that inquiry."));
    exit;
}

$activeConvId = $conversation ? (int)$conversation['id'] : 0;

// Handle Follow-Up Reply from User to Admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation failed (CSRF token invalid). Please refresh.';
    } else {
        $replyText = trim($_POST['followup_message'] ?? '');
        if (empty($replyText)) {
            $error = 'Please write a message before sending.';
        } else {
            try {
                // Insert message into messages table
                if ($activeConvId > 0) {
                    $insertMsg = $pdo->prepare("
                        INSERT INTO messages (conversation_id, sender_id, sender_role, message, created_at)
                        VALUES (:cid, :sid, 'user', :msg, NOW())
                    ");
                    $insertMsg->execute([
                        ':cid' => $activeConvId,
                        ':sid' => $userId,
                        ':msg' => $replyText,
                    ]);

                    // Update conversation status to In Progress
                    $upConv = $pdo->prepare("UPDATE conversations SET status = 'In Progress', updated_at = NOW() WHERE id = :cid");
                    $upConv->execute([':cid' => $activeConvId]);
                }

                // Update contact_messages status
                if ($contactMsg) {
                    $upContact = $pdo->prepare("UPDATE contact_messages SET status = 'In Progress', updated_at = NOW() WHERE id = :mid");
                    $upContact->execute([':mid' => $contactMsg['id']]);
                }

                $success = 'Your reply has been sent to Rasindu Nawod.';
            } catch (PDOException $e) {
                error_log("Failed to send follow up: " . $e->getMessage());
                $error = 'An error occurred while saving your message.';
            }
        }
    }
}

// Fetch all messages in the conversation chain
$chatMessages = [];
if ($activeConvId > 0) {
    $stmt = $pdo->prepare("
        SELECT m.*, u.full_name, u.username 
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE m.conversation_id = :cid
        ORDER BY m.id ASC
    ");
    $stmt->execute([':cid' => $activeConvId]);
    $chatMessages = $stmt->fetchAll();
}

$subjectTitle = $conversation['subject'] ?? ($contactMsg['subject'] ?? 'Project Inquiry');
$currentStatus = $conversation['status'] ?? ($contactMsg['status'] ?? 'Unread');

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-screen bg-neutral-50/50 dark:bg-[#0b0d13] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <a href="messages.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 transition-colors flex items-center gap-1 mb-1">
                    ← Back to All Messages
                </a>
                <h1 class="text-xl sm:text-2xl font-extrabold font-heading text-neutral-900 dark:text-white">
                    <?= sanitize($subjectTitle); ?>
                </h1>
                <p class="text-xs text-neutral-500 mt-0.5">
                    Direct communication thread with Rasindu Nawod
                </p>
            </div>

            <div class="flex items-center gap-3">
                <?= renderStatusBadge($currentStatus); ?>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-medium">
                <?= sanitize($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-medium">
                <?= sanitize($success); ?>
            </div>
        <?php endif; ?>

        <!-- Chat / Thread View -->
        <div class="p-6 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
            
            <div class="space-y-6">
                <?php if (empty($chatMessages)): ?>
                    <!-- Fallback to contact message card if not yet in chat table -->
                    <div class="flex flex-col items-end">
                        <div class="max-w-[85%] p-4 rounded-2xl bg-rose-600 text-white shadow-xs">
                            <span class="block text-[11px] font-bold text-rose-200 mb-1">You (<?= sanitize($currentUser['full_name']); ?>)</span>
                            <p class="text-xs sm:text-sm whitespace-pre-line"><?= sanitize($contactMsg['message']); ?></p>
                            <span class="block text-[10px] text-rose-200 text-right mt-2"><?= formatDateTime($contactMsg['created_at']); ?></span>
                        </div>
                    </div>

                    <?php if (!empty($contactMsg['admin_reply'])): ?>
                        <div class="flex flex-col items-start">
                            <div class="max-w-[85%] p-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-700 shadow-xs">
                                <span class="block text-[11px] font-bold text-rose-600 dark:text-rose-400 mb-1">Rasindu Nawod (Admin)</span>
                                <p class="text-xs sm:text-sm whitespace-pre-line"><?= sanitize($contactMsg['admin_reply']); ?></p>
                                <span class="block text-[10px] text-neutral-400 text-right mt-2"><?= formatDateTime($contactMsg['replied_at']); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <?php foreach ($chatMessages as $msg): ?>
                        <?php $isAdmin = ($msg['sender_role'] === 'admin'); ?>
                        <div class="flex flex-col <?= $isAdmin ? 'items-start' : 'items-end'; ?>">
                            <div class="max-w-[85%] sm:max-w-[75%] p-4 rounded-2xl <?= $isAdmin ? 'bg-neutral-100 dark:bg-neutral-800/90 text-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-700/80' : 'bg-rose-600 text-white'; ?> shadow-xs">
                                <div class="flex items-center justify-between gap-4 mb-1">
                                    <span class="text-[11px] font-bold <?= $isAdmin ? 'text-rose-600 dark:text-rose-400' : 'text-rose-100'; ?>">
                                        <?= $isAdmin ? 'Rasindu Nawod (Admin)' : 'You (' . sanitize($msg['full_name']) . ')'; ?>
                                    </span>
                                    <span class="text-[10px] <?= $isAdmin ? 'text-neutral-400' : 'text-rose-200'; ?>">
                                        <?= formatDateTime($msg['created_at']); ?>
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                                    <?= sanitize($msg['message']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Follow-Up Message Input Form -->
            <div class="pt-6 border-t border-neutral-100 dark:border-neutral-800">
                <form action="conversation.php?<?= $messageId ? 'message_id=' . $messageId : 'conversation_id=' . $activeConvId; ?>" method="POST" class="space-y-3">
                    <?= getCsrfInput(); ?>

                    <label for="followup_message" class="block text-xs font-bold text-neutral-700 dark:text-neutral-300">
                        Reply to Rasindu Nawod
                    </label>

                    <textarea 
                        name="followup_message" 
                        id="followup_message" 
                        rows="3" 
                        required
                        placeholder="Type your response, clarification, or project specification..."
                        class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all"
                    ></textarea>

                    <div class="flex items-center justify-between pt-1">
                        <span class="text-[11px] text-neutral-400">
                            Your message is encrypted and securely sent directly to Rasindu's admin portal.
                        </span>
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors"
                        >
                            <span>Send Reply</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
