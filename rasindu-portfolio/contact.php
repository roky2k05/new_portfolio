<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: contact.php
 * Public Contact Page & Secure Message Processing Handler
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';

$isLoggedIn = !empty($_SESSION['user_id']);
$defaultName  = $_SESSION['full_name'] ?? '';
$defaultEmail = $_SESSION['email'] ?? '';
$defaultPhone = $_SESSION['phone'] ?? '';
$loggedInUserId = $isLoggedIn ? (int)$_SESSION['user_id'] : null;

$errors = [];
$successMessage = '';

// Handle POST Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if JSON request
    $isJson = (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) ||
              (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true);

    $name    = trim($jsonData['name'] ?? ($_POST['name'] ?? ''));
    $email   = trim($jsonData['email'] ?? ($_POST['email'] ?? ''));
    $phone   = trim($jsonData['phone'] ?? ($_POST['phone'] ?? ''));
    $subject = trim($jsonData['subject'] ?? ($_POST['subject'] ?? ''));
    $message = trim($jsonData['message'] ?? ($_POST['message'] ?? ''));
    $token   = $jsonData['csrf_token'] ?? ($_POST['csrf_token'] ?? '');

    if (!$isJson && !validateCsrfToken($token)) {
        $errors[] = 'Invalid security token (CSRF). Please refresh and try again.';
    }

    if (empty($name)) {
        $errors[] = 'Name is required.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    if (empty($phone)) {
        $errors[] = 'Phone / WhatsApp number is required.';
    }

    if (empty($subject)) {
        $errors[] = 'Subject is required.';
    }

    if (empty($message)) {
        $errors[] = 'Message content is required.';
    }

    if (empty($errors)) {
        try {
            $pdo = getDatabaseConnection();

            // Insert into contact_messages table
            $stmt = $pdo->prepare("
                INSERT INTO contact_messages (user_id, name, email, phone, subject, message, status, created_at)
                VALUES (:user_id, :name, :email, :phone, :subject, :message, 'Unread', NOW())
            ");
            $stmt->execute([
                ':user_id' => $loggedInUserId,
                ':name'    => $name,
                ':email'   => $email,
                ':phone'   => $phone,
                ':subject' => $subject,
                ':message' => $message,
            ]);
            $newMsgId = (int)$pdo->lastInsertId();

            // If user is logged in, also create conversation & message
            if ($loggedInUserId) {
                $cStmt = $pdo->prepare("
                    INSERT INTO conversations (user_id, subject, status, created_at)
                    VALUES (:uid, :sub, 'Unread', NOW())
                ");
                $cStmt->execute([
                    ':uid' => $loggedInUserId,
                    ':sub' => $subject,
                ]);
                $convId = (int)$pdo->lastInsertId();

                $mStmt = $pdo->prepare("
                    INSERT INTO messages (conversation_id, sender_id, sender_role, message, created_at)
                    VALUES (:cid, :sid, 'user', :msg, NOW())
                ");
                $mStmt->execute([
                    ':cid' => $convId,
                    ':sid' => $loggedInUserId,
                    ':msg' => $message,
                ]);
            }

            if ($isJson) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'success' => true,
                    'message' => 'Thank you! Your message has been sent to Rasindu Nawod.',
                    'id'      => $newMsgId,
                ]);
                exit;
            }

            $successMessage = 'Thank you! Your message has been successfully received. Rasindu will get back to you shortly.';
            // Reset form fields
            $subject = '';
            $message = '';

        } catch (PDOException $e) {
            error_log("Contact form error: " . $e->getMessage());
            if ($isJson) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error occurred. Please try again.']);
                exit;
            }
            $errors[] = 'A server error occurred while sending your message. Please reach out via WhatsApp.';
        }
    } else {
        if ($isJson) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
            exit;
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-neutral-50/50 dark:bg-[#0b0d13]">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20 uppercase tracking-wider">
                Direct Contact
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Let's Discuss Your Project
            </h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                Whether you need a custom web application, an academic portal, or brand identity graphics, send a message to start the collaboration.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Contact Info & Channels -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="p-6 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-6">
                    <h2 class="text-base font-bold font-heading text-neutral-900 dark:text-white">
                        Direct Communication Channels
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm">
                        <div class="flex items-start gap-4">
                            <div class="p-3 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider">Phone & WhatsApp</span>
                                <a href="<?= WHATSAPP_LINK; ?>" class="font-semibold text-neutral-800 dark:text-neutral-200 hover:text-rose-600 transition-colors">
                                    <?= PHONE_NUMBER; ?>
                                </a>
                                <p class="text-[11px] text-neutral-500">Available 9:00 AM – 9:00 PM (IST)</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider">Email Address</span>
                                <a href="mailto:<?= ADMIN_EMAIL; ?>" class="font-semibold text-neutral-800 dark:text-neutral-200 hover:text-rose-600 transition-colors">
                                    <?= ADMIN_EMAIL; ?>
                                </a>
                                <p class="text-[11px] text-neutral-500">Inquiries answered within 24 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider">Base Location</span>
                                <span class="font-semibold text-neutral-800 dark:text-neutral-200">
                                    <?= LOCATION_INFO; ?>
                                </span>
                                <p class="text-[11px] text-neutral-500">Available for remote & local projects</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800">
                        <a 
                            href="<?= WHATSAPP_LINK; ?>" 
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition-colors shadow-xs"
                        >
                            <span>Chat Directly on WhatsApp</span>
                        </a>
                    </div>
                </div>

                <?php if (!$isLoggedIn): ?>
                    <div class="p-5 rounded-2xl bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 text-xs text-neutral-600 dark:text-neutral-300 space-y-2">
                        <div class="font-bold text-rose-600 dark:text-rose-400">Want real-time reply tracking?</div>
                        <p>
                            <a href="register.php" class="underline font-semibold text-rose-600 dark:text-rose-400">Create a client account</a> or <a href="login.php" class="underline font-semibold text-rose-600 dark:text-rose-400">sign in</a> to view status badges, reply directly, and retain a private conversation dashboard.
                        </p>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Contact Form Container -->
            <div class="lg:col-span-7">
                <div class="p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#121620] border border-neutral-200 dark:border-neutral-800 shadow-xs">
                    
                    <h2 class="text-lg font-bold font-heading text-neutral-900 dark:text-white mb-1">
                        Send a Message
                    </h2>
                    <p class="text-xs text-neutral-500 mb-6">
                        Fill out the form below. If you have an account, this inquiry will automatically appear in your dashboard.
                    </p>

                    <?php if (!empty($errors)): ?>
                        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs sm:text-sm space-y-1">
                            <?php foreach ($errors as $err): ?>
                                <div>• <?= sanitize($err); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($successMessage)): ?>
                        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm font-semibold">
                            ✓ <?= sanitize($successMessage); ?>
                            <?php if ($isLoggedIn): ?>
                                <div class="mt-2">
                                    <a href="messages.php" class="underline font-bold">Go to My Messages →</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="contact.php" method="POST" class="space-y-4">
                        <?= getCsrfInput(); ?>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                                    Your Name <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    required
                                    value="<?= sanitize($name ?? $defaultName); ?>"
                                    placeholder="e.g. Kaveen Jayawardena" 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                                    Email Address <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    required
                                    value="<?= sanitize($email ?? $defaultEmail); ?>"
                                    placeholder="name@example.com" 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                                    Phone / WhatsApp <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    id="phone" 
                                    required
                                    value="<?= sanitize($phone ?? $defaultPhone); ?>"
                                    placeholder="+94 7X XXX XXXX" 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                                >
                            </div>

                            <div>
                                <label for="subject" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                                    Subject <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="subject" 
                                    id="subject" 
                                    required
                                    value="<?= sanitize($subject ?? ''); ?>"
                                    placeholder="e.g. Modern Portfolio Website Inquiry" 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">
                                Message / Project Details <span class="text-rose-500">*</span>
                            </label>
                            <textarea 
                                name="message" 
                                id="message" 
                                rows="5" 
                                required
                                placeholder="Describe your project goals, scope, desired timeline, or any specific technologies..."
                                class="w-full px-3.5 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none transition-all"
                            ><?= sanitize($message ?? ''); ?></textarea>
                        </div>

                        <div class="pt-2 flex items-center justify-between">
                            <span class="text-[11px] text-neutral-400">
                                Protected with CSRF token & PDO prepared statements.
                            </span>
                            <button 
                                type="submit" 
                                class="px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs sm:text-sm shadow-xs transition-colors"
                            >
                                Send Message
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
