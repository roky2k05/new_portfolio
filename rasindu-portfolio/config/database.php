<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: config/database.php
 * Secure PDO Connection to MySQL Database
 */

// Database Credentials (Update as required for hosting environment)
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'rasindu_portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Profile & Contact Constants
define('SITE_NAME', 'Rasindu Nawod | Web Developer & Graphic Designer');
define('ADMIN_EMAIL', 'razindunawod@gmail.com');
define('PHONE_NUMBER', '+94 74 123 4567');
define('LOCATION_INFO', 'Sri Lanka | Matara | Akuressa');
define('WHATSAPP_LINK', 'https://wa.me/94741234567');

/**
 * Establish Database Connection
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
                die("<h1>Database Connection Failed</h1><p>Please check your config/database.php settings and ensure MySQL is running in XAMPP.</p>");
            }
        }
    }

    return $pdo;
}
