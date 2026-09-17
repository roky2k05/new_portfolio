<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/functions.php
 * Helper functions, security sanitization, and data queries
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Sanitize output string to prevent XSS
 */
function sanitize(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Fetch all projects from database or fallback to defaults
 */
function getProjects(string $category = 'All'): array {
    try {
        $pdo = getDatabaseConnection();
        if ($category === 'All') {
            $stmt = $pdo->query("SELECT * FROM projects ORDER BY id ASC");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM projects WHERE category = :cat ORDER BY id ASC");
            $stmt->execute([':cat' => $category]);
        }
        $results = $stmt->fetchAll();
        if (!empty($results)) {
            return $results;
        }
    } catch (Exception $e) {
        // Fallback gracefully if database table not yet populated
    }

    return [
        [
            'id' => 1,
            'title' => 'ICBT Campus Academic Portal & Website',
            'category' => 'Web Development',
            'description' => 'A comprehensive student and academic platform with responsive layouts and database integration.',
            'technologies' => 'HTML5, CSS3, JavaScript, PHP 8, MySQL',
            'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
            'github_url' => 'https://github.com/rasindunawod'
        ],
        [
            'id' => 2,
            'title' => 'Rasindu Nawod Personal Portfolio Website',
            'category' => 'Web Development',
            'description' => 'Fast, clean, responsive personal brand website featuring dark/light mode and quotation management.',
            'technologies' => 'HTML5, Tailwind CSS, JavaScript, PHP, MySQL',
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
            'github_url' => 'https://github.com/rasindunawod'
        ],
        [
            'id' => 3,
            'title' => 'Creative Brand Identity & Vector Design System',
            'category' => 'Graphic Design',
            'description' => 'A curated collection of vector logos, modern posters, and typographic experiments.',
            'technologies' => 'Adobe Illustrator, Adobe Photoshop',
            'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop',
            'github_url' => null
        ]
    ];
}

/**
 * Fetch all contact messages
 */
function getContactMessages(string $status = 'All'): array {
    try {
        $pdo = getDatabaseConnection();
        if ($status === 'All') {
            $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE status = :status ORDER BY created_at DESC");
            $stmt->execute([':status' => $status]);
        }
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}
