<?php require_once 'signup_process.php'; ?>
<div class="auth-container">
    <h2 class="text-center mb-4">Create Your Account</h2>
    <p class="text-center text-muted mb-4">Join our secure authentication system</p>

    <!-- Success Message -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form id="signupForm" method="POST" action="" novalidate>
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text"
                class="form-control <?php echo (isset($error) && (strpos($error, 'Username') !== false || strpos($error, 'username') !== false)) ? 'is-invalid' : ''; ?>"
                id="username"
                name="username"
                value="<?php echo htmlspecialchars($username); ?>"
                required
                minlength="3"
                pattern="[a-zA-Z0-9_]+"
                title="Username must be at least 3 characters and contain only letters, numbers, and underscores">
            <div class="form-text">3+ characters, letters, numbers, and underscores only</div>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email"
                class="form-control <?php echo (isset($error) && (strpos($error, 'Email') !== false || strpos($error, 'email') !== false)) ? 'is-invalid' : ''; ?>"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars($email); ?>"
                required>
            <div class="form-text">We'll never share your email with anyone else</div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password"
                class="form-control"
                id="password"
                name="password"
                required
                minlength="6">
            <div class="form-text">Minimum 6 characters</div>
        </div>

        <div class="form-group">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password"
                class="form-control"
                id="confirm_password"
                name="confirm_password"
                required
                minlength="6">
        </div>

        <!-- Password Match Indicator -->
        <div class="mb-3">
            <small id="password-match-message" class="form-text"></small>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
            Create Account
        </button>
    </form>

    <div class="text-center mt-4">
        <p class="mb-0">Already have an account?
            <a href="login.php" class="text-decoration-none fw-semibold">Sign in here</a>
        </p>
    </div>
</div>



<?php include 'includes/footer.php'; ?>