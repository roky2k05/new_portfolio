<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: skills.php
 * Comprehensive Technical & Graphic Design Skill Matrix
 */

$pageTitle = 'Skills & Competencies';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                Skills & Technical Stack
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Comprehensive Competencies
            </h1>
            <p class="text-xs sm:text-sm text-neutral-500">
                A dual skillset blending algorithmic web programming with professional graphic design suites.
            </p>
            <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto mt-3"></div>
        </div>

        <!-- 4 Skill Quadrants -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Category 1: Frontend Development -->
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-neutral-100 dark:border-neutral-800 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-heading text-neutral-900 dark:text-white">Frontend Web Engineering</h2>
                        <p class="text-xs text-neutral-500">Modern semantic markup, responsive frameworks, and interactivity</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>HTML5 & Semantic Architecture</span>
                            <span class="text-rose-600 dark:text-rose-400">95%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-rose-600 rounded-full w-[95%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>CSS3, Responsive Design & Flex/Grid</span>
                            <span class="text-rose-600 dark:text-rose-400">92%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-rose-600 rounded-full w-[92%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Tailwind CSS Framework</span>
                            <span class="text-rose-600 dark:text-rose-400">90%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-rose-600 rounded-full w-[90%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>JavaScript (ES6+, DOM, Fetch API, AJAX)</span>
                            <span class="text-rose-600 dark:text-rose-400">85%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-rose-600 rounded-full w-[85%]"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex flex-wrap gap-2">
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Mobile-First</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">W3C Compliance</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">CSS Custom Properties</span>
                </div>
            </div>

            <!-- Category 2: Backend & Database -->
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-neutral-100 dark:border-neutral-800 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-heading text-neutral-900 dark:text-white">Backend & Database</h2>
                        <p class="text-xs text-neutral-500">Robust server logic, secure databases, and RBAC authentication</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>PHP 8+ (OOP, MVC concepts, Sessions)</span>
                            <span class="text-blue-500">90%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full w-[90%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>MySQL & Relational Schema Design</span>
                            <span class="text-blue-500">88%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full w-[88%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>PDO Prepared Statements & SQLi Defense</span>
                            <span class="text-blue-500">92%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full w-[92%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>CSRF & Session Security (RBAC)</span>
                            <span class="text-blue-500">90%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full w-[90%]"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex flex-wrap gap-2">
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Password Hashing</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">RESTful Endpoints</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Audit Logging</span>
                </div>
            </div>

            <!-- Category 3: Graphic Design & UI/UX -->
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-neutral-100 dark:border-neutral-800 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-heading text-neutral-900 dark:text-white">Graphic Design & UI/UX</h2>
                        <p class="text-xs text-neutral-500">Visual brand identity, vector illustration, and UI layouts</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Adobe Photoshop (Photo Manipulation, Mockups)</span>
                            <span class="text-purple-500">92%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full w-[92%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Adobe Illustrator (Logos, Vector Art)</span>
                            <span class="text-purple-500">88%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full w-[88%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Figma (UI/UX Prototyping, Wireframing)</span>
                            <span class="text-purple-500">88%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full w-[88%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Brand Identity, Social Media Ads & Print</span>
                            <span class="text-purple-500">90%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full w-[90%]"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex flex-wrap gap-2">
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Typography Pairing</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Color Theory</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Export Optimization</span>
                </div>
            </div>

            <!-- Category 4: Tools & Dev Workflow -->
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-neutral-100 dark:border-neutral-800 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-heading text-neutral-900 dark:text-white">Workflow & Environment</h2>
                        <p class="text-xs text-neutral-500">Version control, CLI tools, debugging, and deployment</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Git & GitHub Version Control</span>
                            <span class="text-emerald-500">88%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full w-[88%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>VS Code & Development Extensions</span>
                            <span class="text-emerald-500">95%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full w-[95%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>XAMPP / Apache Local Environment</span>
                            <span class="text-emerald-500">90%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full w-[90%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1 text-neutral-800 dark:text-neutral-200">
                            <span>Postman API Testing & Debugging</span>
                            <span class="text-emerald-500">85%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full w-[85%]"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex flex-wrap gap-2">
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Cross-Browser Testing</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Clean Code Semantics</span>
                    <span class="px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-[11px] font-medium text-neutral-700 dark:text-neutral-300">Performance Profiling</span>
                </div>
            </div>

        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
