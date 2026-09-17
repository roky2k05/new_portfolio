<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: education.php
 * Dedicated Academic Background, Higher Studies & Design Certifications
 */

$pageTitle = 'Education & Qualifications';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/60 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-16">
        
        <!-- Header Banner -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold uppercase tracking-wider border border-rose-200/60 dark:border-rose-900/40 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>Academic Roadmap & Qualifications</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Education & Technical Foundations
            </h1>
            <p class="text-sm sm:text-base text-neutral-600 dark:text-neutral-300 leading-relaxed">
                Structured software engineering discipline paired with formal visual design training. A documented progression from high school foundations in Matara to modern computing and creative design.
            </p>
        </div>

        <!-- Academic Timeline Cards -->
        <div class="space-y-8">
            
            <!-- 1. ICBT Campus -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm relative overflow-hidden transition-all hover:border-rose-500/50">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                    <div class="flex items-start gap-4 sm:gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                            ICBT
                        </div>
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 text-[11px] font-bold border border-emerald-200/50 dark:border-emerald-900/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Currently Studying &bull; Active Enrolment</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold font-heading text-neutral-900 dark:text-white">
                                Diploma in Computer and Software Engineering
                            </h2>
                            <p class="text-xs sm:text-sm font-semibold text-rose-600 dark:text-rose-400">
                                ICBT Campus &bull; Sri Lanka
                            </p>
                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 max-w-3xl leading-relaxed pt-1">
                                Undertaking comprehensive software engineering curriculum focusing on Object-Oriented Software Design (OOP in Java & PHP), Relational Database Management Systems (MySQL), Web Engineering, Secure Architecture, Systems Analysis, and Algorithms.
                            </p>
                        </div>
                    </div>

                    <div class="text-left lg:text-right shrink-0">
                        <span class="text-xs font-mono font-bold text-neutral-500 dark:text-neutral-400 block">Status: In Progress</span>
                        <span class="text-xs text-neutral-400">Higher Diploma Level</span>
                    </div>
                </div>

                <!-- Coursework & Modules Grid -->
                <div class="mt-8 pt-6 border-t border-neutral-100 dark:border-neutral-800/80">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-4">
                        Key Study Modules & Competencies
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Java & OOP Principles</span>
                            <span class="text-[11px] text-neutral-500">Design Patterns & Polymorphism</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Relational Databases</span>
                            <span class="text-[11px] text-neutral-500">MySQL, Normalization, Queries</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Full-Stack Web Dev</span>
                            <span class="text-[11px] text-neutral-500">PHP 8, MVC, REST APIs</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Software Security</span>
                            <span class="text-[11px] text-neutral-500">Input Sanitization & CSRF/IDOR</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. IMS Campus -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm relative overflow-hidden transition-all hover:border-purple-500/50">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                    <div class="flex items-start gap-4 sm:gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                            IMS
                        </div>
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 text-[11px] font-bold border border-purple-200/50 dark:border-purple-900/40">
                                <span>Certificate &bull; Completed</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold font-heading text-neutral-900 dark:text-white">
                                Graphic Design Professional Course
                            </h2>
                            <p class="text-xs sm:text-sm font-semibold text-purple-600 dark:text-purple-400">
                                IMS Campus &bull; Sri Lanka
                            </p>
                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 max-w-3xl leading-relaxed pt-1">
                                Professional coursework in visual communication, brand design philosophy, vector illustration, and digital marketing layout. Hands-on mastery of industry-standard tools including Adobe Illustrator, Adobe Photoshop, color theory, and typographical hierarchies.
                            </p>
                        </div>
                    </div>

                    <div class="text-left lg:text-right shrink-0">
                        <span class="text-xs font-mono font-bold text-neutral-500 dark:text-neutral-400 block">Design Specialization</span>
                        <span class="text-xs text-neutral-400">Branding & Digital Imagery</span>
                    </div>
                </div>

                <!-- Design Competencies -->
                <div class="mt-8 pt-6 border-t border-neutral-100 dark:border-neutral-800/80">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-4">
                        Mastered Design Techniques & Tools
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Adobe Illustrator</span>
                            <span class="text-[11px] text-neutral-500">Vector Logos & Icons</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Adobe Photoshop</span>
                            <span class="text-[11px] text-neutral-500">Digital Retouching & Mockups</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Brand Identity</span>
                            <span class="text-[11px] text-neutral-500">Visual Guidelines & Palettes</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block">Typography & Layout</span>
                            <span class="text-[11px] text-neutral-500">Print Collateral & Social Kits</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Rahula College -->
            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200/90 dark:border-neutral-800 shadow-sm relative overflow-hidden transition-all hover:border-neutral-400">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                    <div class="flex items-start gap-4 sm:gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 flex items-center justify-center font-heading font-extrabold text-xl shrink-0">
                            RC
                        </div>
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 text-[11px] font-bold border border-neutral-200 dark:border-neutral-700">
                                <span>Completed 2024</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold font-heading text-neutral-900 dark:text-white">
                                Secondary & Collegiate Education
                            </h2>
                            <p class="text-xs sm:text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                                Rahula College &bull; Matara, Sri Lanka
                            </p>
                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 max-w-3xl leading-relaxed pt-1">
                                Completed secondary and collegiate studies with distinguished focus on computing foundations, analytical mathematics, and logical reasoning. Laid the academic bedrock for higher studies in software engineering.
                            </p>
                        </div>
                    </div>

                    <div class="text-left lg:text-right shrink-0">
                        <span class="text-xs font-mono font-bold text-neutral-500 dark:text-neutral-400 block">Class of 2024</span>
                        <span class="text-xs text-neutral-400">Matara, Sri Lanka</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Academic & Technical Philosophy Callout -->
        <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-tr from-rose-600 to-rose-700 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-2 max-w-xl">
                <span class="text-xs uppercase tracking-wider font-semibold text-rose-200">Continuous Mastery</span>
                <h3 class="text-2xl font-extrabold font-heading text-white">
                    Looking for a developer with both coding and design qualifications?
                </h3>
                <p class="text-xs sm:text-sm text-rose-100 leading-relaxed">
                    Download my full curriculum vitae (CV) detailing academic records, technical coursework, project repositories, and design portfolios.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="download-cv.php" class="px-6 py-3.5 rounded-xl bg-white text-rose-700 hover:bg-neutral-100 font-bold text-xs sm:text-sm transition-colors shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Download CV</span>
                </a>
                <a href="contact.php" class="px-5 py-3.5 rounded-xl bg-rose-800/60 hover:bg-rose-800 text-white border border-rose-500 font-bold text-xs sm:text-sm transition-colors">
                    Contact Rasindu
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
