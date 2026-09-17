<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/projects.php
 * Administrative Projects Portfolio Management (CRUD)
 */

$pageTitle = 'Manage Projects';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_once __DIR__ . '/../../includes/csrf.php';

$pdo = getDatabaseConnection();
$currentAdminId = (int)($_SESSION['admin_id'] ?? 1);

$notice = '';
$error = '';

// Handle Create / Update / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Security validation token expired. Please refresh.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'create' || $action === 'update') {
            $projectId   = (int)($_POST['project_id'] ?? 0);
            $title       = trim($_POST['title'] ?? '');
            $category    = trim($_POST['category'] ?? 'Full-Stack Web App');
            $client      = trim($_POST['client'] ?? '');
            $role        = trim($_POST['role'] ?? 'Lead Developer & UI Designer');
            $description = trim($_POST['description'] ?? '');
            $techStack   = trim($_POST['tech_stack'] ?? '');
            $liveUrl     = trim($_POST['live_url'] ?? '');
            $githubUrl   = trim($_POST['github_url'] ?? '');
            $isFeatured  = isset($_POST['is_featured']) ? 1 : 0;
            $slug        = slugify($title);

            if (empty($title) || empty($description)) {
                $error = 'Project title and description are required.';
            } else {
                try {
                    if ($action === 'create') {
                        $in = $pdo->prepare("
                            INSERT INTO projects (title, slug, category, client, role, description, tech_stack, live_url, github_url, is_featured, created_at)
                            VALUES (:title, :slug, :cat, :client, :role, :desc, :tech, :live, :git, :feat, NOW())
                        ");
                        $in->execute([
                            ':title'  => $title,
                            ':slug'   => $slug,
                            ':cat'    => $category,
                            ':client' => $client,
                            ':role'   => $role,
                            ':desc'   => $description,
                            ':tech'   => $techStack,
                            ':live'   => $liveUrl,
                            ':git'    => $githubUrl,
                            ':feat'   => $isFeatured,
                        ]);
                        $newId = (int)$pdo->lastInsertId();
                        logAdminAction($pdo, $currentAdminId, 'Create Project', 'projects', $newId, "Added project: $title");
                        $notice = "Project \"$title\" added successfully.";
                    } else {
                        $up = $pdo->prepare("
                            UPDATE projects 
                            SET title = :title, slug = :slug, category = :cat, client = :client, role = :role, 
                                description = :desc, tech_stack = :tech, live_url = :live, github_url = :git, 
                                is_featured = :feat, updated_at = NOW()
                            WHERE id = :id
                        ");
                        $up->execute([
                            ':title'  => $title,
                            ':slug'   => $slug,
                            ':cat'    => $category,
                            ':client' => $client,
                            ':role'   => $role,
                            ':desc'   => $description,
                            ':tech'   => $techStack,
                            ':live'   => $liveUrl,
                            ':git'    => $githubUrl,
                            ':feat'   => $isFeatured,
                            ':id'     => $projectId,
                        ]);
                        logAdminAction($pdo, $currentAdminId, 'Update Project', 'projects', $projectId, "Updated project: $title");
                        $notice = "Project \"$title\" updated successfully.";
                    }
                } catch (PDOException $e) {
                    error_log("Project save error: " . $e->getMessage());
                    $error = 'Database error while saving project.';
                }
            }
        } elseif ($action === 'delete') {
            $projectId = (int)($_POST['project_id'] ?? 0);
            try {
                $del = $pdo->prepare("DELETE FROM projects WHERE id = :id");
                $del->execute([':id' => $projectId]);
                logAdminAction($pdo, $currentAdminId, 'Delete Project', 'projects', $projectId, "Deleted project #$projectId");
                $notice = "Project deleted successfully.";
            } catch (PDOException $e) {
                error_log("Project delete error: " . $e->getMessage());
                $error = 'Failed to delete project.';
            }
        }
    }
}

// Fetch edit project if requested
$editingProject = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $editId]);
    $editingProject = $stmt->fetch();
}

// Fetch all projects
$projects = [];
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Projects error: " . $e->getMessage());
}
?>

