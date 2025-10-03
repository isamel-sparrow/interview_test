<?php
/**
 * logout.php
 *
 * Purpose:
 * Safely log out a user by destroying their session and removing
 * any associated session cookies, then redirect them to the login page.
 *
 * - Secure session destruction
 * - Unsetting session variables
 * - Deleting session cookies
 * - Redirecting to a login page
 *
 * Best Practices:
 * - Always clear session data both server-side and client-side (cookie).
 * - Redirect users after logout to avoid re-submission of session info.
 */

// ---------------------------------------------------
// Step 1: Start or resume the session
// ---------------------------------------------------
session_start();  

// ---------------------------------------------------
// Step 2: Unset all session variables
// This clears any stored user data (e.g., user_id, role, etc.).
// ---------------------------------------------------
$_SESSION = [];  

// ---------------------------------------------------
// Step 3: Destroy the session data on the server
// ---------------------------------------------------
session_destroy();  

// ---------------------------------------------------
// Step 4: Delete the session cookie from the browser
// - Some browsers may still hold a session cookie, so explicitly clear it.
// - session_get_cookie_params() retrieves the same parameters
//   used when the session cookie was created.
// ---------------------------------------------------
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),   // Name of the session cookie
        '',               // Empty value
        time() - 42000,   // Expired in the past
        $params["path"],  // Original path
        $params["domain"],// Original domain
        $params["secure"],// If HTTPS-only
        $params["httponly"] // Prevent JavaScript access
    );
}

// ---------------------------------------------------
// Step 5: Redirect to login page
// - After logging out, user should be redirected to login page.
// - Using 'exit;' ensures no further code runs after redirect.
// ---------------------------------------------------
header("Location: login.php");
exit;
