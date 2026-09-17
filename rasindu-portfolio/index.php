<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: index.php
 * Main Entry Point for PHP / MySQL Deployment
 */
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/includes/csrf.php';

$pdo = getDatabaseConnection();
$projects = getProjects('All', 3);
$socialLinks = getSocialLinks($pdo);

// Fetch recent published blog posts
$recentArticles = [];
try {
    $bStmt = $pdo->query("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY id DESC LIMIT 3");
    $recentArticles = $bStmt->fetchAll();
} catch (Exception $e) {
    error_log("Failed to fetch blog posts for homepage: " . $e->getMessage());
}

// Fetch testimonials
$testimonials = [];
try {
    $tStmt = $pdo->query("SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY id DESC LIMIT 3");
    $testimonials = $tStmt->fetchAll();
} catch (Exception $e) {
    error_log("Failed to fetch testimonials for homepage: " . $e->getMessage());
}

if (empty($testimonials)) {
    $testimonials = [
        [
            'client_name' => 'Dilshan Fernando',
            'client_title' => 'Managing Director',
            'company' => 'Ceylon Exports & Logistics',
            'quote' => 'Rasindu delivered a clean, responsive database web platform that completely streamlined our product catalog and client inquiries. His eye for graphic design combined with solid PHP coding is exceptional.',
            'rating' => 5,
            'project_name' => 'Corporate Web Platform & Brand Assets',
        ],
        [
            'client_name' => 'Kavindu Senanayake',
            'client_title' => 'Tech Lead',
            'company' => 'Southern Digital Studios',
            'quote' => 'Collaborating with Rasindu was effortless. Clean code, strict adherence to security best practices, and fast communication. Highly recommended for full-stack and design work.',
            'rating' => 5,
            'project_name' => 'LMS Application & UI Prototyping',
        ],
    ];
}
?>

