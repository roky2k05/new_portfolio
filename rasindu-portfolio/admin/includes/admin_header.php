<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/includes/admin_header.php
 * Administrative Control Center Layout Header
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/admin_auth.php';

// Strict Role Guard
$currentAdmin = requireAdmin();
$adminName = $currentAdmin['full_name'] ?? 'Rasindu Nawod';
$adminUsername = $currentAdmin['username'] ?? 'rasindu';
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? sanitize($pageTitle) . ' | Admin Console' : 'Rasindu Nawod | Admin Console'; ?></title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#0b0d13] text-neutral-100 min-h-screen flex flex-col antialiased selection:bg-rose-500 selection:text-white">

    <!-- Top Admin Bar -->
    <header class="sticky top-0 z-40 bg-[#121620]/90 backdrop-blur-md border-b border-neutral-800">
        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <div class="flex items-center gap-4">
                <a href="dashboard.php" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-rose-600 to-rose-400 text-white font-heading font-extrabold flex items-center justify-center text-sm shadow-sm">
                        RN
                    </div>
                    <div class="hidden sm:block">
                        <span class="block text-sm font-bold font-heading text-white tracking-tight">Admin Console</span>
                        <span class="block text-[10px] text-neutral-400 -mt-0.5">Rasindu Nawod Portfolio</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <a 
                    href="../index.php" 
                    target="_blank" 
                    class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-800 text-xs font-semibold text-neutral-400 hover:text-white hover:border-neutral-700 transition-colors"
                >
                    <span>View Live Site</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <div class="flex items-center gap-3 pl-3 border-l border-neutral-800">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-white"><?= sanitize($adminName); ?></span>
                        <span class="block text-[10px] text-rose-400 font-mono">@<?= sanitize($adminUsername); ?> (Admin)</span>
                    </div>
                    <a 
                        href="logout.php" 
                        title="Sign Out"
                        class="p-2 rounded-xl bg-neutral-800/80 hover:bg-rose-500/20 hover:text-rose-400 text-neutral-400 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </header>

    <!-- Main Container -->
    <div class="flex-1 flex flex-col md:flex-row">
