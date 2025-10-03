<?php
/**
 * home.php
 *
 * Purpose:
 * Acts as the entry point of the application.
 * It checks whether the user is authenticated (via session)
 * and redirects them to the appropriate page:
 *  - Dashboard (if logged in)
 *  - Login page (if not logged in)
 *
 * Flow:
 * - Session usage
 * - Authentication check
 * - Redirects using header()
 */

// ---------------------------------------------------
// Step 1: Start the session
// - Required to access session variables that track login state.
// ---------------------------------------------------
session_start();

// ---------------------------------------------------
// Step 2: Check authentication status
// - If a user_id exists in session → user is logged in.
// - Otherwise → user is not logged in.
// ---------------------------------------------------
if (isset($_SESSION['user_id'])) {
    // ---------------------------------------------------
    // Step 3a: Redirect authenticated users to dashboard
    // ---------------------------------------------------
    header("Location: dashboard.php");
} else {
    // ---------------------------------------------------
    // Step 3b: Redirect guests (unauthenticated users) to login
    // ---------------------------------------------------
    header("Location: login.php");
}

// ---------------------------------------------------
// Step 4: Exit after redirect
// - Prevents accidental execution of code after redirection.
// ---------------------------------------------------
exit;
