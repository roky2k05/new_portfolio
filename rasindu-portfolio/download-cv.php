<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: download-cv.php
 * Secure CV Download Handler
 */

$cvPath = __DIR__ . '/assets/cv/Rasindu-Nawod-CV.pdf';

if (file_exists($cvPath) && filesize($cvPath) > 0) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Rasindu-Nawod-CV.pdf"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($cvPath));
    readfile($cvPath);
    exit;
}

// If physical PDF has not been placed yet in /assets/cv/
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
    <div class="max-w-md w-full p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 text-center space-y-4 shadow-sm">
        <div class="w-14 h-14 rounded-2xl bg-rose-500/10 text-rose-500 border border-rose-500/20 mx-auto flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>

        <h1 class="text-xl font-bold font-heading text-neutral-900 dark:text-white">
            Curriculum Vitae Document
        </h1>

        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">
            Rasindu Nawod's full professional resume file is hosted under <code class="text-rose-500 bg-neutral-100 dark:bg-neutral-800 px-1.5 py-0.5 rounded">/assets/cv/Rasindu-Nawod-CV.pdf</code>.
        </p>

        <p class="text-xs text-neutral-500">
            For direct inquiries or to request an expedited copy of the CV, reach out directly:
        </p>

        <div class="pt-2 flex flex-col gap-2">
            <a 
                href="<?= WHATSAPP_LINK; ?>" 
                target="_blank"
                class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition-colors"
            >
                Request via WhatsApp (+94 74 386 9265)
            </a>
            <a 
                href="contact.php" 
                class="w-full py-2.5 px-4 rounded-xl border border-neutral-200 dark:border-neutral-800 text-neutral-700 dark:text-neutral-300 font-semibold text-xs hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
            >
                Send Direct Message
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