<main class="flex-1 p-6 sm:p-8 bg-[#0b0d13] overflow-y-auto space-y-8">
    
    <!-- Top Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-extrabold font-heading text-white tracking-tight">
                Portfolio Projects Management
            </h1>
            <p class="text-xs text-neutral-400 mt-0.5">
                Add, edit, and organize web development and design showcase projects.
            </p>
        </div>

        <a 
            href="#project-form" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors self-start sm:self-auto"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Add New Project</span>
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

    <!-- Project Form Container -->
    <div id="project-form" class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <h2 class="text-sm font-bold font-heading text-white">
            <?= $editingProject ? 'Edit Project: ' . sanitize($editingProject['title']) : 'Add New Portfolio Project'; ?>
        </h2>

        <form action="projects.php" method="POST" class="space-y-4">
            <?= getCsrfInput(); ?>
            <input type="hidden" name="action" value="<?= $editingProject ? 'update' : 'create'; ?>">
            <?php if ($editingProject): ?>
                <input type="hidden" name="project_id" value="<?= (int)$editingProject['id']; ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Project Title *</label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        value="<?= sanitize($editingProject['title'] ?? ''); ?>"
                        placeholder="e.g. EduLanka Learning Management Platform"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Category *</label>
                    <input 
                        type="text" 
                        name="category" 
                        required 
                        value="<?= sanitize($editingProject['category'] ?? 'Full-Stack Web Application'); ?>"
                        placeholder="e.g. Full-Stack Web Application, UI/UX Design, Graphic Identity"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Client / Organization</label>
                    <input 
                        type="text" 
                        name="client" 
                        value="<?= sanitize($editingProject['client'] ?? ''); ?>"
                        placeholder="e.g. Ceylon Institute / Freelance"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Your Role</label>
                    <input 
                        type="text" 
                        name="role" 
                        value="<?= sanitize($editingProject['role'] ?? 'Lead Web Developer & Designer'); ?>"
                        placeholder="e.g. Lead Web Developer & Designer"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1">Description *</label>
                <textarea 
                    name="description" 
                    rows="4" 
                    required 
                    placeholder="Provide detailed information on goals, architectural challenges solved, and UX decisions..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                ><?= sanitize($editingProject['description'] ?? ''); ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Tech Stack (Comma-separated)</label>
                    <input 
                        type="text" 
                        name="tech_stack" 
                        value="<?= sanitize($editingProject['tech_stack'] ?? 'PHP 8, MySQL, Tailwind CSS, JavaScript'); ?>"
                        placeholder="PHP 8, MySQL, Tailwind CSS"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">Live Demo URL</label>
                    <input 
                        type="url" 
                        name="live_url" 
                        value="<?= sanitize($editingProject['live_url'] ?? ''); ?>"
                        placeholder="https://example.com"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1">GitHub Repository URL</label>
                    <input 
                        type="url" 
                        name="github_url" 
                        value="<?= sanitize($editingProject['github_url'] ?? ''); ?>"
                        placeholder="https://github.com/rasindu/repo"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-900 border border-neutral-700 text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                    >
                </div>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input 
                    type="checkbox" 
                    name="is_featured" 
                    id="is_featured" 
                    value="1" 
                    <?= (!empty($editingProject['is_featured'])) ? 'checked' : ''; ?>
                    class="rounded bg-neutral-900 border-neutral-700 text-rose-600 focus:ring-rose-500"
                >
                <label for="is_featured" class="text-xs text-neutral-300">Feature this project prominently on homepage</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-colors shadow-xs">
                    <?= $editingProject ? 'Save Project Changes' : 'Publish New Project'; ?>
                </button>
                <?php if ($editingProject): ?>
                    <a href="projects.php" class="px-4 py-2.5 rounded-xl border border-neutral-700 text-neutral-400 text-xs font-semibold hover:bg-neutral-800">
                        Cancel Edit
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Existing Projects Table -->
    <div class="p-6 rounded-2xl bg-[#121620] border border-neutral-800 shadow-xs space-y-4">
        <h2 class="text-sm font-bold font-heading text-white">
            Current Projects (<?= count($projects); ?>)
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-neutral-400 border-b border-neutral-800 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-3">Title & Category</th>
                        <th class="py-3 px-3">Tech Stack</th>
                        <th class="py-3 px-3">Featured</th>
                        <th class="py-3 px-3">Created</th>
                        <th class="py-3 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    <?php foreach ($projects as $p): ?>
                        <tr class="hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3.5 px-3">
                                <span class="font-bold text-white block"><?= sanitize($p['title']); ?></span>
                                <span class="text-[11px] text-rose-400"><?= sanitize($p['category']); ?></span>
                            </td>
                            <td class="py-3.5 px-3 max-w-xs truncate text-neutral-400">
                                <?= sanitize($p['tech_stack']); ?>
                            </td>
                            <td class="py-3.5 px-3">
                                <?= $p['is_featured'] ? '<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Featured</span>' : '<span class="text-neutral-600 text-[10px]">Standard</span>'; ?>
                            </td>
                            <td class="py-3.5 px-3 text-neutral-500 whitespace-nowrap">
                                <?= date('M d, Y', strtotime($p['created_at'])); ?>
                            </td>
                            <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a 
                                        href="projects.php?edit=<?= (int)$p['id']; ?>#project-form" 
                                        class="px-2.5 py-1 rounded-lg border border-neutral-700 text-neutral-300 hover:text-white hover:bg-neutral-800 text-[11px] font-medium transition-colors"
                                    >
                                        Edit
                                    </a>
                                    <form action="projects.php" method="POST" onsubmit="return confirm('Permanently delete project <?= sanitize($p['title']); ?>?');" class="inline">
                                        <?= getCsrfInput(); ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="project_id" value="<?= (int)$p['id']; ?>">
                                        <button type="submit" class="p-1 rounded-lg bg-neutral-800 hover:bg-red-500/20 hover:text-red-400 text-neutral-400 transition-colors" title="Delete Project">
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
