<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/blog.php
 * Administrative Blog & Article Management (CRUD)
 */

$pageTitle = 'Manage Blog Articles';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_once __DIR__ . '/../../includes/csrf.php';

$pdo = getDatabaseConnection();
$currentAdminId = (int)($_SESSION['admin_id'] ?? 1);

$notice = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation failed (CSRF token invalid). Please refresh.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'create' || $action === 'update') {
            $postId      = (int)($_POST['post_id'] ?? 0);
            $title       = trim($_POST['title'] ?? '');
            $category    = trim($_POST['category'] ?? 'Engineering');
            $excerpt     = trim($_POST['excerpt'] ?? '');
            $content     = trim($_POST['content'] ?? '');
            $readingTime = trim($_POST['reading_time'] ?? '5 min read');
            $isPublished = isset($_POST['is_published']) ? 1 : 0;
            $slug        = slugify($title);

            if (empty($title) || empty($content)) {
                $error = 'Title and content are required.';
            } else {
                try {
                    if ($action === 'create') {
                        $in = $pdo->prepare("
                            INSERT INTO blog_posts (title, slug, excerpt, content, category, reading_time, is_published, created_at)
                            VALUES (:title, :slug, :exc, :cont, :cat, :rt, :pub, NOW())
                        ");
                        $in->execute([
                            ':title' => $title,
                            ':slug'  => $slug,
                            ':exc'   => $excerpt,
                            ':cont'  => $content,
                            ':cat'   => $category,
                            ':rt'    => $readingTime,
                            ':pub'   => $isPublished,
                        ]);
                        $newId = (int)$pdo->lastInsertId();
                        logAdminAction($pdo, $currentAdminId, 'Create Article', 'blog_posts', $newId, "Created article: $title");
                        $notice = "Article \"$title\" published successfully.";
                    } else {
                        $up = $pdo->prepare("
                            UPDATE blog_posts 
                            SET title = :title, slug = :slug, excerpt = :exc, content = :cont, 
                                category = :cat, reading_time = :rt, is_published = :pub, updated_at = NOW()
                            WHERE id = :id
                        ");
                        $up->execute([
                            ':title' => $title,
                            ':slug'  => $slug,
                            ':exc'   => $excerpt,
                            ':cont'  => $content,
                            ':cat'   => $category,
                            ':rt'    => $readingTime,
                            ':pub'   => $isPublished,
                            ':id'    => $postId,
                        ]);
                        logAdminAction($pdo, $currentAdminId, 'Update Article', 'blog_posts', $postId, "Updated article: $title");
                        $notice = "Article updated successfully.";
                    }
                } catch (PDOException $e) {
                    error_log("Blog save error: " . $e->getMessage());
                    $error = 'Database error while saving blog post.';
                }
            }
        } elseif ($action === 'delete') {
            $postId = (int)($_POST['post_id'] ?? 0);
            try {
                $del = $pdo->prepare("DELETE FROM blog_posts WHERE id = :id");
                $del->execute([':id' => $postId]);
                logAdminAction($pdo, $currentAdminId, 'Delete Article', 'blog_posts', $postId, "Deleted article #$postId");
                $notice = 'Article deleted successfully.';
            } catch (PDOException $e) {
                error_log("Delete article error: " . $e->getMessage());
                $error = 'Failed to delete article.';
            }
        }
    }
}

// Edit post fetch
$editingPost = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $editId]);
    $editingPost = $stmt->fetch();
}

