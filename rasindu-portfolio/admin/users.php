<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/users.php
 * Administrative Registered User Management (Status Toggle & Phone Inspection)
 */

$pageTitle = 'Registered Clients';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_once __DIR__ . '/../../includes/csrf.php';

$pdo = getDatabaseConnection();
$currentAdminId = (int)($_SESSION['admin_id'] ?? 1);

$notice = '';
$error = '';

// Handle Status Toggle or Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation failed (CSRF token invalid).';
    } else {
        $action = $_POST['action'] ?? '';
        $targetUserId = (int)($_POST['target_user_id'] ?? 0);

        if ($targetUserId > 0) {
            // Protect main admin account from accidental self-deletion or disabling
            if ($targetUserId === $currentAdminId) {
                $error = 'You cannot disable or delete your active administrator account.';
            } else {
                if ($action === 'toggle_status') {
                    $newStatus = $_POST['new_status'] === 'disabled' ? 'disabled' : 'active';
                    try {
                        $up = $pdo->prepare("UPDATE users SET status = :st WHERE id = :id");
                        $up->execute([':st' => $newStatus, ':id' => $targetUserId]);

                        logAdminAction($pdo, $currentAdminId, 'Toggle User Status', 'users', $targetUserId, "Changed user #$targetUserId status to $newStatus");
                        $notice = "User #$targetUserId status changed to $newStatus.";
                    } catch (PDOException $e) {
                        error_log("Status toggle error: " . $e->getMessage());
                        $error = 'Database error while toggling status.';
                    }
                } elseif ($action === 'delete_user') {
                    try {
                        $del = $pdo->prepare("DELETE FROM users WHERE id = :id AND role != 'admin'");
                        $del->execute([':id' => $targetUserId]);

                        logAdminAction($pdo, $currentAdminId, 'Delete User', 'users', $targetUserId, "Permanently deleted user #$targetUserId");
                        $notice = "User account #$targetUserId deleted permanently.";
                    } catch (PDOException $e) {
                        error_log("Delete user error: " . $e->getMessage());
                        $error = 'Database error while deleting user.';
                    }
                }
            }
        }
    }
}

// Search
$search = trim($_GET['search'] ?? '');
$sql = "SELECT * FROM users WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (full_name LIKE :q OR username LIKE :q OR email LIKE :q OR phone LIKE :q)";
    $params[':q'] = "%$search%";
}

$sql .= " ORDER BY role DESC, id DESC";

$users = [];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Fetch users error: " . $e->getMessage());
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Registered Clients & Users
            </h1>
            <p class="text-xs text-neutral-400 mt-0.5">
                Full client registry with direct phone access (Admin Privilege), account states, and registration logs.
            </p>
        </div>

        <!-- Search Box -->
        <form action="users.php" method="GET" class="flex items-center gap-2">
            <input 
                type="text" 
                name="search" 
                value="<?= sanitize($search); ?>" 
                placeholder="Search name, phone, email..." 
                class="px-3.5 py-1.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs focus:outline-none focus:ring-2 focus:ring-rose-500 w-56"
            >
            <button type="submit" class="px-3 py-1.5 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-semibold">
                Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="users.php" class="text-xs text-neutral-400 hover:text-white">Clear</a>
            <?php endif; ?>
        </form>
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

    <!-- User Table Card -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-neutral-400 border-b border-neutral-800 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-3">ID</th>
                        <th class="py-3 px-3">Full Name & Username</th>
                        <th class="py-3 px-3">Email Address</th>
                        <th class="py-3 px-3">Phone (Admin Privilege)</th>
                        <th class="py-3 px-3">Role</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3">Joined</th>
                        <th class="py-3 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3.5 px-3 font-mono font-bold text-neutral-500">
                                #<?= $u['id']; ?>
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="font-bold text-white block"><?= sanitize($u['full_name']); ?></span>
                                <span class="text-[11px] text-neutral-400 font-mono">@<?= sanitize($u['username']); ?></span>
                            </td>
                            <td class="py-3.5 px-3">
                                <a href="mailto:<?= sanitize($u['email']); ?>" class="text-neutral-300 hover:text-rose-400">
                                    <?= sanitize($u['email']); ?>
                                </a>
                            </td>
                            <td class="py-3.5 px-3 font-mono text-emerald-400 font-semibold whitespace-nowrap">
                                <?= sanitize($u['phone']); ?>
                            </td>
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $u['role'] === 'admin' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/30' : 'bg-neutral-800 text-neutral-400'; ?>">
                                    <?= sanitize($u['role']); ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase <?= $u['status'] === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20'; ?>">
                                    <?= sanitize($u['status']); ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-neutral-500 whitespace-nowrap">
                                <?= date('M d, Y', strtotime($u['created_at'])); ?>
                            </td>
                            <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                <?php if ($u['role'] !== 'admin'): ?>
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Toggle Status -->
                                        <form action="users.php" method="POST" class="inline">
                                            <?= getCsrfInput(); ?>
                                            <input type="hidden" name="action" value="toggle_status">
                                            <input type="hidden" name="target_user_id" value="<?= (int)$u['id']; ?>">
                                            <input type="hidden" name="new_status" value="<?= $u['status'] === 'active' ? 'disabled' : 'active'; ?>">
                                            <button 
                                                type="submit" 
                                                class="px-2.5 py-1 rounded-lg border text-[11px] font-medium transition-colors <?= $u['status'] === 'active' ? 'border-amber-500/30 text-amber-400 hover:bg-amber-500/10' : 'border-emerald-500/30 text-emerald-400 hover:bg-emerald-500/10'; ?>"
                                            >
                                                <?= $u['status'] === 'active' ? 'Disable' : 'Activate'; ?>
                                            </button>
                                        </form>

                                        <!-- Delete User -->
                                        <form action="users.php" method="POST" onsubmit="return confirm('Delete user @<?= sanitize($u['username']); ?> permanently?');" class="inline">
                                            <?= getCsrfInput(); ?>
                                            <input type="hidden" name="action" value="delete_user">
                                            <input type="hidden" name="target_user_id" value="<?= (int)$u['id']; ?>">
                                            <button 
                                                type="submit" 
                                                class="p-1 rounded-lg bg-neutral-800 hover:bg-red-500/20 hover:text-red-400 text-neutral-400 transition-colors"
                                                title="Delete Account"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <span class="text-[10px] text-neutral-500 italic">Primary Admin</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
