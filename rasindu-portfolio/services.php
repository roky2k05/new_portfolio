<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: services.php
 * Professional Services Breakdown & Project Inquiry Handlers
 */

$pageTitle = 'Services & Solutions';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$services = [
    [
        'id' => 'fullstack',
        'title' => 'Full-Stack Web Development',
        'subtitle' => 'Custom PHP 8+ & MySQL Applications',
        'description' => 'Architecting secure, database-driven web platforms tailored to client workflows. Includes user authentication, role-based dashboards, and audit-logged administrative panels.',
        'includes' => [
            'Object-Oriented PHP 8+ backends',
            'Relational MySQL schema design & PDO prepared statements',
            'Custom client & admin control panels',
            'Full CSRF, XSS, and SQL injection defense',
        ],
        'deliverables' => 'Production-ready web application, database schema script, and administrative handbook.',
        'badge' => 'Most Requested',
    ],
    [
        'id' => 'frontend',
        'title' => 'Frontend & Responsive Web Design',
        'subtitle' => 'Mobile-First Tailwind & JavaScript',
        'description' => 'Crafting pixel-perfect, accessible user interfaces that render flawlessly on smartphones, tablets, laptops, and ultra-wide desktop monitors.',
        'includes' => [
            'Tailwind CSS & vanilla CSS3 transitions',
            'Semantic HTML5 with SEO meta standards',
            'Interactive client-side JavaScript & AJAX calls',
            'Fast page speeds & lightweight assets',
        ],
        'deliverables' => 'Clean, modular frontend components with cross-browser compatibility.',
        'badge' => 'Core Focus',
    ],
    [
        'id' => 'branding',
        'title' => 'Graphic Design & Brand Identity',
        'subtitle' => 'Adobe Illustrator & Photoshop Systems',
        'description' => 'Designing recognizable brand aesthetics that convey trust and authority across print and digital mediums.',
        'includes' => [
            'Vector logos, marks, and monograms',
            'Custom typography hierarchies & color palettes',
            'Social media promotional banners & campaign graphics',
            'Print-ready flyers, business cards, and brochures',
        ],
        'deliverables' => 'High-resolution vector assets (SVG, EPS, PNG, PDF) with brand usage guidelines.',
        'badge' => 'Creative Suite',
    ],
    [
        'id' => 'uiux',
        'title' => 'UI/UX Prototyping & Wireframing',
        'subtitle' => 'Figma Interactive Mockups',
        'description' => 'Translating conceptual ideas into user-tested visual prototypes before writing a single line of production code.',
        'includes' => [
            'Low and high-fidelity wireframes',
            'Interactive clickable Figma user flows',
            'Design token systems & reusable component kits',
            'Mobile and desktop responsive variants',
        ],
        'deliverables' => 'Comprehensive Figma design file ready for direct developer handoff.',
        'badge' => 'Design Strategy',
    ],
    [
        'id' => 'redesign',
        'title' => 'Website Redesign & Security Hardening',
        'subtitle' => 'Modernizing Legacy Web Assets',
        'description' => 'Transforming outdated websites into secure, contemporary experiences with refreshed layouts and patched security vulnerabilities.',
        'includes' => [
            'Migration of legacy PHP code to modern PHP 8+',
            'Database restructuring & query indexing',
            'HTTPS enforcement & security audits',
            'Core Web Vitals speed optimization',
        ],
        'deliverables' => 'Optimized web architecture with measurable performance and security gains.',
        'badge' => 'Optimization',
    ],
    [
        'id' => 'maintenance',
        'title' => 'Maintenance & Retainer Support',
        'subtitle' => 'Ongoing Technical Partnership',
        'description' => 'Continuous technical support, data backups, feature enhancements, and emergency troubleshooting for active web properties.',
        'includes' => [
            'Scheduled database backups & health checks',
            'Feature expansions & content updates',
            'Rapid bug resolution & server monitoring',
            'Direct WhatsApp & priority ticket support',
        ],
        'deliverables' => 'Peace of mind with a dedicated developer on standby.',
        'badge' => 'Support',
    ],
];
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                What I Offer
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Services & Development Solutions
            </h1>
            <p class="text-xs sm:text-sm text-neutral-500">
                End-to-end design and engineering services from concept wireframing to production deployment.
            </p>
            <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto mt-3"></div>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <?php foreach ($services as $s): ?>
                <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs flex flex-col justify-between space-y-6 hover:border-rose-500/50 transition-colors">
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                <?= sanitize($s['badge']); ?>
                            </span>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold font-heading text-neutral-900 dark:text-white">
                                <?= sanitize($s['title']); ?>
                            </h2>
                            <p class="text-xs font-semibold text-rose-600 dark:text-rose-400 mt-0.5">
                                <?= sanitize($s['subtitle']); ?>
                            </p>
                        </div>

                        <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            <?= sanitize($s['description']); ?>
                        </p>

                        <!-- Includes list -->
                        <div class="space-y-2 pt-2 border-t border-neutral-100 dark:border-neutral-800/80">
                            <span class="text-[11px] font-bold text-neutral-700 dark:text-neutral-300 uppercase tracking-wider block">
                                Core Capabilities:
                            </span>
                            <ul class="space-y-1.5 text-xs text-neutral-600 dark:text-neutral-400">
                                <?php foreach ($s['includes'] as $inc): ?>
                                    <li class="flex items-start gap-2">
                                        <span class="text-rose-500 mt-0.5">✓</span>
                                        <span><?= sanitize($inc); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 space-y-3">
                        <div class="text-[11px] text-neutral-500">
                            <span class="font-semibold text-neutral-700 dark:text-neutral-300">Deliverable:</span> 
                            <?= sanitize($s['deliverables']); ?>
                        </div>

                        <a 
                            href="contact.php?subject=Inquiry:+<?= urlencode($s['title']); ?>" 
                            class="w-full flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl bg-neutral-900 hover:bg-rose-600 dark:bg-neutral-800 dark:hover:bg-rose-600 text-white text-xs font-semibold transition-colors shadow-xs"
                        >
                            <span>Request This Service</span>
                            <span>→</span>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <!-- Consultation Banner -->
        <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-r from-rose-900/40 to-neutral-900 border border-rose-500/30 text-white flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <h3 class="text-xl font-bold font-heading">Have a custom or unconventional requirement?</h3>
                <p class="text-xs sm:text-sm text-neutral-300 max-w-xl">
                    Every project is unique. Let's discuss your specific timeline, technology preferences, and budget to formulate a tailor-made proposal.
                </p>
            </div>
            <a 
                href="contact.php" 
                class="px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 font-semibold text-xs text-white shadow-md transition-colors whitespace-nowrap"
            >
                Start Free Consultation
            </a>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
