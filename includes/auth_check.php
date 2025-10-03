<?php
/**
 * Authentication Check File
 * 
 * Protects pages that require user to be logged in
 * Using require_once as this should be included only once per protected page
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>