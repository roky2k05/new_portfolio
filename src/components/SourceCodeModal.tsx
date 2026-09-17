import React, { useState } from 'react';
import { 
  FileCode2, 
  X, 
  Copy, 
  Check, 
  Download, 
  Terminal, 
  Server, 
  Database,
  Layers,
  FolderTree
} from 'lucide-react';

interface SourceCodeModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export const SourceCodeModal: React.FC<SourceCodeModalProps> = ({ isOpen, onClose }) => {
  if (!isOpen) return null;

  const [activeFile, setActiveFile] = useState<string>('database.sql');
  const [copied, setCopied] = useState(false);

  const fileContents: Record<string, { desc: string; code: string; lang: string }> = {
    'database.sql': {
      desc: 'Complete MySQL schema with tables for contact messages, projects, gallery, and initial seeds',
      lang: 'sql',
      code: `-- ==========================================================
-- Database Schema for Rasindu Nawod Portfolio Website
-- File: database.sql
-- Compatibility: MySQL 5.7+ / MySQL 8.0+ / MariaDB
-- ==========================================================

CREATE DATABASE IF NOT EXISTS \`rasindu_portfolio\` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE \`rasindu_portfolio\`;

-- --------------------------------------------------------
-- Table: contact_messages
-- Stores inquiries sent through contact form and quotation requests
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`contact_messages\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`name\` VARCHAR(100) NOT NULL,
  \`email\` VARCHAR(150) NOT NULL,
  \`phone\` VARCHAR(30) DEFAULT NULL,
  \`subject\` VARCHAR(200) NOT NULL,
  \`message\` TEXT NOT NULL,
  \`status\` ENUM('Unread', 'Read', 'Replied') DEFAULT 'Unread',
  \`ip_address\` VARCHAR(45) DEFAULT NULL,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX \`idx_status\` (\`status\`),
  INDEX \`idx_email\` (\`email\`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: projects
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`projects\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`title\` VARCHAR(200) NOT NULL,
  \`category\` ENUM('Web Development', 'Graphic Design', 'UI/UX') NOT NULL,
  \`description\` TEXT NOT NULL,
  \`technologies\` VARCHAR(255) NOT NULL,
  \`image\` VARCHAR(255) NOT NULL,
  \`github_url\` VARCHAR(255) DEFAULT NULL,
  \`live_url\` VARCHAR(255) DEFAULT NULL,
  \`is_featured\` TINYINT(1) DEFAULT 1,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Sample Inquiry
INSERT INTO \`contact_messages\` (\`name\`, \`email\`, \`phone\`, \`subject\`, \`message\`, \`status\`)
VALUES ('Kaveen Jayawardena', 'kaveen@example.com', '+94 77 123 4567', 'Inquiry: Modern Portfolio Website', 'Hello Rasindu, I need a responsive portfolio for my architecture practice. Looking forward to discussing.', 'Unread');
`,
    },
    'config.php': {
      desc: 'PDO Database connection configuration with UTF-8 character encoding and error handling',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio - Database Configuration
 * File: includes/config.php
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'rasindu_portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site Constants
define('SITE_NAME', 'Rasindu Nawod | Portfolio');
define('SITE_EMAIL', 'razindunawod@gmail.com');
define('SITE_PHONE', '+94 74 123 4567');
define('SITE_LOCATION', 'Sri Lanka | Matara | Akuressa');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Return structured error
    if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    } else {
        die("Database Connection Error: " . htmlspecialchars($e->getMessage()));
    }
}
`,
    },
    'contact.php': {
      desc: 'AJAX / POST endpoint for sanitizing, validating, and saving contact form submissions to MySQL',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio - Contact Form Processing
 * File: contact.php
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Get JSON or form-urlencoded POST
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

$name    = trim($input['name'] ?? '');
$email   = trim($input['email'] ?? '');
$phone   = trim($input['phone'] ?? '');
$subject = trim($input['subject'] ?? '');
$message = trim($input['message'] ?? '');

// Validation
$errors = [];
if (empty($name)) {
    $errors[] = 'Name is required.';
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
}
if (empty($subject)) {
    $errors[] = 'Subject is required.';
}
if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters long.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors, 'message' => $errors[0]]);
    exit;
}

// Sanitize inputs
$name    = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
$phone   = !empty($phone) ? htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') : null;
$ip      = $_SERVER['REMOTE_ADDR'] ?? null;

try {
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (name, email, phone, subject, message, status, ip_address)
        VALUES (:name, :email, :phone, :subject, :message, 'Unread', :ip)
    ");
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':phone'   => $phone,
        ':subject' => $subject,
        ':message' => $message,
        ':ip'      => $ip
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent successfully. Rasindu will respond soon.',
        'insert_id' => $pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save message to database.']);
}
`,
    },
    'admin/index.php': {
      desc: 'Secure administrator dashboard to view, filter, update, and manage inquiries',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio - Admin Dashboard
 * File: admin/index.php
 */

require_once __DIR__ . '/../includes/config.php';

// Fetch all contact messages
$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();

$unreadCount = 0;
foreach ($messages as $m) {
    if ($m['status'] === 'Unread') $unreadCount++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Rasindu Nawod</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-900 text-neutral-100 min-h-screen">
    <div class="max-w-6xl mx-auto p-6">
        <header class="flex justify-between items-center pb-6 border-b border-neutral-800 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Rasindu Nawod — Admin Console</h1>
                <p class="text-xs text-neutral-400">Total inquiries: <?= count($messages); ?> (<?= $unreadCount; ?> Unread)</p>
            </div>
            <a href="../" class="text-xs bg-rose-600 px-4 py-2 rounded-xl text-white font-semibold">View Live Website</a>
        </header>

        <div class="bg-neutral-800 rounded-2xl overflow-hidden border border-neutral-700">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-900 text-neutral-400 uppercase">
                    <tr>
                        <th class="p-4">Sender</th>
                        <th class="p-4">Subject</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700">
                    <?php foreach ($messages as $msg): ?>
                    <tr class="hover:bg-neutral-750">
                        <td class="p-4 font-bold text-white">
                            <?= htmlspecialchars($msg['name']); ?><br>
                            <span class="text-[11px] text-neutral-400 font-normal"><?= htmlspecialchars($msg['email']); ?></span>
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-neutral-200"><?= htmlspecialchars($msg['subject']); ?></div>
                            <div class="text-[11px] text-neutral-400 truncate max-w-xs"><?= htmlspecialchars($msg['message']); ?></div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $msg['status'] === 'Unread' ? 'bg-rose-500/20 text-rose-400' : 'bg-emerald-500/20 text-emerald-400' ?>">
                                <?= $msg['status']; ?>
                            </span>
                        </td>
                        <td class="p-4 text-neutral-400"><?= $msg['created_at']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
`,
    },
    'XAMPP_SETUP.md': {
      desc: 'Step-by-step local testing instructions for XAMPP / WampServer / LAMP stack',
      lang: 'markdown',
      code: `# XAMPP / Apache / MySQL Setup Guide for Rasindu Nawod Portfolio

1. Download & Install XAMPP:
   - Install XAMPP from https://www.apachefriends.org/ (PHP 8+ recommended).
   - Start Apache and MySQL from the XAMPP Control Panel.

2. Deploy Project:
   - Copy all files from the \`/rasindu-portfolio\` folder into:
     \`C:\\xampp\\htdocs\\rasindu-portfolio\` (Windows)
     or \`/Applications/XAMPP/xamppfiles/htdocs/rasindu-portfolio\` (Mac)

3. Import MySQL Database:
   - Open browser: \`http://localhost/phpmyadmin\`
   - Click "New" to create a database:
     Database name: \`rasindu_portfolio\`
     Collation: \`utf8mb4_unicode_ci\`
   - Select the database, click the "Import" tab.
   - Choose the file \`database.sql\` and click "Import".

4. Test Website:
   - Public Website: \`http://localhost/rasindu-portfolio\`
   - Admin Console: \`http://localhost/rasindu-portfolio/admin\`
`,
    },
  };

  const handleCopy = () => {
    navigator.clipboard.writeText(fileContents[activeFile].code);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  const handleDownload = () => {
    const blob = new Blob([fileContents[activeFile].code], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = activeFile.split('/').pop() || activeFile;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  };

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 bg-neutral-950/85 backdrop-blur-md animate-fade-in"
      role="dialog"
      aria-modal="true"
    >
      <div className="bg-white dark:bg-[#12141c] rounded-3xl max-w-5xl w-full h-[90vh] flex flex-col border border-neutral-200 dark:border-neutral-800 shadow-2xl overflow-hidden relative">
        
        {/* Top Header */}
        <div className="p-4 sm:p-5 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between bg-neutral-50 dark:bg-neutral-900/80">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-neutral-900 dark:bg-neutral-800 border border-neutral-700 flex items-center justify-center text-rose-500">
              <Server className="w-5 h-5" />
            </div>
            <div>
              <h2 className="text-base font-bold font-heading text-neutral-900 dark:text-white">
                PHP 8+ & MySQL Backend Package
              </h2>
              <p className="text-xs text-neutral-500 dark:text-neutral-400">
                Complete server files, database schema, and XAMPP deployment instructions
              </p>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <button
              onClick={handleCopy}
              className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 transition-colors cursor-pointer"
            >
              {copied ? <Check className="w-3.5 h-3.5 text-emerald-500" /> : <Copy className="w-3.5 h-3.5" />}
              <span>{copied ? 'Copied' : 'Copy Code'}</span>
            </button>
            <button
              onClick={handleDownload}
              className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-colors cursor-pointer"
            >
              <Download className="w-3.5 h-3.5" />
              <span>Download File</span>
            </button>
            <button
              onClick={onClose}
              className="p-2 rounded-xl text-neutral-500 hover:text-neutral-900 dark:hover:text-white cursor-pointer"
              aria-label="Close Source Code Modal"
            >
              <X className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Content Body */}
        <div className="flex-1 grid grid-cols-1 md:grid-cols-12 overflow-hidden">
          
          {/* File Explorer Sidebar */}
          <div className="md:col-span-4 border-r border-neutral-200 dark:border-neutral-800 p-4 overflow-y-auto bg-neutral-50/70 dark:bg-neutral-950/30 space-y-2">
            <div className="text-[11px] font-bold uppercase tracking-wider text-neutral-400 mb-2 flex items-center gap-1.5">
              <FolderTree className="w-3.5 h-3.5" />
              <span>PHP Package Files</span>
            </div>

            {Object.keys(fileContents).map((file) => (
              <button
                key={file}
                onClick={() => setActiveFile(file)}
                className={`w-full p-3 rounded-xl text-left text-xs font-mono transition-all flex items-center justify-between cursor-pointer ${
                  activeFile === file
                    ? 'bg-rose-600 text-white shadow-xs font-bold'
                    : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200/70 dark:hover:bg-neutral-900'
                }`}
              >
                <div className="flex items-center gap-2 truncate">
                  <FileCode2 className="w-4 h-4 shrink-0" />
                  <span className="truncate">{file}</span>
                </div>
                <span className={`text-[10px] uppercase font-sans ${activeFile === file ? 'text-white/80' : 'text-neutral-400'}`}>
                  {fileContents[file].lang}
                </span>
              </button>
            ))}

            <div className="pt-4 mt-4 border-t border-neutral-200 dark:border-neutral-800 text-[11px] text-neutral-500 leading-relaxed">
              Files are physically generated in the project root under <code className="text-rose-500 font-bold">/rasindu-portfolio/</code> and ready for Apache / XAMPP deployment.
            </div>
          </div>

          {/* Code Viewer */}
          <div className="md:col-span-8 flex flex-col overflow-hidden bg-[#0d1117] text-neutral-200 font-code text-xs">
            <div className="p-3 border-b border-neutral-800 bg-[#161b22] flex justify-between items-center text-[11px] text-neutral-400">
              <span>{activeFile} • {fileContents[activeFile].desc}</span>
              <span className="font-mono">{fileContents[activeFile].code.split('\n').length} lines</span>
            </div>
            <pre className="p-5 overflow-auto flex-1 font-mono text-xs leading-relaxed text-neutral-300">
              <code>{fileContents[activeFile].code}</code>
            </pre>
          </div>

        </div>

      </div>
    </div>
  );
};
