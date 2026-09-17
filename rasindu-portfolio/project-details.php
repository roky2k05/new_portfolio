<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: project-details.php
 * In-Depth Technical & Design Project Case Study
 */

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$pdo = getDatabaseConnection();
$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$project = null;
if ($projectId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $projectId]);
        $project = $stmt->fetch();
    } catch (Exception $e) {
        error_log("Failed to fetch project details: " . $e->getMessage());
    }
}

// Fallback project if not in database yet
if (!$project) {
    $all = getProjects('All');
    foreach ($all as $item) {
        if ((int)$item['id'] === $projectId || $projectId === 0) {
            $project = $item;
            break;
        }
    }
}

if (!$project) {
    echo "<main class='min-h-screen p-12 text-center text-neutral-800 dark:text-white'>Project not found. <a href='projects.php' class='text-rose-500'>Back to Projects</a></main>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $project['title'] . ' - Case Study';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-4xl mx-auto space-y-10">
        
        <!-- Breadcrumb navigation -->
        <div>
            <a href="projects.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 dark:hover:text-rose-400 flex items-center gap-1.5 transition-colors">
                <span>← Back to all case studies</span>
            </a>
        </div>

        <!-- Header Card -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                    <?= sanitize($project['category']); ?>
                </span>
                <?php if (!empty($project['is_featured'])): ?>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                        Featured Case Study
                    </span>
                <?php endif; ?>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                <?= sanitize($project['title']); ?>
            </h1>

            <!-- Meta attributes -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-neutral-100 dark:border-neutral-800/80 text-xs">
                <div>
                    <span class="block text-neutral-400 text-[11px]">Client / Partner</span>
                    <span class="font-bold text-neutral-800 dark:text-neutral-200"><?= sanitize($project['client'] ?? 'Direct Client'); ?></span>
                </div>
                <div>
                    <span class="block text-neutral-400 text-[11px]">My Role</span>
                    <span class="font-bold text-neutral-800 dark:text-neutral-200"><?= sanitize($project['role'] ?? 'Full-Stack Developer'); ?></span>
                </div>
                <div>
                    <span class="block text-neutral-400 text-[11px]">Timeline</span>
                    <span class="font-bold text-neutral-800 dark:text-neutral-200"><?= date('M Y', strtotime($project['created_at'])); ?></span>
                </div>
                <div>
                    <span class="block text-neutral-400 text-[11px]">Deployment</span>
                    <span class="font-bold text-emerald-500">Production Ready</span>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <?php if (!empty($project['live_url'])): ?>
                    <a 
                        href="<?= sanitize($project['live_url']); ?>" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors shadow-xs flex items-center gap-1.5"
                    >
                        <span>Visit Live Platform</span>
                        <span>↗</span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($project['github_url'])): ?>
                    <a 
                        href="<?= sanitize($project['github_url']); ?>" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="px-5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 font-semibold text-xs transition-colors flex items-center gap-1.5"
                    >
                        <span>GitHub Repository</span>
                    </a>
                <?php endif; ?>

                <a 
                    href="contact.php?subject=Inquiry+regarding+<?= urlencode($project['title']); ?>" 
                    class="px-5 py-2.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 hover:text-rose-600 font-semibold text-xs transition-colors ml-auto"
                >
                    Discuss Similar Project →
                </a>
            </div>
        </div>

        <!-- Case Study Body -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-8">
            
            <div class="space-y-3">
                <h2 class="text-xl font-bold font-heading text-neutral-900 dark:text-white">Project Overview & Objectives</h2>
                <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
                    <?= sanitize($project['description']); ?>
                </p>
            </div>

            <!-- Tech Stack Deep Dive -->
            <div class="space-y-4 pt-6 border-t border-neutral-100 dark:border-neutral-800">
                <h2 class="text-xl font-bold font-heading text-neutral-900 dark:text-white">Technology Stack & Implementation</h2>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    $tags = explode(',', $project['tech_stack'] ?? '');
                    foreach ($tags as $t):
                        if (trim($t)):
                    ?>
                        <span class="px-3 py-1.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-xs font-mono text-neutral-700 dark:text-neutral-300">
                            <?= sanitize(trim($t)); ?>
                        </span>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>

            <!-- Architectural Highlights -->
            <div class="space-y-4 pt-6 border-t border-neutral-100 dark:border-neutral-800">
                <h2 class="text-xl font-bold font-heading text-neutral-900 dark:text-white">Architectural Highlights</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-1">
                        <span class="text-xs font-bold text-neutral-900 dark:text-white block">Security & Data Integrity</span>
                        <p class="text-xs text-neutral-500 leading-relaxed">
                            Prepared statements prevent SQL injection; CSRF tokens guard all mutating state actions.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200/80 dark:border-neutral-800 space-y-1">
                        <span class="text-xs font-bold text-neutral-900 dark:text-white block">Responsive Visual UX</span>
                        <p class="text-xs text-neutral-500 leading-relaxed">
                            Engineered with Tailwind CSS utility architecture for fluid scalability from mobile viewports to desktop.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
