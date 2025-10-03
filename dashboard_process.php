<?php
/**
 * Dashboard Page
 * 
 * Demonstrates:
 * - Session protection
 * - Data fetching from database
 * - Bootstrap tables
 * - XSS prevention in output
 */

// Include authentication check
require_once 'includes/auth_check.php';

require_once 'config/database.php';
include 'includes/header.php';

// Fetch user data for display
try {
    $stmt = $pdo->prepare("SELECT username, email, created_at FROM users ORDER BY created_at DESC");
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch(PDOException $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $users = [];
}
?>
