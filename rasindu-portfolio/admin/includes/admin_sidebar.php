<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/includes/admin_sidebar.php
 * Administrative Left Navigation Bar
 */

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-full md:w-64 bg-[#121620] border-r border-neutral-800 p-4 shrink-0 flex flex-col justify-between">
    <div class="space-y-1">
        <span class="block px-3 pb-2 text-[10px] font-bold text-neutral-500 uppercase tracking-wider">
            Management Hub
        </span>

        <a 
            href="dashboard.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= $currentPage === 'dashboard.php' ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Overview Dashboard</span>
        </a>

        <a 
            href="messages.php" 
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= ($currentPage === 'messages.php' || $currentPage === 'message-view.php') ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <span class="flex items-center gap-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span>Project Inquiries</span>
            </span>
        </a>

        <a 
            href="users.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= $currentPage === 'users.php' ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Registered Users</span>
        </a>

        <a 
            href="projects.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= $currentPage === 'projects.php' ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>Portfolio Projects</span>
        </a>

        <a 
            href="blog.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= $currentPage === 'blog.php' ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <span>Articles & Blog</span>
        </a>

        <a 
            href="testimonials.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= $currentPage === 'testimonials.php' ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <span>Testimonials</span>
        </a>

        <span class="block px-3 pt-4 pb-2 text-[10px] font-bold text-neutral-500 uppercase tracking-wider">
            System & Security
        </span>

        <a 
            href="settings.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-colors <?= $currentPage === 'settings.php' ? 'bg-rose-600 text-white' : 'text-neutral-400 hover:text-white hover:bg-neutral-800/60'; ?>"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <span>Change Password</span>
        </a>
    </div>

    <div class="pt-6 border-t border-neutral-800">
        <a 
            href="logout.php" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span>Sign Out</span>
        </a>
    </div>
</aside>
