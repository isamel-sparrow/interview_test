<?php require_once 'login_process.php'; ?>
<div class="auth-container">
    <h2 class="text-center mb-4">Login to Your Account</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form id="loginForm" method="POST" action="">
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    
    <div class="text-center mt-3">
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>