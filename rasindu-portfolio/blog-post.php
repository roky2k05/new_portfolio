<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: blog-post.php
 * In-Depth Technical Article View
 */

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$pdo = getDatabaseConnection();
$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$post = null;
if ($postId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = :id AND is_published = 1 LIMIT 1");
        $stmt->execute([':id' => $postId]);
        $post = $stmt->fetch();
    } catch (Exception $e) {
        error_log("Failed to fetch post: " . $e->getMessage());
    }
}

// Fallback if not in database yet
if (!$post) {
    $fallbackPosts = [
        1 => [
            'id' => 1,
            'title' => 'Architecting Resilient Full-Stack PHP Applications in 2026',
            'category' => 'Engineering',
            'reading_time' => '6 min read',
            'created_at' => '2026-02-10 14:00:00',
            'content' => "In modern web engineering, the discussion often gravitates towards overly complex JavaScript frameworks and microservice sprawl. However, modern PHP 8+ paired with MySQL, strict PDO prepared statements, and Tailwind CSS represents one of the most reliable, cost-efficient, and secure architectures for building web products.\n\n### 1. The Power of PHP 8+\nPHP 8 introduced major enhancements: JIT compilation, named arguments, match expressions, union types, and enhanced type safety. When organized cleanly with object-oriented paradigms and clear separation of concerns, PHP provides instant execution, low memory overhead, and straightforward deployment without build-step fragility.\n\n### 2. Database Integrity & Prepared Statements\nSecurity begins at the data layer. By strictly enforcing PDO with emulation disabled (`PDO::ATTR_EMULATE_PREPARES => false`), every SQL query is parsed independently of user inputs. This eliminates SQL injection attack surfaces at compile-time.\n\n### 3. Pragmatic Full-Stack Velocity\nBy coupling PHP's battle-tested session management and CSRF token generation with Tailwind CSS utility classes, developers can ship high-performance, mobile-responsive applications in record time. Rasindu Nawod's philosophy is simple: deliver rock-solid, production-grade applications where every line of code serves a functional purpose.",
        ],
        2 => [
            'id' => 2,
            'title' => 'Defense-in-Depth: Practical SQLi and IDOR Prevention for Web Developers',
            'category' => 'Security',
            'reading_time' => '8 min read',
            'created_at' => '2026-02-25 11:30:00',
            'content' => "Insecure Direct Object Reference (IDOR) remains among the most prevalent vulnerabilities in web applications. It occurs when an application exposes a reference to an internal object, such as a database primary key, without adequate authorization checks.\n\n### Never Trust Client-Supplied Identifiers\nA frequent mistake is trusting `\$_GET['user_id']` or trusting that a client will only query their own record numbers. In a secure architecture, user identity must ONLY be derived from the cryptographically signed server-side session: `\$_SESSION['user_id']`.\n\n### Prepared Queries with Ownership Verification\nEvery query fetching sensitive messages or profile settings must bind the session user ID:\n`SELECT * FROM messages WHERE id = :id AND user_id = :session_user_id`\nIf the record exists but belongs to someone else, the query returns zero rows—completely mitigating unauthorized access.\n\nCombined with CSRF validation tokens on all mutating HTTP methods, modern applications can achieve banking-grade authorization hygiene.",
        ],
    ];

    $post = $fallbackPosts[$postId] ?? $fallbackPosts[1];
}

$pageTitle = $post['title'] . ' - Rasindu Nawod Blog';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-3xl mx-auto space-y-10">
        
        <!-- Back Link -->
        <div>
            <a href="blog.php" class="text-xs font-semibold text-neutral-500 hover:text-rose-600 dark:hover:text-rose-400 flex items-center gap-1 transition-colors">
                <span>← Back to all articles</span>
            </a>
        </div>

        <!-- Article Header -->
        <header class="space-y-4">
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                    <?= sanitize($post['category']); ?>
                </span>
                <span class="text-neutral-400 font-mono">
                    <?= sanitize($post['reading_time']); ?>
                </span>
                <span class="text-neutral-400">&bull;</span>
                <span class="text-neutral-400">
                    <?= date('F d, Y', strtotime($post['created_at'])); ?>
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight leading-tight">
                <?= sanitize($post['title']); ?>
            </h1>

            <!-- Author Card -->
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800">
                <div class="w-10 h-10 rounded-full bg-rose-600 text-white flex items-center justify-center font-bold text-sm">
                    RN
                </div>
                <div class="text-xs">
                    <span class="font-bold text-neutral-900 dark:text-white block">Rasindu Nawod</span>
                    <span class="text-neutral-500">Web Developer & Graphic Designer &bull; Matara, Sri Lanka</span>
                </div>
            </div>
        </header>

        <!-- Article Body -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6 text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
            <?= nl2br(sanitize($post['content'])); ?>
        </div>

        <!-- Consultation Card at bottom of article -->
        <div class="p-8 rounded-3xl bg-neutral-900 text-white border border-neutral-800 space-y-4">
            <h3 class="text-lg font-bold font-heading">Interested in architecting a secure web solution?</h3>
            <p class="text-xs text-neutral-400 leading-relaxed">
                Rasindu Nawod is available for full-stack web development and graphic design projects across Sri Lanka and internationally.
            </p>
            <div class="pt-2">
                <a href="contact.php" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors">
                    <span>Contact Rasindu</span>
                    <span>→</span>
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
