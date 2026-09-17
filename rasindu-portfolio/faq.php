<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: faq.php
 * Frequently Asked Questions (Development, Graphic Design & Collaboration)
 */

$pageTitle = 'Frequently Asked Questions';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$faqs = [
    [
        'q' => 'What services do you provide as a Web Developer and Graphic Designer?',
        'a' => 'I offer complete digital solutions: Full-stack custom web applications using PHP 8+ and MySQL, responsive frontend development using Tailwind CSS and modern JavaScript, and complete graphic design services including brand identity, vector logos with Adobe Illustrator, marketing banners with Photoshop, and interactive UI wireframing in Figma.',
    ],
    [
        'q' => 'What is your educational background?',
        'a' => 'I am pursuing my Higher National Diploma in Software Engineering at ICBT Campus in Sri Lanka. My academic training gives me deep grounding in algorithms, object-oriented design, database normalization, and secure web application development.',
    ],
    [
        'q' => 'How do you ensure web application security?',
        'a' => 'Every project I build enforces defense-in-depth principles: 100% parameterized queries via PDO prepared statements to stop SQL injection, cryptographic password hashing using Bcrypt, anti-CSRF token verification on all state-changing requests, HTML output sanitization against XSS, and strict server-side session ownership checks to prevent Insecure Direct Object Reference (IDOR) attacks.',
    ],
    [
        'q' => 'What formats do you provide for graphic design work?',
        'a' => 'For logos and brand assets, you receive full vector source files (Adobe Illustrator .AI, vector .EPS, and scalable .SVG) as well as high-resolution transparent PNGs and print-ready CMYK PDFs with 300 DPI.',
    ],
    [
        'q' => 'How long does a typical web development project take?',
        'a' => 'A custom responsive landing page or corporate showcase typically takes 1 to 2 weeks. Comprehensive full-stack database platforms (such as client portals, CMS dashboards, or inquiry trackers) usually range from 3 to 6 weeks depending on scope, testing, and revisions.',
    ],
    [
        'q' => 'How can I send you a project proposal or inquiry?',
        'a' => 'You can submit an inquiry directly through the Contact page on this website, send an email to rasindunawod2005@gmail.com, or reach me on WhatsApp at +94 72 057 5641. If you register an account, you can track your inquiries and receive direct message replies right inside your private client dashboard.',
    ],
];
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-4xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">
                Got Questions?
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Frequently Asked Questions
            </h1>
            <p class="text-xs sm:text-sm text-neutral-500">
                Clear answers regarding project workflows, technology stack, security practices, and collaboration.
            </p>
            <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto mt-3"></div>
        </div>

        <!-- FAQ Accordion / Cards List -->
        <div class="space-y-4">
            <?php foreach ($faqs as $i => $item): ?>
                <details class="group p-6 rounded-3xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs open:border-rose-500/50 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none select-none">
                        <h2 class="text-sm sm:text-base font-bold font-heading text-neutral-900 dark:text-white pr-4">
                            <?= sanitize($item['q']); ?>
                        </h2>
                        <span class="w-8 h-8 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 flex items-center justify-center shrink-0 group-open:rotate-180 transition-transform text-xs font-bold">
                            ↓
                        </span>
                    </summary>
                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed pt-4 border-t border-neutral-100 dark:border-neutral-800/80 mt-4">
                        <?= sanitize($item['a']); ?>
                    </p>
                </details>
            <?php endforeach; ?>
        </div>

        <!-- Still have questions? -->
        <div class="p-8 sm:p-10 rounded-3xl bg-neutral-900 text-white border border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div class="space-y-1">
                <h3 class="text-lg font-bold font-heading">Have a specific question not covered here?</h3>
                <p class="text-xs sm:text-sm text-neutral-400">
                    Reach out directly. I usually respond within a few hours.
                </p>
            </div>
            <a 
                href="contact.php" 
                class="px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-colors whitespace-nowrap shadow-xs"
            >
                Send Direct Inquiry
            </a>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
