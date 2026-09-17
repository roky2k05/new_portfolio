<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/functions.php
 * Core Helper Functions, Security Sanitization, Audit Logging & Badges
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Sanitize string for HTML output (XSS Prevention)
 */
function sanitize(?string $data): string {
    if ($data === null) {
        return '';
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Log Administrative actions to admin_logs table
 */
function logAdminAction(PDO $pdo, ?int $adminId, string $action, ?string $targetType = null, ?int $targetId = null, string $description = ''): void {
    try {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $stmt = $pdo->prepare("
            INSERT INTO admin_logs (admin_id, action, target_type, target_id, description, ip_address)
            VALUES (:admin_id, :action, :target_type, :target_id, :description, :ip)
        ");
        $stmt->execute([
            ':admin_id'    => $adminId,
            ':action'      => $action,
            ':target_type' => $targetType,
            ':target_id'   => $targetId,
            ':description' => $description,
            ':ip'          => $ip,
        ]);
    } catch (Exception $e) {
        error_log("Failed to log admin action: " . $e->getMessage());
    }
}

/**
 * Create a user notification in the notifications table
 */
function createNotification(PDO $pdo, int $userId, string $title, string $message, string $type = 'reply'): void {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO notifications (user_id, title, message, type, is_read, created_at)
            VALUES (:user_id, :title, :message, :type, 0, NOW())
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':title'   => $title,
            ':message' => $message,
            ':type'    => $type,
        ]);
    } catch (Exception $e) {
        error_log("Failed to create notification: " . $e->getMessage());
    }
}

/**
 * Get unread notifications count for a specific user
 */
function getUnreadNotificationsCount(PDO $pdo, int $userId): int {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :uid AND is_read = 0");
        $stmt->execute([':uid' => $userId]);
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

/**
 * Get unread contact messages count for Admin
 */
function getAdminUnreadMessagesCount(PDO $pdo): int {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'Unread'");
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

/**
 * Format timestamp nicely
 */
function formatDateTime(?string $datetime): string {
    if (!$datetime) return 'N/A';
    return date('d M Y, h:i A', strtotime($datetime));
}

/**
 * Render standard status badge HTML
 */
function renderStatusBadge(string $status): string {
    $status = trim($status);
    switch ($status) {
        case 'Unread':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-500 border border-rose-500/20">Unread</span>';
        case 'Read':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Read</span>';
        case 'In Progress':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">In Progress</span>';
        case 'Replied':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Replied</span>';
        case 'Closed':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-neutral-800 text-neutral-400 border border-neutral-700">Closed</span>';
        default:
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-neutral-800 text-neutral-300 border border-neutral-700">' . sanitize($status) . '</span>';
    }
}

/**
 * Fetch active social links from database (fallback to defaults if table not ready)
 */
function getSocialLinks(PDO $pdo): array {
    try {
        $stmt = $pdo->query("SELECT * FROM social_links WHERE is_active = 1 ORDER BY id ASC");
        $links = $stmt->fetchAll();
        if (!empty($links)) {
            return $links;
        }
    } catch (Exception $e) {
        // Fall through to hardcoded defaults
    }

    return [
        ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/share/1F6N9ALqmG/', 'icon' => 'facebook'],
        ['platform' => 'Instagram', 'url' => 'https://www.instagram.com/lex_frost2k5?stkn=dmloMGtkc2RmZWIz', 'icon' => 'instagram'],
        ['platform' => 'TikTok', 'url' => 'https://www.tiktok.com/@rokiya2k', 'icon' => 'tiktok'],
        ['platform' => 'GitHub', 'url' => 'https://github.com/roky2k05', 'icon' => 'github'],
        ['platform' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/rasindu-nawod-148901374', 'icon' => 'linkedin'],
        ['platform' => 'WhatsApp', 'url' => WHATSAPP_LINK, 'icon' => 'whatsapp'],
    ];
}

/**
 * Slugify string helper
 */
function slugify(string $text): string {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'item-' . time() : $text;
}

/**
 * Fetch projects from MySQL database with optional category filter
 */
function getProjects(?string $category = 'All', int $limit = 0): array {
    try {
        $pdo = getDatabaseConnection();
        $sql = "SELECT * FROM projects";
        $params = [];
        if ($category && $category !== 'All') {
            $sql .= " WHERE category = :cat";
            $params[':cat'] = $category;
        }
        $sql .= " ORDER BY is_featured DESC, id DESC";
        if ($limit > 0) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetchAll();
        if (!empty($res)) {
            return $res;
        }
    } catch (Exception $e) {
        error_log("Failed to fetch projects: " . $e->getMessage());
    }

    // Fallback default projects
    return [
        [
            'id' => 1,
            'title' => 'EduLanka Learning Management System',
            'slug' => 'edulanka-lms',
            'category' => 'Full-Stack Web App',
            'client' => 'Higher Education Client',
            'role' => 'Lead Full-Stack Developer',
            'description' => 'A robust institutional learning management system featuring role-based dashboards, student enrollments, attendance tracking, quiz modules, and secure PDO MySQL authentication.',
            'tech_stack' => 'PHP 8, MySQL, Tailwind CSS, JavaScript, PDO',
            'live_url' => 'https://github.com/roky2k05',
            'github_url' => 'https://github.com/roky2k05',
            'is_featured' => 1,
            'created_at' => '2025-10-15 10:00:00',
        ],
        [
            'id' => 2,
            'title' => 'Ceylon Heritage Brand Identity & Web App',
            'slug' => 'ceylon-heritage',
            'category' => 'Brand Identity & Web',
            'client' => 'Ceylon Exports',
            'role' => 'UI/UX Designer & Developer',
            'description' => 'Comprehensive branding system with custom vector iconography, typography scales, responsive catalog showcases, and customer inquiry management.',
            'tech_stack' => 'Figma, Adobe Illustrator, HTML5, CSS3, PHP, MySQL',
            'live_url' => 'https://github.com/roky2k05',
            'github_url' => 'https://github.com/roky2k05',
            'is_featured' => 1,
            'created_at' => '2025-11-20 14:30:00',
        ],
        [
            'id' => 3,
            'title' => 'Matara Urban Eco Tourism Portal',
            'slug' => 'matara-eco-tourism',
            'category' => 'Web Application',
            'client' => 'Southern Tourism Board Project',
            'role' => 'Full-Stack Developer',
            'description' => 'Interactive tourism web portal showcasing scenic locations in Southern Sri Lanka, accommodation booking inquiries, and localized guides with responsive maps.',
            'tech_stack' => 'PHP 8, MySQL, Tailwind CSS, AJAX',
            'live_url' => 'https://github.com/roky2k05',
            'github_url' => 'https://github.com/roky2k05',
            'is_featured' => 1,
            'created_at' => '2026-01-05 09:15:00',
        ],
    ];
}

