<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: profile.php
 * Authenticated User Profile View (Strict Self-Profile Scope)
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

// Normal user can only see their own profile
$currentUser = requireUser();

// Block attempts to view other users' profiles via URL query
if (isset($_GET['user_id']) && (int)$_GET['user_id'] !== (int)$currentUser['id']) {
    header("Location: profile.php?error=Access+denied:+You+can+only+view+your+own+private+profile.");
    exit;
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-screen bg-neutral-50/50 dark:bg-[#0b0d13] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-6 border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <a href="dashboard.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 transition-colors flex items-center gap-1 mb-1">
                    ← Back to Dashboard
                </a>
                <h1 class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white">
                    My Profile
                </h1>
                <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-0.5">
                    Your personal contact and account details on Rasindu Nawod's client portal.
                </p>
            </div>

            <a 
                href="account-settings.php" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Profile</span>
            </a>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-medium">
                <?= sanitize($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Profile Details Card -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 pb-6 border-b border-neutral-100 dark:border-neutral-800">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-rose-500 to-rose-700 text-white flex items-center justify-center font-heading font-extrabold text-3xl shadow-sm">
                    <?= strtoupper(substr($currentUser['full_name'], 0, 1)); ?>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold font-heading text-neutral-900 dark:text-white">
                            <?= sanitize($currentUser['full_name']); ?>
                        </h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-500 border border-rose-500/20">
                            <?= sanitize($currentUser['role']); ?>
                        </span>
                    </div>
                    <p class="text-xs text-neutral-500">@<?= sanitize($currentUser['username']); ?></p>
                    <p class="text-xs text-neutral-400">Account status: <span class="text-emerald-500 font-semibold"><?= ucfirst($currentUser['status']); ?></span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs sm:text-sm">
                <div>
                    <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Email Address</span>
                    <span class="font-medium text-neutral-800 dark:text-neutral-200"><?= sanitize($currentUser['email']); ?></span>
                </div>

                <div>
                    <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Phone Number (Private)</span>
                    <span class="font-medium text-neutral-800 dark:text-neutral-200"><?= sanitize($currentUser['phone']); ?></span>
                </div>

                <div>
                    <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Country / Region</span>
                    <span class="font-medium text-neutral-800 dark:text-neutral-200">Sri Lanka</span>
                </div>

                <div>
                    <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Registration Date</span>
                    <span class="font-medium text-neutral-800 dark:text-neutral-200"><?= formatDateTime($currentUser['created_at']); ?></span>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900/40 border border-neutral-200/60 dark:border-neutral-800/60 text-xs text-neutral-500 space-y-1">
                <div class="font-semibold text-neutral-700 dark:text-neutral-300">Privacy & Data Security Notice</div>
                <p>
                    Your contact information is strictly protected. Only you and the certified portfolio administrator (Rasindu Nawod) have authorization to view your contact phone number and submitted inquiry documents.
                </p>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
