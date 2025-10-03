<?php
/**
 * Database Configuration File
 * 
 * Using require_once since database connection is critical
 * and should be included only once to prevent multiple connections
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'interview_test');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    /**
     * Using PDO for database connection with prepared statements
     * For a better security and error handling
     */
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    
    // Set PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Log error (in production) and show user-friendly message
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}
?>