$posts = [];
try {
    $posts = $pdo->query("SELECT * FROM blog_posts ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    error_log("Blog list error: " . $e->getMessage());
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Articles & Technical Blog
            </h1>
            <p class="text-xs text-neutral-400 mt-0.5">
                Publish articles on modern web engineering, UX design, and PHP security practices.
            </p>
        </div>

        <a 
            href="#blog-form" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors self-start sm:self-auto"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Draft New Article</span>
        </a>
    </div>

    <?php if (!empty($notice)): ?>
        <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
            ✓ <?= sanitize($notice); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-semibold">
            <?= sanitize($error); ?>
        </div>
    <?php endif; ?>

    <!-- Blog Form -->
    <div id="blog-form" class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <h2 class="text-sm font-bold font-heading text-white">
            <?= $editingPost ? 'Edit Article: ' . sanitize($editingPost['title']) : 'Publish New Article'; ?>
        </h2>

        <form action="blog.php" method="POST" class="space-y-4">
            <?= getCsrfInput(); ?>
            <input type="hidden" name="action" value="<?= $editingPost ? 'update' : 'create'; ?>">
            <?php if ($editingPost): ?>
                <input type="hidden" name="post_id" value="<?= (int)$editingPost['id']; ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Article Title *</label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        value="<?= sanitize($editingPost['title'] ?? ''); ?>"
                        placeholder="e.g. Architecting Resilient Full-Stack PHP Applications in 2026"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Category</label>
                    <input 
                        type="text" 
                        name="category" 
                        value="<?= sanitize($editingPost['category'] ?? 'Engineering'); ?>"
                        placeholder="Engineering, UI/UX, Security"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Short Excerpt (Summary)</label>
                    <input 
                        type="text" 
                        name="excerpt" 
                        value="<?= sanitize($editingPost['excerpt'] ?? ''); ?>"
                        placeholder="Brief 1-2 sentence preview"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Estimated Reading Time</label>
                    <input 
                        type="text" 
                        name="reading_time" 
                        value="<?= sanitize($editingPost['reading_time'] ?? '5 min read'); ?>"
                        placeholder="e.g. 6 min read"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1">Article Body Content *</label>
                <textarea 
                    name="content" 
                    rows="8" 
                    required 
                    placeholder="Write article paragraphs..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 font-mono"
                ><?= sanitize($editingPost['content'] ?? ''); ?></textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input 
                    type="checkbox" 
                    name="is_published" 
                    id="is_published" 
                    value="1" 
                    <?= (!isset($editingPost) || !empty($editingPost['is_published'])) ? 'checked' : ''; ?>
                    class="rounded bg-neutral-900 border-neutral-700 text-rose-600 focus:ring-rose-500"
                >
                <label for="is_published" class="text-xs text-neutral-300">Publish immediately to public website</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-colors shadow-xs">
                    <?= $editingPost ? 'Save Article' : 'Publish Article'; ?>
                </button>
                <?php if ($editingPost): ?>
                    <a href="blog.php" class="px-4 py-2.5 rounded-xl border border-neutral-700 text-neutral-400 text-xs font-semibold hover:bg-neutral-800">
                        Cancel
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <h2 class="text-sm font-bold font-heading text-white">
            Published Articles (<?= count($posts); ?>)
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-neutral-400 border-b border-neutral-800 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-3">Title & Category</th>
                        <th class="py-3 px-3">Reading Time</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3">Date</th>
                        <th class="py-3 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    <?php foreach ($posts as $p): ?>
                        <tr class="hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3.5 px-3">
                                <span class="font-bold text-white block"><?= sanitize($p['title']); ?></span>
                                <span class="text-[11px] text-rose-400"><?= sanitize($p['category']); ?></span>
                            </td>
                            <td class="py-3.5 px-3 text-neutral-400">
                                <?= sanitize($p['reading_time']); ?>
                            </td>
                            <td class="py-3.5 px-3">
                                <?= $p['is_published'] ? '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>' : '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-neutral-800 text-neutral-400">Draft</span>'; ?>
                            </td>
                            <td class="py-3.5 px-3 text-neutral-500 whitespace-nowrap">
                                <?= date('M d, Y', strtotime($p['created_at'])); ?>
                            </td>
                            <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a 
                                        href="blog.php?edit=<?= (int)$p['id']; ?>#blog-form" 
                                        class="px-2.5 py-1 rounded-lg border border-neutral-700 text-neutral-300 hover:text-white hover:bg-neutral-800 text-[11px] font-medium transition-colors"
                                    >
                                        Edit
                                    </a>
                                    <form action="blog.php" method="POST" onsubmit="return confirm('Delete article <?= sanitize($p['title']); ?>?');" class="inline">
                                        <?= getCsrfInput(); ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="post_id" value="<?= (int)$p['id']; ?>">
                                        <button type="submit" class="p-1 rounded-lg bg-neutral-800 hover:bg-red-500/20 hover:text-red-400 text-neutral-400 transition-colors" title="Delete Article">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
