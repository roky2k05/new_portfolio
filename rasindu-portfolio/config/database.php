<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: config/database.php
 * Secure Database Connection, System Constants & Session Hardening
 */

// Database Credentials (Update for production hosting if different from standard XAMPP)
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'rasindu_portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Profile & Contact Constants
define('SITE_NAME', 'Rasindu Nawod | Web Developer & Graphic Designer');
define('ADMIN_EMAIL', 'razindunawod@gmail.com');
define('PHONE_NUMBER', '+94 74 386 9265');
define('LOCATION_INFO', 'Sri Lanka | Matara | Akuressa');
define('WHATSAPP_LINK', 'https://wa.me/94743869265');

// Initial Admin Credentials (Used for automatic database seeding if not yet created)
define('SEED_ADMIN_USERNAME', 'rasindu');
define('SEED_ADMIN_PASSWORD', 'RokyN2k0_5');

// Session security setup
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

/**
 * Establish Database Connection using PDO
 * @return PDO
 */
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

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            autoSeedAdminAccount($pdo);
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Database connection failed. Please ensure MySQL is running in XAMPP and database.sql is imported.'
                ]);
                exit;
            } else {
                die("<h1>Database Connection Failed</h1><p>Please check your config/database.php settings and ensure MySQL is running in XAMPP. Error: " . htmlspecialchars($e->getMessage()) . "</p>");
            }
        }
    }

    return $pdo;
}

/**
 * Automatically ensure the primary admin account exists in the database
 */
function autoSeedAdminAccount(PDO $pdo): void {
    try {
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE username = :u LIMIT 1");
        $checkStmt->execute([':u' => SEED_ADMIN_USERNAME]);
        if (!$checkStmt->fetch()) {
            $hash = password_hash(SEED_ADMIN_PASSWORD, PASSWORD_BCRYPT);
            $insert = $pdo->prepare("
                INSERT INTO users (full_name, username, email, phone, password, role, status)
                VALUES ('Rasindu Nawod', :u, :email, :phone, :pass, 'admin', 'active')
            ");
            $insert->execute([
                ':u'     => SEED_ADMIN_USERNAME,
                ':email' => ADMIN_EMAIL,
                ':phone' => PHONE_NUMBER,
                ':pass'  => $hash,
            ]);
        }
    } catch (Exception $e) {
        // Table may not yet be imported, suppress to allow installer/importer to run
    }
}
