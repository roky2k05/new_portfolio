<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: how-i-work.php
 * Engineering & Creative Design Workflow / Methodology
 */

$pageTitle = 'How I Work';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/60 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-16">
        
        <!-- Header Banner -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold uppercase tracking-wider border border-rose-200/60 dark:border-rose-900/40 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>The Workflow & Engineering Discipline</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                How I Work: From Concept to Production
            </h1>
            <p class="text-sm sm:text-base text-neutral-600 dark:text-neutral-300 leading-relaxed">
                A disciplined 5-stage methodology combining architectural security, Figma UI wireframing, clean PHP/MySQL code, and continuous communication.
            </p>
        </div>

        <!-- 5-Step Process Grid -->
        <div class="space-y-6">
            
            <!-- Step 1 -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm flex flex-col md:flex-row items-start gap-6 hover:border-rose-500/50 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-rose-500/10 text-rose-600 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                    01
                </div>
                <div class="space-y-2 flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg sm:text-xl font-bold font-heading text-neutral-900 dark:text-white">
                            Discovery, Requirements & System Architecture
                        </h2>
                        <span class="text-[11px] font-mono text-neutral-400">Phase 1</span>
                    </div>
                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                        Every project begins by defining user personas, data models, functional scopes, and database schemas. We clarify milestones, authentication models, user roles, and security policies before writing a single line of code.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Requirement Specs</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Database Schema Design</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Security Scoping</span>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm flex flex-col md:flex-row items-start gap-6 hover:border-rose-500/50 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-purple-500/10 text-purple-600 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                    02
                </div>
                <div class="space-y-2 flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg sm:text-xl font-bold font-heading text-neutral-900 dark:text-white">
                            UI/UX Wireframing & Figma Prototyping
                        </h2>
                        <span class="text-[11px] font-mono text-neutral-400">Phase 2</span>
                    </div>
                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                        Using Figma, Adobe Illustrator, and Photoshop, I create high-fidelity responsive wireframes and interactive prototypes. Typography, spacing ratios, dark/light contrast rules, and design components are established and refined.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Figma Interactive Mockup</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Design System & Colors</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Mobile First Layout</span>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm flex flex-col md:flex-row items-start gap-6 hover:border-rose-500/50 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-sky-500/10 text-sky-600 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                    03
                </div>
                <div class="space-y-2 flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg sm:text-xl font-bold font-heading text-neutral-900 dark:text-white">
                            Full-Stack Development (PHP 8+, MySQL, Tailwind)
                        </h2>
                        <span class="text-[11px] font-mono text-neutral-400">Phase 3</span>
                    </div>
                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                        Code is engineered with modular architecture, strict PDO prepared statements, semantic HTML5, clean CSS/Tailwind utilities, and progressive vanilla JavaScript for fluid animations and AJAX responsiveness.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">PHP 8+ OOP & PDO</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Tailwind CSS</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Modular Includes</span>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm flex flex-col md:flex-row items-start gap-6 hover:border-rose-500/50 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                    04
                </div>
                <div class="space-y-2 flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg sm:text-xl font-bold font-heading text-neutral-900 dark:text-white">
                            Security Hardening, Quality Assurance & IDOR Testing
                        </h2>
                        <span class="text-[11px] font-mono text-neutral-400">Phase 4</span>
                    </div>
                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                        Rigorous security audits are conducted: checking against SQL injection, cross-site scripting (XSS), cross-site request forgery (CSRF), and Insecure Direct Object References (IDOR). Cross-browser and mobile responsive testing guarantees seamless experiences.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">CSRF Tokens</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">IDOR Verification</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">XSS Sanitization</span>
                    </div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm flex flex-col md:flex-row items-start gap-6 hover:border-rose-500/50 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                    05
                </div>
                <div class="space-y-2 flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg sm:text-xl font-bold font-heading text-neutral-900 dark:text-white">
                            Deployment, Handover & Ongoing Support
                        </h2>
                        <span class="text-[11px] font-mono text-neutral-400">Phase 5</span>
                    </div>
                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                        Database migration scripts, Apache/Nginx environment configuration, and SSL provisioning are executed. Clients receive clean administrator documentation, training, and 24/7 direct communication support via the client portal.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Server Deployment</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Admin Documentation</span>
                        <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-semibold text-neutral-700 dark:text-neutral-300">Ongoing Maintenance</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Workflow CTA Banner -->
        <div class="p-8 sm:p-10 rounded-3xl bg-neutral-900 text-white border border-neutral-800 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <h3 class="text-2xl font-bold font-heading text-white">Have a project in mind?</h3>
                <p class="text-xs sm:text-sm text-neutral-400">Let's discuss requirements and start the discovery phase today.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="contact.php" class="px-6 py-3.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs sm:text-sm transition-colors shadow-md">
                    Start a Project
                </a>
                <a href="projects.php" class="px-5 py-3.5 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-neutral-200 font-semibold text-xs sm:text-sm transition-colors border border-neutral-700">
                    View Portfolio
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
