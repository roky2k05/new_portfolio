<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/navbar.php
 * Responsive Navigation with Dynamic Auth Status
 */

$isUserLoggedIn = !empty($_SESSION['user_id']);
$userRole = $_SESSION['role'] ?? null;
$userName = $_SESSION['full_name'] ?? ($_SESSION['username'] ?? 'Account');
$unreadCount = 0;

if ($isUserLoggedIn) {
    try {
        $navPdo = getDatabaseConnection();
        $unreadCount = getUnreadNotificationsCount($navPdo, (int)$_SESSION['user_id']);
    } catch (Exception $e) {
        $unreadCount = 0;
    }
}
?>
<header class="sticky top-0 z-50 w-full backdrop-blur-md bg-white/90 dark:bg-[#0b0d13]/90 border-b border-neutral-200/80 dark:border-neutral-800/80 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        <!-- Logo / Brand -->
        <a href="index.php" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-neutral-900 dark:bg-neutral-800 border border-neutral-700/60 flex items-center justify-center font-bold text-lg text-white shadow-xs group-hover:scale-105 transition-transform">
                <span>R</span>
                <span class="text-rose-500">N</span>
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight text-lg leading-none">
                    Rasindu Nawod
                </span>
                <span class="text-[11px] font-medium text-rose-600 dark:text-rose-400 tracking-wide mt-1">
                    Web Developer | Graphic Designer
                </span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden xl:flex items-center gap-4 text-xs font-semibold tracking-wide text-neutral-600 dark:text-neutral-300">
            <a href="index.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Home</a>
            <a href="about.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">About</a>
            <a href="education.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Education</a>
            <a href="skills.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Skills</a>
            <a href="services.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Services</a>
            <a href="how-i-work.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">How I Work</a>
            <a href="projects.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Projects</a>
            <a href="graphic-design.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Graphic Design</a>
            <a href="faq.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">FAQ</a>
            <a href="blog.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Blog</a>
            <a href="contact.php" class="hover:text-rose-600 dark:hover:text-white transition-colors">Contact</a>
        </nav>

        <!-- Right Action Items -->
        <div class="flex items-center gap-3">
            <!-- Dark / Light Theme Toggle -->
            <button 
                id="theme-toggle" 
                type="button"
                aria-label="Toggle Dark Mode" 
                class="p-2.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
            >
                <span class="dark:hidden">🌙</span>
                <span class="hidden dark:inline">☀️</span>
            </button>

            <?php if ($isUserLoggedIn): ?>
                <!-- User is Logged In: Show Dashboard & Logout -->
                <?php if ($userRole === 'admin'): ?>
                    <a 
                        href="admin/dashboard.php" 
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-rose-500/10 text-rose-500 hover:bg-rose-500/20 border border-rose-500/20 transition-all"
                    >
                        <span>Admin Console</span>
                    </a>
                <?php endif; ?>

                <a 
                    href="dashboard.php" 
                    class="relative inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 hover:opacity-90 shadow-xs transition-all"
                >
                    <span>Dashboard</span>
                    <?php if ($unreadCount > 0): ?>
                        <span class="w-5 h-5 rounded-full bg-rose-600 text-white text-[10px] flex items-center justify-center font-bold">
                            <?= $unreadCount; ?>
                        </span>
                    <?php endif; ?>
                </a>

                <a 
                    href="logout.php" 
                    class="hidden sm:inline-flex items-center px-3 py-2 rounded-xl text-xs font-semibold text-neutral-600 dark:text-neutral-300 hover:text-rose-600 dark:hover:text-rose-400 border border-neutral-200 dark:border-neutral-800 transition-colors"
                >
                    Logout
                </a>
            <?php else: ?>
                <!-- Guest Visitor: Show Login & Register -->
                <a 
                    href="login.php" 
                    class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold text-neutral-700 dark:text-neutral-200 hover:text-rose-600 dark:hover:text-rose-400 border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                >
                    Login
                </a>
                <a 
                    href="register.php" 
                    class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition-colors"
                >
                    Register
                </a>
            <?php endif; ?>

            <!-- Mobile Hamburger Toggle -->
            <button 
                id="mobile-nav-toggle"
                type="button" 
                class="xl:hidden p-2.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-700 dark:text-neutral-300"
                aria-label="Open Navigation Menu"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-nav-menu" class="hidden xl:hidden border-t border-neutral-200 dark:border-neutral-800 bg-white dark:bg-[#0b0d13] px-6 py-5 transition-all">
        <nav class="flex flex-col space-y-3 text-sm font-semibold text-neutral-700 dark:text-neutral-300">
            <a href="index.php" class="hover:text-rose-600 transition-colors py-1">Home</a>
            <a href="about.php" class="hover:text-rose-600 transition-colors py-1">About</a>
            <a href="education.php" class="hover:text-rose-600 transition-colors py-1">Education</a>
            <a href="skills.php" class="hover:text-rose-600 transition-colors py-1">Skills</a>
            <a href="services.php" class="hover:text-rose-600 transition-colors py-1">Services</a>
            <a href="how-i-work.php" class="hover:text-rose-600 transition-colors py-1">How I Work</a>
            <a href="projects.php" class="hover:text-rose-600 transition-colors py-1">Projects</a>
            <a href="graphic-design.php" class="hover:text-rose-600 transition-colors py-1">Graphic Design</a>
            <a href="faq.php" class="hover:text-rose-600 transition-colors py-1">FAQ</a>
            <a href="blog.php" class="hover:text-rose-600 transition-colors py-1">Blog</a>
            <a href="contact.php" class="hover:text-rose-600 transition-colors py-1">Contact</a>
            
            <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800 flex flex-col gap-2">
                <?php if ($isUserLoggedIn): ?>
                    <a href="dashboard.php" class="py-2 text-center rounded-xl bg-neutral-900 text-white dark:bg-white dark:text-neutral-900">
                        My Dashboard <?= $unreadCount > 0 ? "({$unreadCount})" : ""; ?>
                    </a>
                    <?php if ($userRole === 'admin'): ?>
                        <a href="admin/dashboard.php" class="py-2 text-center rounded-xl bg-rose-600 text-white">
                            Admin Console
                        </a>
                    <?php endif; ?>
                    <a href="logout.php" class="py-2 text-center rounded-xl border border-neutral-200 dark:border-neutral-800">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="py-2 text-center rounded-xl border border-neutral-200 dark:border-neutral-800">
                        Login
                    </a>
                    <a href="register.php" class="py-2 text-center rounded-xl bg-rose-600 text-white">
                        Register Account
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
