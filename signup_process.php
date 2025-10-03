<?php

/**
 * Signup Page
 * 
 * Demonstrates:
 * - Form handling with POST method
 * - Password hashing
 * - PDO prepared statements (SQL injection prevention)
 * - XSS prevention with htmlspecialchars
 * - Bootstrap alerts for user feedback
 * - Duplicate username AND email validation
 */

// Include database configuration
require_once 'config/database.php';

// Include header
include 'includes/header.php';

// Initialize variables
$username = $email = '';
$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data to prevent XSS
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Server-side validation
    $valid = true;

    // Username validation
    if (empty($username) || strlen($username) < 3) {
        $error = "Username must be at least 3 characters long";
        $valid = false;
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "Username can only contain letters, numbers, and underscores";
        $valid = false;
    }

    // Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
        $valid = false;
    }

    // Password validation
    if (empty($password) || strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
        $valid = false;
    }

    // Password confirmation validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
        $valid = false;
    }

    // If validation passes, proceed with registration
    if ($valid) {
        try {
            // Check if username already exists using prepared statement
            $check_username_stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $check_username_stmt->execute([$username]);

            // Check if email already exists using prepared statement
            $check_email_stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check_email_stmt->execute([$email]);

            $username_exists = $check_username_stmt->rowCount() > 0;
            $email_exists = $check_email_stmt->rowCount() > 0;

            // Comprehensive duplicate checking
            if ($username_exists && $email_exists) {
                $error = "Both username and email address are already registered. Please choose different credentials.";
            } elseif ($username_exists) {
                $error = "Username already exists. Please choose a different username.";
            } elseif ($email_exists) {
                $error = "Email address is already registered. Please use a different email or try <a href='login.php' class='alert-link'>logging in</a>.";
            } else {
                // Hash password for security using bcrypt
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user using prepared statement (prevents SQL injection)
                $insert_stmt = $pdo->prepare(
                    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
                );

                if ($insert_stmt->execute([$username, $email, $hashed_password])) {
                    // Registration successful
                    $success = "Registration successful! You can now <a href='login.php' class='alert-link'>login to your account</a>.";
                    $username = $email = ''; // Clear form
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            error_log("Signup error: " . $e->getMessage());

            // Handle specific database errors
            if ($e->getCode() == 23000) { // MySQL duplicate entry error
                $error = "This username or email is already registered. Please try different credentials.";
            } else {
                $error = "Registration failed due to a system error. Please try again later.";
            }
        }
    }
}
?>