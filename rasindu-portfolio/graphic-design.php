<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: graphic-design.php
 * Visual Arts, Graphic Design, Brand Identity & Vector Illustration Showcase
 */

$pageTitle = 'Graphic Design & Visual Arts';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$designCategories = [
    [
        'title' => 'Brand Identity & Logotypes',
        'desc' => 'Distinctive vector monograms, corporate visual marks, and complete brand identity guidelines.',
        'tools' => 'Adobe Illustrator, Figma',
        'items' => [
            ['title' => 'Ceylon Heritage Tea Emblem', 'type' => 'Vector Mark', 'client' => 'Exports Brand'],
            ['title' => 'Apex Cloud Tech Monogram', 'type' => 'Tech Logo', 'client' => 'SaaS Startup'],
            ['title' => 'Southern Waves Eco Resort', 'type' => 'Hospitality Identity', 'client' => 'Tourism Client'],
        ],
    ],
    [
        'title' => 'Social Media & Campaign Creatives',
        'desc' => 'High-conversion advertising banners, Instagram carousels, and promotional social collateral.',
        'tools' => 'Adobe Photoshop, Illustrator',
        'items' => [
            ['title' => 'Black Friday Tech Launch Carousel', 'type' => 'Ad Campaign', 'client' => 'Retail Electronics'],
            ['title' => 'Youth Leadership Summit Banner', 'type' => 'Event Creative', 'client' => 'Community Initiative'],
            ['title' => 'Organic Matcha Seasonal Promo', 'type' => 'Product Banner', 'client' => 'E-Commerce Store'],
        ],
    ],
    [
        'title' => 'Poster, Typography & Print Design',
        'desc' => 'Editorial layout balance, expressive typography pairings, and print-ready CMYK collateral.',
        'tools' => 'Adobe InDesign, Photoshop',
        'items' => [
            ['title' => 'Minimalist Typography Poster Series', 'type' => 'Art Print', 'client' => 'Personal Exploration'],
            ['title' => 'Annual Corporate Report Cover', 'type' => 'Print Publication', 'client' => 'Financial Agency'],
            ['title' => 'Matara Music Festival Poster', 'type' => 'Event Collateral', 'client' => 'Cultural Committee'],
        ],
    ],
    [
        'title' => 'UI Mockups & Design Systems',
        'desc' => 'Clean design token palettes, accessible contrast ratios, and component libraries.',
        'tools' => 'Figma, Adobe XD',
        'items' => [
            ['title' => 'FinTrack Mobile Banking UI Kit', 'type' => 'Design System', 'client' => 'Fintech App'],
            ['title' => 'SaaS Analytics Dashboard Dark Mode', 'type' => 'Desktop UI', 'client' => 'Enterprise Platform'],
            ['title' => 'Eco-Travel Booking Flow', 'type' => 'Mobile UX', 'client' => 'Travel Portal'],
        ],
    ],
];
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                Visual Artistry
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Graphic Design & Brand Systems
            </h1>
            <p class="text-xs sm:text-sm text-neutral-500">
                Creative visual design crafted using Adobe Creative Cloud and Figma suites.
            </p>
            <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto mt-3"></div>
        </div>

        <!-- Software Toolchain Ribbon -->
        <div class="p-6 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs flex flex-wrap items-center justify-around gap-6 text-center">
            <div>
                <span class="block text-lg font-bold font-heading text-neutral-900 dark:text-white">Adobe Illustrator</span>
                <span class="text-xs text-neutral-500">Logos & Vectors</span>
            </div>
            <div class="hidden sm:block w-px h-8 bg-neutral-200 dark:bg-neutral-800"></div>
            <div>
                <span class="block text-lg font-bold font-heading text-neutral-900 dark:text-white">Adobe Photoshop</span>
                <span class="text-xs text-neutral-500">Compositing & Retouching</span>
            </div>
            <div class="hidden sm:block w-px h-8 bg-neutral-200 dark:bg-neutral-800"></div>
            <div>
                <span class="block text-lg font-bold font-heading text-neutral-900 dark:text-white">Figma</span>
                <span class="text-xs text-neutral-500">UI/UX & Tokens</span>
            </div>
            <div class="hidden sm:block w-px h-8 bg-neutral-200 dark:bg-neutral-800"></div>
            <div>
                <span class="block text-lg font-bold font-heading text-neutral-900 dark:text-white">Premiere Pro</span>
                <span class="text-xs text-neutral-500">Motion & Video</span>
            </div>
        </div>

        <!-- Categories and Works Grid -->
        <div class="space-y-12">
            <?php foreach ($designCategories as $cat): ?>
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-neutral-200 dark:border-neutral-800 pb-3">
                        <div>
                            <h2 class="text-xl font-bold font-heading text-neutral-900 dark:text-white">
                                <?= sanitize($cat['title']); ?>
                            </h2>
                            <p class="text-xs text-neutral-500 mt-0.5">
                                <?= sanitize($cat['desc']); ?>
                            </p>
                        </div>
                        <span class="text-[11px] font-mono text-rose-600 dark:text-rose-400 font-semibold self-start sm:self-auto">
                            Tools: <?= sanitize($cat['tools']); ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($cat['items'] as $item): ?>
                            <div class="p-6 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-4 hover:border-rose-500/50 transition-colors flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="w-full h-36 rounded-2xl bg-gradient-to-tr from-neutral-900 to-neutral-800 flex items-center justify-center text-neutral-400 p-4 relative overflow-hidden">
                                        <div class="text-center">
                                            <span class="text-xs font-mono uppercase tracking-widest text-rose-400 font-bold block">
                                                <?= sanitize($item['type']); ?>
                                            </span>
                                            <span class="text-[11px] text-neutral-300">Design Asset</span>
                                        </div>
                                    </div>

                                    <h3 class="text-sm font-bold font-heading text-neutral-900 dark:text-white">
                                        <?= sanitize($item['title']); ?>
                                    </h3>
                                    <p class="text-xs text-neutral-500">
                                        Client: <span class="text-neutral-700 dark:text-neutral-300"><?= sanitize($item['client']); ?></span>
                                    </p>
                                </div>

                                <a 
                                    href="contact.php?subject=Graphic+Design+Inquiry:+<?= urlencode($item['title']); ?>" 
                                    class="text-xs font-semibold text-rose-600 dark:text-rose-400 hover:underline pt-2 border-t border-neutral-100 dark:border-neutral-800/80 flex items-center justify-between"
                                >
                                    <span>Request Similar Design</span>
                                    <span>→</span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Custom Graphic Design Request CTA -->
        <div class="p-8 sm:p-10 rounded-3xl bg-neutral-900 text-white border border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center sm:text-left">
                <h3 class="text-xl font-bold font-heading">Need a custom logo, social package, or brand redesign?</h3>
                <p class="text-xs sm:text-sm text-neutral-400">
                    Get fast turnarounds with vector source files (AI, EPS, SVG, PNG) ready for print or web use.
                </p>
            </div>
            <a 
                href="contact.php?subject=Graphic+Design+Package+Inquiry" 
                class="px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 font-semibold text-xs text-white shadow-md transition-colors whitespace-nowrap"
            >
                Order Design Package
            </a>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
