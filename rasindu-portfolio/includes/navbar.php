<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/navbar.php
 */
?>
<header class="sticky top-0 z-40 w-full backdrop-blur-md bg-white/85 dark:bg-[#0b0d13]/85 border-b border-neutral-200/80 dark:border-neutral-800/80 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        <!-- Logo / Brand -->
        <a href="#home" class="flex items-center gap-3 group">
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
        <nav class="hidden md:flex items-center gap-6 text-xs font-semibold tracking-wide text-neutral-600 dark:text-neutral-300">
            <a href="#about" class="hover:text-rose-600 dark:hover:text-white transition-colors">About</a>
            <a href="#education" class="hover:text-rose-600 dark:hover:text-white transition-colors">Education</a>
            <a href="#skills" class="hover:text-rose-600 dark:hover:text-white transition-colors">Skills</a>
            <a href="#services" class="hover:text-rose-600 dark:hover:text-white transition-colors">Services</a>
            <a href="#projects" class="hover:text-rose-600 dark:hover:text-white transition-colors">Projects</a>
            <a href="#gallery" class="hover:text-rose-600 dark:hover:text-white transition-colors">Design</a>
            <a href="#contact" class="hover:text-rose-600 dark:hover:text-white transition-colors">Contact</a>
        </nav>

        <!-- Right Action Items -->
        <div class="flex items-center gap-3">
            <!-- Theme Toggle -->
            <button 
                id="theme-toggle" 
                aria-label="Toggle Dark Mode" 
                class="p-2.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
            >
                <span class="dark:hidden">🌙</span>
                <span class="hidden dark:inline">☀️</span>
            </button>

            <!-- Admin Link -->
            <a 
                href="admin/index.php" 
                class="hidden sm:inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-semibold bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 text-neutral-700 dark:text-neutral-300 transition-colors"
            >
                Admin
            </a>

            <!-- Hire Me CTA -->
            <a 
                href="#contact" 
                class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition-all"
            >
                Hire Me
            </a>
        </div>

    </div>
</header>
