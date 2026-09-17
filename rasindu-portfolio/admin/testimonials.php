<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/testimonials.php
 * Administrative Testimonials Management (CRUD)
 */

$pageTitle = 'Manage Testimonials';
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
        $error = 'Security validation failed (CSRF token invalid).';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'create') {
            $name        = trim($_POST['client_name'] ?? '');
            $title       = trim($_POST['client_title'] ?? '');
            $company     = trim($_POST['company'] ?? '');
            $quote       = trim($_POST['quote'] ?? '');
            $rating      = (int)($_POST['rating'] ?? 5);
            $projectName = trim($_POST['project_name'] ?? '');

            if (empty($name) || empty($quote)) {
                $error = 'Client name and quote are required.';
            } else {
                try {
                    $in = $pdo->prepare("
                        INSERT INTO testimonials (client_name, client_title, company, quote, rating, project_name, is_approved, created_at)
                        VALUES (:name, :title, :company, :quote, :rating, :project, 1, NOW())
                    ");
                    $in->execute([
                        ':name'    => $name,
                        ':title'   => $title,
                        ':company' => $company,
                        ':quote'   => $quote,
                        ':rating'  => $rating,
                        ':project' => $projectName,
                    ]);
                    $newId = (int)$pdo->lastInsertId();
                    logAdminAction($pdo, $currentAdminId, 'Add Testimonial', 'testimonials', $newId, "Added review from $name");
                    $notice = "Testimonial from \"$name\" added.";
                } catch (PDOException $e) {
                    error_log("Testimonial add error: " . $e->getMessage());
                    $error = 'Database error adding testimonial.';
                }
            }
        } elseif ($action === 'delete') {
            $testId = (int)($_POST['testimonial_id'] ?? 0);
            try {
                $del = $pdo->prepare("DELETE FROM testimonials WHERE id = :id");
                $del->execute([':id' => $testId]);
                logAdminAction($pdo, $currentAdminId, 'Delete Testimonial', 'testimonials', $testId, "Deleted testimonial #$testId");
                $notice = 'Testimonial removed successfully.';
            } catch (PDOException $e) {
                error_log("Delete testimonial error: " . $e->getMessage());
                $error = 'Failed to delete testimonial.';
            }
        }
    }
}

$testimonials = [];
try {
    $testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    error_log("Testimonials fetch error: " . $e->getMessage());
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Client Testimonials & Endorsements
            </h1>
            <p class="text-xs text-neutral-400 mt-0.5">
                Manage verified recommendations, ratings, and quotes from project partners.
            </p>
        </div>
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

    <!-- Add Form -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <h2 class="text-sm font-bold font-heading text-white">Add New Client Testimonial</h2>

        <form action="testimonials.php" method="POST" class="space-y-4">
            <?= getCsrfInput(); ?>
            <input type="hidden" name="action" value="create">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Client Name *</label>
                    <input 
                        type="text" 
                        name="client_name" 
                        required 
                        placeholder="e.g. Kasun Silva"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Client Title / Role</label>
                    <input 
                        type="text" 
                        name="client_title" 
                        placeholder="e.g. Founder & Managing Director"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Company / Organization</label>
                    <input 
                        type="text" 
                        name="company" 
                        placeholder="e.g. Ceylon Digital Labs"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Project Name</label>
                    <input 
                        type="text" 
                        name="project_name" 
                        placeholder="e.g. Corporate Web Application & Brand Kit"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Rating (Stars)</label>
                    <select name="rating" class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm">
                        <option value="5">★★★★★ (5 Stars - Exceptional)</option>
                        <option value="4">★★★★☆ (4 Stars - Great)</option>
                        <option value="3">★★★☆☆ (3 Stars - Good)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1">Quote / Review Statement *</label>
                <textarea 
                    name="quote" 
                    rows="3" 
                    required 
                    placeholder="Describe feedback on code quality, design fidelity, and communication..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                ></textarea>
            </div>

            <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-colors shadow-xs">
                Save & Display Testimonial
            </button>
        </form>
    </div>

    <!-- Testimonials List -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <h2 class="text-sm font-bold font-heading text-white">
            Current Testimonials (<?= count($testimonials); ?>)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($testimonials as $t): ?>
                <div class="p-5 rounded-xl bg-neutral-900/60 border border-neutral-800 space-y-3 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-xs"><?= sanitize($t['client_name']); ?></span>
                            <span class="block text-[11px] text-neutral-400"><?= sanitize($t['client_title']); ?> • <?= sanitize($t['company']); ?></span>
                        </div>
                        <div class="text-amber-400 text-xs tracking-widest font-bold">
                            <?= str_repeat('★', (int)$t['rating']); ?>
                        </div>
                    </div>

                    <p class="text-xs text-neutral-300 italic leading-relaxed">
                        "<?= sanitize($t['quote']); ?>"
                    </p>

                    <div class="flex items-center justify-between pt-2 border-t border-neutral-800/60 text-[11px] text-neutral-500">
                        <span><?= sanitize($t['project_name']); ?></span>
                        <form action="testimonials.php" method="POST" onsubmit="return confirm('Delete this testimonial?');" class="inline">
                            <?= getCsrfInput(); ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="testimonial_id" value="<?= (int)$t['id']; ?>">
                            <button type="submit" class="text-red-400 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