<main id="home">
    
    <!-- Hero Section -->
    <section class="py-20 lg:py-28 relative overflow-hidden border-b border-neutral-200/80 dark:border-neutral-800/80">
        <!-- Subtle background ambient grid -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Typography & Intro -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold uppercase tracking-wider border border-rose-200/60 dark:border-rose-900/40 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        <span class="w-2 h-2 rounded-full bg-rose-500 -ml-3"></span>
                        <span>Available for Projects & Collaboration</span>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                            <span>Rasindu Nawod</span>
                            <span>&bull;</span>
                            <span class="text-rose-600 dark:text-rose-400">Web Developer | Graphic Designer</span>
                        </div>
                        <h1 class="text-4xl sm:text-6xl lg:text-6xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight leading-[1.1]">
                            Turning Ideas Into <span class="text-rose-600 dark:text-rose-500">Digital Experiences.</span>
                        </h1>
                    </div>

                    <p class="text-base sm:text-lg text-neutral-600 dark:text-neutral-300 max-w-xl leading-relaxed">
                        I build robust, secure full-stack web applications and craft distinctive graphic brand identities. Based in <strong class="text-neutral-900 dark:text-white">Sri Lanka | Matara | Akuressa</strong>, combining modern engineering discipline with visual design precision.
                    </p>

                    <!-- CTAs strictly matching requested buttons: View My Work, Download CV, Let's Talk -->
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="projects.php" class="px-6 py-3.5 rounded-xl font-semibold text-xs sm:text-sm text-white bg-rose-600 hover:bg-rose-700 shadow-md hover:shadow-rose-600/20 transition-all flex items-center gap-2">
                            <span>View My Work</span>
                            <span>→</span>
                        </a>
                        <a href="download-cv.php" class="px-6 py-3.5 rounded-xl font-semibold text-xs sm:text-sm text-neutral-800 dark:text-neutral-200 bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 dark:hover:bg-neutral-700 border border-neutral-300 dark:border-neutral-700 transition-all flex items-center gap-2 shadow-xs">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Download CV</span>
                        </a>
                        <a href="contact.php" class="px-5 py-3.5 rounded-xl font-semibold text-xs sm:text-sm text-neutral-700 dark:text-neutral-300 hover:text-rose-600 dark:hover:text-rose-400 border border-transparent hover:border-neutral-200 dark:hover:border-neutral-800 transition-all">
                            Let's Talk
                        </a>
                    </div>

                    <!-- Social Channels Row -->
                    <div class="flex items-center gap-3 pt-4 text-neutral-500 text-xs">
                        <span class="text-[11px] font-semibold text-neutral-400">Connect:</span>
                        <?php foreach ($socialLinks as $sl): ?>
                            <a href="<?= sanitize($sl['url']); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors font-medium">
                                <?= sanitize($sl['platform']); ?>
                            </a>
                            <span class="text-neutral-300 dark:text-neutral-700">&bull;</span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Professional Profile Image Placeholder & Floating UI Elements -->
                <div class="lg:col-span-5 relative">
                    
                    <!-- Floating UI Card 1: Full-Stack Code Element -->
                    <div class="absolute -top-6 -left-6 z-20 hidden sm:flex items-center gap-3 p-3.5 rounded-2xl bg-white/95 dark:bg-[#151924]/95 border border-neutral-200 dark:border-neutral-700 shadow-xl backdrop-blur-md animate-bounce" style="animation-duration: 4s;">
                        <div class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center font-mono font-bold text-xs">
                            &lt;/&gt;
                        </div>
                        <div class="text-left">
                            <span class="block text-[11px] font-mono text-neutral-400">PHP 8+ &bull; MySQL PDO</span>
                            <span class="text-xs font-bold text-neutral-900 dark:text-white">Full-Stack Dev</span>
                        </div>
                    </div>

                    <!-- Floating UI Card 2: Graphic Design Suite Element -->
                    <div class="absolute -bottom-6 -right-4 z-20 hidden sm:flex items-center gap-3 p-3.5 rounded-2xl bg-white/95 dark:bg-[#151924]/95 border border-neutral-200 dark:border-neutral-700 shadow-xl backdrop-blur-md animate-bounce" style="animation-duration: 5s;">
                        <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center font-bold text-xs">
                            Ai/Ps
                        </div>
                        <div class="text-left">
                            <span class="block text-[11px] font-mono text-neutral-400">Photoshop &bull; Illustrator</span>
                            <span class="text-xs font-bold text-neutral-900 dark:text-white">Brand & Visuals</span>
                        </div>
                    </div>

                    <!-- Center Portrait Card with Profile Placeholder & Visual Terminal -->
                    <div class="p-7 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-2xl relative overflow-hidden space-y-6">
                        
                        <!-- Profile Image Placeholder with Glow Ring -->
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-tr from-rose-600 via-rose-500 to-amber-500 p-0.5 shadow-lg">
                                    <div class="w-full h-full rounded-[14px] bg-neutral-900 flex items-center justify-center text-white font-heading font-extrabold text-2xl sm:text-3xl">
                                        RN
                                    </div>
                                </div>
                                <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white dark:border-[#121620]" title="Online & Available"></span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-lg font-bold font-heading text-neutral-900 dark:text-white">Rasindu Nawod</h3>
                                <p class="text-xs text-rose-600 dark:text-rose-400 font-semibold">Web Developer | Graphic Designer</p>
                                <p class="text-[11px] text-neutral-500 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span>Sri Lanka &bull; Matara &bull; Akuressa</span>
                                </p>
                            </div>
                        </div>

                        <!-- Mini Code Console Inside Profile Card -->
                        <div class="p-4 rounded-2xl bg-neutral-950 text-neutral-300 font-mono text-[11px] leading-relaxed border border-neutral-800 space-y-1.5 shadow-inner">
                            <div class="flex items-center justify-between pb-2 border-b border-neutral-800 text-[10px] text-neutral-500">
                                <span>developer_spec.json</span>
                                <span class="text-emerald-400 font-semibold">● ACTIVE</span>
                            </div>
                            <p><span class="text-rose-400">"status"</span>: <span class="text-amber-300">"Available for Hire"</span>,</p>
                            <p><span class="text-rose-400">"education"</span>: <span class="text-sky-300">"ICBT Campus &bull; Software Eng"</span>,</p>
                            <p><span class="text-rose-400">"design_diploma"</span>: <span class="text-sky-300">"IMS Campus &bull; Graphic Design"</span>,</p>
                            <p><span class="text-rose-400">"al_almamater"</span>: <span class="text-sky-300">"Rahula College (2024)"</span>,</p>
                            <p><span class="text-rose-400">"skills"</span>: [<span class="text-emerald-300">"HTML"</span>, <span class="text-emerald-300">"CSS"</span>, <span class="text-emerald-300">"JavaScript"</span>, <span class="text-emerald-300">"PHP"</span>, <span class="text-emerald-300">"Java"</span>, <span class="text-emerald-300">"Tailwind"</span>, <span class="text-emerald-300">"Photoshop"</span>, <span class="text-emerald-300">"Illustrator"</span>]</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Key Stats & About Snapshot -->
    <section class="py-16 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 space-y-1">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-heading text-rose-600">2+</span>
                    <span class="text-xs font-semibold text-neutral-500">Years Experience</span>
                </div>
                <div class="p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 space-y-1">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white">15+</span>
                    <span class="text-xs font-semibold text-neutral-500">Projects Completed</span>
                </div>
                <div class="p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 space-y-1">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white">100%</span>
                    <span class="text-xs font-semibold text-neutral-500">Satisfaction Rate</span>
                </div>
                <div class="p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800 space-y-1">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white">24/7</span>
                    <span class="text-xs font-semibold text-neutral-500">Direct Support</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview Section -->
    <section id="services" class="py-20 bg-neutral-50 dark:bg-[#0b0d13] border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Specializations</span>
                <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white">What I Bring to Your Projects</h2>
                <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="p-7 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 space-y-4 hover:border-rose-500/50 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-600 flex items-center justify-center font-bold text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold font-heading text-neutral-900 dark:text-white">Full-Stack Web Development</h3>
                    <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Custom database applications utilizing PHP 8+, MySQL PDO security, and mobile-first Tailwind CSS. Clean, maintainable architectures.
                    </p>
                    <a href="services.php#fullstack" class="text-xs font-semibold text-rose-600 hover:underline inline-flex items-center gap-1">
                        <span>Learn More</span> →
                    </a>
                </div>

                <!-- Service 2 -->
                <div class="p-7 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 space-y-4 hover:border-rose-500/50 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-500 flex items-center justify-center font-bold text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    </div>
                    <h3 class="text-lg font-bold font-heading text-neutral-900 dark:text-white">Graphic Design & Brand Identity</h3>
                    <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Vector logos with Adobe Illustrator, photo compositing with Photoshop, and cohesive visual identities that establish credibility.
                    </p>
                    <a href="services.php#branding" class="text-xs font-semibold text-rose-600 hover:underline inline-flex items-center gap-1">
                        <span>Learn More</span> →
                    </a>
                </div>

                <!-- Service 3 -->
                <div class="p-7 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 space-y-4 hover:border-rose-500/50 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center font-bold text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold font-heading text-neutral-900 dark:text-white">UI/UX Wireframing & Security</h3>
                    <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Interactive Figma prototypes, design token alignment, and security hardening against SQLi, CSRF, and session hijacking.
                    </p>
                    <a href="services.php#uiux" class="text-xs font-semibold text-rose-600 hover:underline inline-flex items-center gap-1">
                        <span>Learn More</span> →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Process: How I Work -->
    <section class="py-20 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Methodology</span>
                <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white">How I Work: From Concept to Launch</h2>
                <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-2">
                    <span class="text-xl font-extrabold font-heading text-rose-600">01</span>
                    <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Discovery & Scope</h4>
                    <p class="text-[11px] text-neutral-500 leading-relaxed">Uncovering functional objectives, user workflows, and branding vision.</p>
                </div>

                <div class="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-2">
                    <span class="text-xl font-extrabold font-heading text-rose-600">02</span>
                    <h4 class="text-sm font-bold text-neutral-900 dark:text-white">UI/UX Wireframing</h4>
                    <p class="text-[11px] text-neutral-500 leading-relaxed">Creating clickable Figma mockups and testing visual layouts early.</p>
                </div>

                <div class="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-2">
                    <span class="text-xl font-extrabold font-heading text-rose-600">03</span>
                    <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Full-Stack Code</h4>
                    <p class="text-[11px] text-neutral-500 leading-relaxed">Writing clean PHP 8+ controllers and relational MySQL schemas with PDO.</p>
                </div>

                <div class="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-2">
                    <span class="text-xl font-extrabold font-heading text-rose-600">04</span>
                    <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Security & QA</h4>
                    <p class="text-[11px] text-neutral-500 leading-relaxed">Validating CSRF tokens, preventing IDOR vulnerabilities, and responsive testing.</p>
                </div>

                <div class="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-2">
                    <span class="text-xl font-extrabold font-heading text-rose-600">05</span>
                    <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Deployment</h4>
                    <p class="text-[11px] text-neutral-500 leading-relaxed">Server configuration, database migration, and ongoing client handover.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20 bg-neutral-50 dark:bg-[#0b0d13] border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Portfolio Showcase</span>
                    <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white mt-1">Featured Case Studies</h2>
                </div>
                <a href="projects.php" class="text-xs font-bold text-rose-600 hover:underline flex items-center gap-1">
                    <span>View All Projects (<?= count($projects); ?>+)</span> →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                <div class="rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 overflow-hidden flex flex-col justify-between shadow-xs hover:border-rose-500/40 transition-all">
                    
                    <div class="h-44 bg-gradient-to-tr from-neutral-900 to-rose-950 p-6 flex flex-col justify-between">
                        <span class="self-start px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/40 text-rose-300 border border-white/10">
                            <?= sanitize($project['category']); ?>
                        </span>
                        <div>
                            <h3 class="text-base font-bold font-heading text-white"><?= sanitize($project['title']); ?></h3>
                            <span class="text-xs text-neutral-300"><?= sanitize($project['client'] ?? 'Client Solution'); ?></span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed line-clamp-3">
                            <?= sanitize($project['description']); ?>
                        </p>

                        <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex justify-between items-center text-xs">
                            <a href="project-details.php?id=<?= (int)$project['id']; ?>" class="font-bold text-rose-600 hover:underline">
                                Case Study →
                            </a>
                            <span class="font-mono text-[11px] text-neutral-400"><?= sanitize($project['tech_stack']); ?></span>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Client Endorsements</span>
                <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white">Recommendations & Feedback</h2>
                <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <?php foreach ($testimonials as $t): ?>
                    <div class="p-6 sm:p-8 rounded-3xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="text-amber-400 text-sm tracking-widest font-bold">
                                <?= str_repeat('★', (int)($t['rating'] ?? 5)); ?>
                            </div>
                            <span class="text-[11px] font-mono text-neutral-400"><?= sanitize($t['project_name']); ?></span>
                        </div>

                        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 italic leading-relaxed">
                            "<?= sanitize($t['quote']); ?>"
                        </p>

                        <div class="pt-2 border-t border-neutral-200/60 dark:border-neutral-800/80 text-xs">
                            <span class="font-bold text-neutral-900 dark:text-white block"><?= sanitize($t['client_name']); ?></span>
                            <span class="text-[11px] text-neutral-500"><?= sanitize($t['client_title']); ?> &bull; <?= sanitize($t['company']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Latest Articles / Blog -->
    <?php if (!empty($recentArticles)): ?>
        <section class="py-20 bg-neutral-50 dark:bg-[#0b0d13] border-b border-neutral-200/80 dark:border-neutral-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Technical Blog</span>
                        <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white mt-1">Articles & Engineering Insights</h2>
                    </div>
                    <a href="blog.php" class="text-xs font-bold text-rose-600 hover:underline flex items-center gap-1">
                        <span>All Articles</span> →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($recentArticles as $art): ?>
                        <article class="p-6 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs flex flex-col justify-between space-y-3">
                            <div class="space-y-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600"><?= sanitize($art['category']); ?></span>
                                <h3 class="text-sm font-bold font-heading text-neutral-900 dark:text-white">
                                    <a href="blog-post.php?id=<?= (int)$art['id']; ?>" class="hover:text-rose-600 transition-colors">
                                        <?= sanitize($art['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-xs text-neutral-500 line-clamp-2"><?= sanitize($art['excerpt']); ?></p>
                            </div>
                            <div class="pt-3 border-t border-neutral-100 dark:border-neutral-800/80 text-[11px] text-neutral-400 flex items-center justify-between">
                                <span><?= date('M d, Y', strtotime($art['created_at'])); ?></span>
                                <span class="text-rose-600 font-semibold">Read →</span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Contact Form Section -->
    <section id="contact" class="py-20 bg-white dark:bg-[#12141c]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center space-y-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Get In Touch</span>
                <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white">Let's Create Together</h2>
                <p class="text-xs sm:text-sm text-neutral-500">
                    Have a project proposal, question, or need a quote? Submit below or connect on WhatsApp.
                </p>
                <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto"></div>
            </div>

            <div id="form-feedback" class="hidden p-4 rounded-2xl text-xs sm:text-sm font-semibold"></div>

            <form id="contact-form" action="contact.php" method="POST" class="p-8 sm:p-10 rounded-3xl bg-neutral-50 dark:bg-neutral-900/80 border border-neutral-200 dark:border-neutral-800 space-y-4 shadow-sm">
                <?= getCsrfInput(); ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Your Name *</label>
                        <input 
                            type="text" 
                            name="name" 
                            required 
                            value="<?= sanitize($_SESSION['full_name'] ?? ''); ?>"
                            placeholder="Kasun Silva"
                            class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Email Address *</label>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            value="<?= sanitize($_SESSION['email'] ?? ''); ?>"
                            placeholder="client@example.com"
                            class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Phone / WhatsApp (Optional)</label>
                        <input 
                            type="tel" 
                            name="phone" 
                            placeholder="+94 7X XXX XXXX"
                            class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Subject *</label>
                        <input 
                            type="text" 
                            name="subject" 
                            required 
                            placeholder="e.g. Web Application Development Quote"
                            class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Message Details *</label>
                    <textarea 
                        name="message" 
                        rows="5" 
                        required 
                        placeholder="Tell me about your project goals, scope, and anticipated launch timeline..."
                        class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"
                    ></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-semibold text-xs sm:text-sm text-white bg-rose-600 hover:bg-rose-700 transition-all cursor-pointer shadow-xs">
                    Send Direct Message & Dispatch
                </button>
            </form>
        </div>
    </section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
