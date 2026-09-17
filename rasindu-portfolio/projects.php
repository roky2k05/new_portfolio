<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: projects.php
 * Filterable Portfolio Showcase with Real MySQL Data & Direct Case Study Links
 */

$pageTitle = 'Portfolio & Case Studies';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$pdo = getDatabaseConnection();
$activeCat = trim($_GET['category'] ?? 'All');

$projects = getProjects($activeCat);

// Extract available categories
$categories = ['All', 'Full-Stack Web App', 'Brand Identity & Web', 'Web Application'];
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                Selected Works
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Case Studies & Featured Projects
            </h1>
            <p class="text-xs sm:text-sm text-neutral-500">
                Explore real web development implementations, client systems, and custom UI/UX applications.
            </p>
            <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto mt-3"></div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <?php foreach ($categories as $cat): ?>
                <a 
                    href="projects.php?category=<?= urlencode($cat); ?>" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-colors <?= $activeCat === $cat ? 'bg-rose-600 text-white shadow-xs' : 'bg-white dark:bg-[#121620] text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-800 hover:text-neutral-900 dark:hover:text-white'; ?>"
                >
                    <?= sanitize($cat); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <?php foreach ($projects as $p): ?>
                <div class="rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs overflow-hidden flex flex-col justify-between hover:border-rose-500/40 transition-all group">
                    
                    <!-- Top Graphic Header -->
                    <div class="h-44 bg-gradient-to-tr from-neutral-900 via-neutral-800 to-rose-950 p-6 flex flex-col justify-between relative overflow-hidden">
                        <div class="flex items-center justify-between z-10">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/40 text-rose-300 border border-white/10 backdrop-blur-xs">
                                <?= sanitize($p['category']); ?>
                            </span>
                            <?php if (!empty($p['is_featured'])): ?>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                    ★ Featured
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="z-10">
                            <h3 class="text-lg font-bold font-heading text-white group-hover:text-rose-400 transition-colors">
                                <?= sanitize($p['title']); ?>
                            </h3>
                            <span class="text-xs text-neutral-300"><?= sanitize($p['client'] ?? 'Client Solution'); ?></span>
                        </div>

                        <!-- Abstract background geometric decor -->
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full bg-rose-500/10 blur-xl"></div>
                    </div>

                    <!-- Body Content -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed line-clamp-3">
                                <?= sanitize($p['description']); ?>
                            </p>

                            <!-- Tech Stack Pills -->
                            <div class="flex flex-wrap gap-1.5 pt-2">
                                <?php 
                                $tags = explode(',', $p['tech_stack'] ?? '');
                                foreach ($tags as $t):
                                    if (trim($t)):
                                ?>
                                    <span class="px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-neutral-800/80 text-[10px] font-mono text-neutral-600 dark:text-neutral-400">
                                        <?= sanitize(trim($t)); ?>
                                    </span>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>

                        <!-- Bottom CTAs -->
                        <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex items-center justify-between gap-3 text-xs">
                            <a 
                                href="project-details.php?id=<?= (int)$p['id']; ?>" 
                                class="font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1"
                            >
                                <span>Case Study</span>
                                <span>→</span>
                            </a>

                            <div class="flex items-center gap-3 text-neutral-500">
                                <?php if (!empty($p['github_url'])): ?>
                                    <a href="<?= sanitize($p['github_url']); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-neutral-900 dark:hover:text-white transition-colors" title="GitHub Code">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($p['live_url'])): ?>
                                    <a href="<?= sanitize($p['live_url']); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-rose-600 transition-colors" title="Live Preview">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
