<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: blog.php
 * Technical Articles, Engineering Insights & Design Thoughts
 */

$pageTitle = 'Blog & Engineering Articles';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$pdo = getDatabaseConnection();

$articles = [];
try {
    $stmt = $pdo->query("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY id DESC");
    $articles = $stmt->fetchAll();
} catch (Exception $e) {
    error_log("Failed to fetch blog posts: " . $e->getMessage());
}

// Fallback seed articles if database is still fresh
if (empty($articles)) {
    $articles = [
        [
            'id' => 1,
            'title' => 'Architecting Resilient Full-Stack PHP Applications in 2026',
            'slug' => 'architecting-resilient-php-applications',
            'category' => 'Engineering',
            'reading_time' => '6 min read',
            'excerpt' => 'Why modern PHP 8+ paired with strict PDO prepared statements and modern CSS frameworks remains one of the fastest, most cost-efficient full-stack stacks.',
            'created_at' => '2026-02-10 14:00:00',
        ],
        [
            'id' => 2,
            'title' => 'Defense-in-Depth: Practical SQLi and IDOR Prevention for Web Developers',
            'slug' => 'defense-in-depth-sqli-idor-prevention',
            'category' => 'Security',
            'reading_time' => '8 min read',
            'excerpt' => 'A rigorous analysis of session token binding, parameterized queries, and strict role-based authorization to safeguard private user data.',
            'created_at' => '2026-02-25 11:30:00',
        ],
        [
            'id' => 3,
            'title' => 'Bridging Figma Design Tokens with Utility-First Tailwind CSS',
            'slug' => 'bridging-figma-tokens-tailwind',
            'category' => 'UI/UX',
            'reading_time' => '5 min read',
            'excerpt' => 'How graphic design systems translate cleanly into modular frontend utilities without visual degradation or CSS bloat.',
            'created_at' => '2026-03-05 09:15:00',
        ],
    ];
}
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-5xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                Insights & Thoughts
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Technical Blog & Design Notes
            </h1>
            <p class="text-xs sm:text-sm text-neutral-500">
                Writings on web architecture, software engineering at ICBT, and graphic design principles.
            </p>
            <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto mt-3"></div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <?php foreach ($articles as $art): ?>
                <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs flex flex-col justify-between space-y-4 hover:border-rose-500/40 transition-all group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                <?= sanitize($art['category']); ?>
                            </span>
                            <span class="text-[11px] text-neutral-400 font-mono">
                                <?= sanitize($art['reading_time']); ?>
                            </span>
                        </div>

                        <h2 class="text-base font-bold font-heading text-neutral-900 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                            <a href="blog-post.php?id=<?= (int)$art['id']; ?>">
                                <?= sanitize($art['title']); ?>
                            </a>
                        </h2>

                        <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed line-clamp-3">
                            <?= sanitize($art['excerpt']); ?>
                        </p>
                    </div>

                    <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 flex items-center justify-between text-xs">
                        <span class="text-neutral-400 text-[11px]">
                            <?= date('M d, Y', strtotime($art['created_at'])); ?>
                        </span>

                        <a href="blog-post.php?id=<?= (int)$art['id']; ?>" class="font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1">
                            <span>Read Article</span>
                            <span>→</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
