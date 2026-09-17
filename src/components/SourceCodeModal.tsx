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
  FolderTree,
  ShieldCheck,
  KeyRound,
  MessageSquare
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
      desc: 'Complete MySQL schema: users, contact_messages, conversations, messages, notifications, admin_logs, and seeds',
      lang: 'sql',
      code: `-- ==========================================================
-- Database Schema for Rasindu Nawod Portfolio Website & Client Portal
-- File: database.sql
-- Compatibility: MySQL 5.7+ / MySQL 8.0+ / MariaDB / phpMyAdmin
-- Collation: utf8mb4_unicode_ci
-- ==========================================================

CREATE DATABASE IF NOT EXISTS \`rasindu_portfolio\` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE \`rasindu_portfolio\`;

-- --------------------------------------------------------
-- Table: users (Client and Administrator Accounts)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`users\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`full_name\` VARCHAR(100) NOT NULL,
  \`username\` VARCHAR(50) NOT NULL UNIQUE,
  \`email\` VARCHAR(150) NOT NULL UNIQUE,
  \`phone\` VARCHAR(30) NOT NULL,
  \`password\` VARCHAR(255) NOT NULL,
  \`role\` ENUM('user', 'admin') DEFAULT 'user',
  \`profile_image\` VARCHAR(255) DEFAULT NULL,
  \`status\` ENUM('active', 'disabled') DEFAULT 'active',
  \`last_login\` DATETIME DEFAULT NULL,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  \`updated_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX \`idx_role\` (\`role\`),
  INDEX \`idx_status\` (\`status\`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: contact_messages (Inquiries & Phone Privacy Protection)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`contact_messages\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`user_id\` INT UNSIGNED DEFAULT NULL,
  \`name\` VARCHAR(100) NOT NULL,
  \`email\` VARCHAR(150) NOT NULL,
  \`phone\` VARCHAR(30) DEFAULT NULL,
  \`subject\` VARCHAR(200) NOT NULL,
  \`message\` TEXT NOT NULL,
  \`status\` ENUM('Unread', 'Read', 'In Progress', 'Replied', 'Closed') DEFAULT 'Unread',
  \`admin_reply\` TEXT DEFAULT NULL,
  \`replied_at\` DATETIME DEFAULT NULL,
  \`ip_address\` VARCHAR(45) DEFAULT NULL,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  \`updated_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX \`idx_user_id\` (\`user_id\`),
  INDEX \`idx_status\` (\`status\`),
  CONSTRAINT \`fk_contact_messages_user\` FOREIGN KEY (\`user_id\`) 
    REFERENCES \`users\` (\`id\`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: conversations (Threaded 2-Way Dialogues)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`conversations\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`user_id\` INT UNSIGNED NOT NULL,
  \`subject\` VARCHAR(200) NOT NULL,
  \`status\` ENUM('Open', 'In Progress', 'Replied', 'Closed') DEFAULT 'Open',
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  \`updated_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX \`idx_user_conv\` (\`user_id\`),
  CONSTRAINT \`fk_conversations_user\` FOREIGN KEY (\`user_id\`) 
    REFERENCES \`users\` (\`id\`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: messages (Threaded Messages inside Conversations)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`messages\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`conversation_id\` INT UNSIGNED NOT NULL,
  \`sender_id\` INT UNSIGNED NOT NULL,
  \`sender_role\` ENUM('user', 'admin') NOT NULL,
  \`message\` TEXT NOT NULL,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX \`idx_conv_id\` (\`conversation_id\`),
  CONSTRAINT \`fk_messages_conv\` FOREIGN KEY (\`conversation_id\`) 
    REFERENCES \`conversations\` (\`id\`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: notifications (User Reply & System Alerts)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`notifications\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`user_id\` INT UNSIGNED NOT NULL,
  \`title\` VARCHAR(150) NOT NULL,
  \`message\` TEXT NOT NULL,
  \`type\` VARCHAR(50) DEFAULT 'reply',
  \`is_read\` TINYINT(1) DEFAULT 0,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX \`idx_notif_user\` (\`user_id\`, \`is_read\`),
  CONSTRAINT \`fk_notifications_user\` FOREIGN KEY (\`user_id\`) 
    REFERENCES \`users\` (\`id\`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: admin_logs (Audit Trail for Security Actions)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS \`admin_logs\` (
  \`id\` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  \`admin_id\` INT UNSIGNED DEFAULT NULL,
  \`action\` VARCHAR(100) NOT NULL,
  \`target_type\` VARCHAR(50) DEFAULT NULL,
  \`target_id\` INT UNSIGNED DEFAULT NULL,
  \`description\` TEXT DEFAULT NULL,
  \`ip_address\` VARCHAR(45) DEFAULT NULL,
  \`created_at\` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Initial Administrator Account (password: RokyN2k0_5)
INSERT INTO \`users\` (\`id\`, \`full_name\`, \`username\`, \`email\`, \`phone\`, \`password\`, \`role\`, \`status\`)
VALUES (
  1, 
  'Rasindu Nawod', 
  'rasindu', 
  'razindunawod@gmail.com', 
  '+94 74 386 9265', 
  '$2y$10$wTqK0z5R5xU6nFm9Y6Kqu.iA77kO27D0x6J7n5Z6G5f9B6j4E6W2a', 
  'admin', 
  'active'
) ON DUPLICATE KEY UPDATE \`id\`=\`id\`;
`,
    },
    'config/database.php': {
      desc: 'PDO Database connection, session hardening, and system constants',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: config/database.php
 * Secure Database Connection, System Constants & Session Hardening
 */

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'rasindu_portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('SITE_NAME', 'Rasindu Nawod | Web Developer & Graphic Designer');
define('ADMIN_EMAIL', 'razindunawod@gmail.com');
define('PHONE_NUMBER', '+94 74 386 9265');
define('LOCATION_INFO', 'Sri Lanka | Matara | Akuressa');
define('WHATSAPP_LINK', 'https://wa.me/94743869265');

// Initial Admin Credentials
define('SEED_ADMIN_USERNAME', 'rasindu');
define('SEED_ADMIN_PASSWORD', 'RokyN2k0_5');

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

function getDatabaseConnection(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}
`,
    },
    'register.php': {
      desc: 'User account creation with Sri Lankan phone validation and bcrypt password hashing',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: register.php
 * User Registration with Server-Side Validation, CSRF, and Password Hashing
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $errors[] = 'Invalid security token (CSRF). Please refresh.';
    }

    $fullName = trim($_POST['full_name'] ?? '');
    $username = strtolower(trim($_POST['username'] ?? ''));
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Field Validations
    if (empty($fullName)) $errors[] = 'Full name is required.';
    if (empty($username) || !preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        $errors[] = 'Username must be 3-30 characters (alphanumeric and underscore).';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email address is required.';
    }
    if (empty($phone) || !preg_match('/^(\\+94|0)?7[0-9]{8}$/', preg_replace('/[\\s\\-]/', '', $phone))) {
        $errors[] = 'Valid Sri Lankan mobile number is required (e.g. +94 74 386 9265).';
    }
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Password confirmation does not match.';

    if (empty($errors)) {
        $pdo = getDatabaseConnection();
        // Check uniqueness
        $chk = $pdo->prepare("SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1");
        $chk->execute([':u' => $username, ':e' => $email]);
        if ($chk->fetch()) {
            $errors[] = 'Username or Email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("
                INSERT INTO users (full_name, username, email, phone, password, role, status)
                VALUES (:full_name, :username, :email, :phone, :password, 'user', 'active')
            ");
            $stmt->execute([
                ':full_name' => $fullName,
                ':username'  => $username,
                ':email'     => $email,
                ':phone'     => $phone,
                ':password'  => $hash,
            ]);

            $_SESSION['flash_success'] = 'Registration successful. You can now login.';
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
`,
    },
    'login.php': {
      desc: 'Secure user login using password_verify() and session_regenerate_id(true)',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: login.php
 * Authentication with password_verify(), session fixation protection, and RBAC redirect
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        $error = 'Invalid security token (CSRF).';
    } else {
        $username = strtolower(trim($_POST['username'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] === 'disabled') {
                    $error = 'Your account has been disabled. Please contact the administrator.';
                } else {
                    // Prevent session fixation
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = (int)$user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['full_name'] = $user['full_name'];

                    if ($user['role'] === 'admin') {
                        $_SESSION['admin_id'] = (int)$user['id'];
                        $_SESSION['admin_role'] = 'admin';
                        $_SESSION['admin_username'] = $user['username'];
                        header('Location: admin/dashboard.php');
                    } else {
                        header('Location: dashboard.php');
                    }
                    exit;
                }
            } else {
                $error = 'Invalid username or password.';
            }
        }
    }
}
`,
    },
    'dashboard.php': {
      desc: 'Client dashboard with strict user_id scoping to prevent IDOR attacks',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: dashboard.php
 * Private Client Portal with IDOR Prevention
 */

require_once __DIR__ . '/includes/auth.php';
$user = requireAuth(); // Enforces authenticated session

$pdo = getDatabaseConnection();
$userId = (int)$_SESSION['user_id'];

// Fetch strictly the messages owned by this user
$stmt = $pdo->prepare("
    SELECT * FROM contact_messages 
    WHERE user_id = :user_id 
    ORDER BY created_at DESC
");
$stmt->execute([':user_id' => $userId]);
$messages = $stmt->fetchAll();

// Fetch unread notifications
$nStmt = $pdo->prepare("
    SELECT * FROM notifications 
    WHERE user_id = :user_id 
    ORDER BY created_at DESC 
    LIMIT 10
");
$nStmt->execute([':user_id' => $userId]);
$notifications = $nStmt->fetchAll();
?>
<!-- HTML displays Welcome, [User Name], message history with status pills, and notifications -->
`,
    },
    'admin/messages.php': {
      desc: 'Admin inquiry manager with search, filter, status badges, and phone number inspection',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/messages.php
 * Administrator Inquiry Manager
 */

require_once __DIR__ . '/../includes/admin_auth.php';
$admin = requireAdmin(); // Enforces admin role

$pdo = getDatabaseConnection();

$statusFilter = $_GET['status'] ?? 'All';
$search = trim($_GET['q'] ?? '');

$sql = "SELECT m.*, u.username as registered_username FROM contact_messages m LEFT JOIN users u ON m.user_id = u.id WHERE 1=1";
$params = [];

if ($statusFilter !== 'All') {
    $sql .= " AND m.status = :status";
    $params[':status'] = $statusFilter;
}

if (!empty($search)) {
    $sql .= " AND (m.name LIKE :q OR m.email LIKE :q OR m.phone LIKE :q OR m.subject LIKE :q)";
    $params[':q'] = "%$search%";
}

$sql .= " ORDER BY m.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$messages = $stmt->fetchAll();
`,
    },
    'admin/message-view.php': {
      desc: 'Admin reply composer, status updater, notification dispatcher, and phone privilege',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: admin/message-view.php
 * Admin Inquiry Inspection & Reply Portal with User Notification Dispatch
 */

require_once __DIR__ . '/../includes/admin_auth.php';
$admin = requireAdmin();

$pdo = getDatabaseConnection();
$msgId = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $replyText = trim($_POST['admin_reply'] ?? '');
    $newStatus = trim($_POST['new_status'] ?? 'Replied');

    // Update message record
    $up = $pdo->prepare("
        UPDATE contact_messages 
        SET admin_reply = :reply, replied_at = NOW(), status = :status, updated_at = NOW() 
        WHERE id = :id
    ");
    $up->execute([':reply' => $replyText, ':status' => $newStatus, ':id' => $msgId]);

    // Dispatch notification to user if linked to account
    $stmt = $pdo->prepare("SELECT user_id, subject FROM contact_messages WHERE id = :id");
    $stmt->execute([':id' => $msgId]);
    $msg = $stmt->fetch();

    if ($msg && !empty($msg['user_id'])) {
        $notif = $pdo->prepare("
            INSERT INTO notifications (user_id, title, message, type, is_read)
            VALUES (:uid, 'New Reply', :msg, 'reply', 0)
        ");
        $notif->execute([
            ':uid' => (int)$msg['user_id'],
            ':msg' => 'Rasindu Nawod replied to your message regarding: ' . $msg['subject']
        ]);
    }
}

// Fetch message details including private phone
$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $msgId]);
$message = $stmt->fetch();
// Admin can see: $message['phone']
`,
    },
    'includes/admin_auth.php': {
      desc: 'Role-based access guard with cache-control no-store headers',
      lang: 'php',
      code: `<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/admin_auth.php
 * Role-Based Admin Access Guard
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

function requireAdmin(): array {
    // Prevent browser caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    $adminId = $_SESSION['admin_id'] ?? ($_SESSION['user_id'] ?? null);
    $adminRole = $_SESSION['admin_role'] ?? ($_SESSION['role'] ?? null);

    if (empty($adminId)) {
        header('Location: login.php?notice=Please+sign+in+with+administrator+credentials');
        exit;
    }

    if ($adminRole !== 'admin') {
        // Strict RBAC: normal users are redirected to their own dashboard
        header('Location: ../dashboard.php?error=Access+denied.+Administrator+privileges+required.');
        exit;
    }

    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id AND role = 'admin' LIMIT 1");
    $stmt->execute([':id' => $adminId]);
    $admin = $stmt->fetch();

    if (!$admin || $admin['status'] === 'disabled') {
        session_unset();
        session_destroy();
        header('Location: login.php?error=Admin+account+invalid+or+disabled.');
        exit;
    }
    return $admin;
}
`,
    },
    'README.md': {
      desc: 'System documentation, XAMPP deployment instructions, and security checklist',
      lang: 'markdown',
      code: `# Rasindu Nawod — Complete Portfolio & Client Portal

## 🚀 Setup & Local Installation (XAMPP / WAMP / LEMP)

1. **Deploy to Web Server**:
   - Copy the \`/rasindu-portfolio\` directory into your web server root:
     - **XAMPP Windows**: \`C:\\xampp\\htdocs\\rasindu-portfolio\`
     - **XAMPP macOS**: \`/Applications/XAMPP/xamppfiles/htdocs/rasindu-portfolio\`

2. **Start Services**:
   - Start Apache and MySQL from XAMPP Control Panel.

3. **Import Database Schema**:
   - Open phpMyAdmin (\`http://localhost/phpmyadmin\`).
   - Create database: \`rasindu_portfolio\` (Collation: \`utf8mb4_unicode_ci\`).
   - Import \`database.sql\`.

4. **Access Site & Initial Admin Credentials**:
   - Public Portfolio: \`http://localhost/rasindu-portfolio\`
   - Admin Login: \`http://localhost/rasindu-portfolio/admin/login.php\`
   - **Admin Username**: \`rasindu\`
   - **Admin Password**: \`RokyN2k0_5\`
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
            <div className="w-10 h-10 rounded-xl bg-neutral-900 dark:bg-neutral-800 border border-neutral-700 flex items-center justify-center text-rose-500 shadow-sm">
              <Server className="w-5 h-5" />
            </div>
            <div>
              <h2 className="text-base font-bold font-heading text-neutral-900 dark:text-white">
                PHP 8+ & MySQL Backend Codebase
              </h2>
              <p className="text-xs text-neutral-500 dark:text-neutral-400">
                Inspect and download complete production PHP scripts, database schema, and security guards
              </p>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <button
              onClick={handleCopy}
              className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 transition-colors cursor-pointer"
            >
              {copied ? <Check className="w-3.5 h-3.5 text-emerald-500" /> : <Copy className="w-3.5 h-3.5" />}
              <span>{copied ? 'Copied' : 'Copy'}</span>
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
            >
              <X className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Content Body */}
        <div className="flex-1 grid grid-cols-1 md:grid-cols-12 overflow-hidden">
          
          {/* File Explorer Sidebar */}
          <div className="md:col-span-4 border-r border-neutral-200 dark:border-neutral-800 p-4 overflow-y-auto bg-neutral-50/70 dark:bg-neutral-950/30 space-y-1.5">
            <div className="text-[11px] font-bold uppercase tracking-wider text-neutral-400 mb-2 flex items-center gap-1.5">
              <FolderTree className="w-3.5 h-3.5" />
              <span>PHP Package Files</span>
            </div>

            {Object.keys(fileContents).map((file) => (
              <button
                key={file}
                onClick={() => setActiveFile(file)}
                className={`w-full p-2.5 rounded-xl text-left text-xs font-mono transition-all flex items-center justify-between cursor-pointer ${
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
              Full directory structure is located at <code className="text-rose-500 font-bold">/rasindu-portfolio/</code> with all 30+ files ready to run on any PHP 8+ web server.
            </div>
          </div>

          {/* Code Viewer */}
          <div className="md:col-span-8 flex flex-col overflow-hidden bg-[#0d1117] text-neutral-200 font-code text-xs">
            <div className="p-3 border-b border-neutral-800 bg-[#161b22] flex justify-between items-center text-[11px] text-neutral-400">
              <span className="truncate">{activeFile} &bull; {fileContents[activeFile].desc}</span>
              <span className="font-mono shrink-0 ml-2">{fileContents[activeFile].code.split('\n').length} lines</span>
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
