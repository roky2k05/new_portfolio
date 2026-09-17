<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: about.php
 * Comprehensive Biography, Academic Background, and Professional Philosophy
 */

$pageTitle = 'About Me';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-16">
        
        <!-- Hero Bio Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: Avatar / Portrait Card -->
            <div class="lg:col-span-5">
                <div class="relative p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-sm space-y-6">
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-gradient-to-tr from-rose-600 to-rose-400 text-white flex items-center justify-center font-heading font-extrabold text-5xl shadow-lg mx-auto">
                        RN
                    </div>

                    <div class="text-center space-y-1">
                        <h1 class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white">
                            Rasindu Nawod
                        </h1>
                        <p class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                            Web Developer | Graphic Designer
                        </p>
                        <p class="text-xs text-neutral-500 flex items-center justify-center gap-1 mt-1">
                            <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Matara &bull; Southern Province, Sri Lanka</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-800/80 text-center text-xs">
                        <div class="p-3 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50">
                            <span class="block text-xl font-extrabold font-heading text-neutral-900 dark:text-white">2+</span>
                            <span class="text-[11px] text-neutral-500">Years Experience</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50">
                            <span class="block text-xl font-extrabold font-heading text-neutral-900 dark:text-white">15+</span>
                            <span class="text-[11px] text-neutral-500">Projects Built</span>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <a 
                            href="download-cv.php" 
                            class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors shadow-xs"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Download Resume (CV)</span>
                        </a>

                        <a 
                            href="contact.php" 
                            class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 font-semibold text-xs transition-colors"
                        >
                            <span>Initiate Project Consultation</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Biography & Vision -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                        About Rasindu Nawod
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight mt-1">
                        Synthesizing Computational Code with Refined Visual Aesthetics
                    </h2>
                </div>

                <div class="space-y-4 text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                    <p>
                        I am a forward-thinking Web Developer and Graphic Designer based in Matara, Sri Lanka. My dual expertise allows me to bridge the gap between engineering rigor and creative artistry — delivering web products that are not only architecturally sound and secure, but visually striking and intuitive for end users.
                    </p>
                    <p>
                        With a solid academic foundation in Software Engineering from <strong>ICBT Campus</strong>, I specialize in full-stack web applications using <strong>PHP 8+, MySQL, HTML5, CSS3, Tailwind CSS, and modern JavaScript</strong>. Simultaneously, my graphic design proficiency with <strong>Adobe Photoshop, Illustrator, and Figma</strong> enables me to design full brand identities, marketing materials, and high-fidelity UI wireframes.
                    </p>
                    <p>
                        Whether building custom database-driven web platforms, corporate landing pages, or bespoke brand designs, my priority is clean architecture, mobile responsiveness, fast performance, and bulletproof user security.
                    </p>
                </div>

                <!-- Core Pillars -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 space-y-1">
                        <div class="text-xs font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Clean Architecture & Security</span>
                        </div>
                        <p class="text-xs text-neutral-500">
                            Strict adherence to PDO prepared statements, input sanitization, CSRF mitigation, and secure session state handling.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 space-y-1">
                        <div class="text-xs font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Visual Design Precision</span>
                        </div>
                        <p class="text-xs text-neutral-500">
                            Figma design thinking, proportional typography, balanced negative space, and modern dark/light system aesthetics.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Academic Background & Education Section -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-8">
            <div class="max-w-2xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">Education & Background</span>
                <h2 class="text-2xl font-extrabold font-heading text-neutral-900 dark:text-white mt-1">Academic Foundations & Technical Mastery</h2>
                <p class="text-xs sm:text-sm text-neutral-500 mt-1">Structured qualifications in software development and computing systems.</p>
            </div>

            <div class="space-y-6">
                <!-- ICBT Campus -->
                <div class="flex flex-col sm:flex-row sm:items-start gap-4 p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/40 border border-neutral-200/80 dark:border-neutral-800">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center font-heading font-bold text-lg shrink-0">
                        ICBT
                    </div>
                    <div class="space-y-1 flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <h3 class="text-sm sm:text-base font-bold text-neutral-900 dark:text-white">
                                Higher National Diploma in Software Engineering
                            </h3>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 self-start sm:self-auto">
                                Enrolled & Active
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-rose-600 dark:text-rose-400">ICBT Campus, Sri Lanka</p>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed pt-1">
                            Rigorous coursework encompassing Object-Oriented Programming (OOP), Relational Database Management Systems (RDBMS & MySQL), Data Structures & Algorithms, Web Engineering Principles, Software Testing, and Modern Cloud Architecture.
                        </p>
                    </div>
                </div>

                <!-- Secondary Education / Foundations -->
                <div class="flex flex-col sm:flex-row sm:items-start gap-4 p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/40 border border-neutral-200/80 dark:border-neutral-800">
                    <div class="w-12 h-12 rounded-2xl bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 flex items-center justify-center font-heading font-bold text-lg shrink-0">
                        GCE
                    </div>
                    <div class="space-y-1 flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <h3 class="text-sm sm:text-base font-bold text-neutral-900 dark:text-white">
                                Advanced Level (A/L) Studies & Computing Foundations
                            </h3>
                            <span class="text-xs font-mono text-neutral-500">Matara, Sri Lanka</span>
                        </div>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed pt-1">
                            Focused studies in mathematics and digital fundamentals, leading directly into professional computing and digital graphic design.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
