/**
 * Unified Client-side Form Validation System
 * 
 * Demonstrates:
 * - DOM element targeting and manipulation
 * - Form validation before submission
 * - Event listeners for real-time feedback
 * - DRY (Don't Repeat Yourself) principles
 * - Bootstrap validation integration
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
});

/**
 * Initialize all form validation systems
 */
function initializeFormValidation() {
    // Initialize Signup Form
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        initializeSignupValidation(signupForm);
    }

    // Initialize Login Form
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        initializeLoginValidation(loginForm);
    }
}

/**
 * Initialize Signup Form with real-time validation
 */
function initializeSignupValidation(signupForm) {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const passwordMatchMessage = document.getElementById('password-match-message');
    const submitBtn = signupForm.querySelector('button[type="submit"]');
    const spinner = submitBtn?.querySelector('.spinner-border');

    // Real-time validation event listeners
    if (password && confirmPassword) {
        password.addEventListener('input', checkPasswordMatch);
        confirmPassword.addEventListener('input', checkPasswordMatch);
    }

    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');

    if (usernameInput) {
        usernameInput.addEventListener('input', validateUsername);
    }

    if (emailInput) {
        emailInput.addEventListener('input', validateEmail);
    }

    // Form submission handler
    signupForm.addEventListener('submit', function(e) {
        if (!validateSignupForm()) {
            e.preventDefault();
        } else if (spinner) {
            // Show loading spinner
            spinner.classList.remove('d-none');
            submitBtn.disabled = true;
        }
    });

    /**
     * Real-time password match validation
     */
    function checkPasswordMatch() {
        if (!password || !confirmPassword || !passwordMatchMessage) return;

        const passwordValue = password.value;
        const confirmValue = confirmPassword.value;

        if (passwordValue && confirmValue) {
            if (passwordValue === confirmValue) {
                passwordMatchMessage.textContent = '✓ Passwords match';
                passwordMatchMessage.className = 'form-text text-success';
                confirmPassword.classList.remove('is-invalid');
                confirmPassword.classList.add('is-valid');
            } else {
                passwordMatchMessage.textContent = '✗ Passwords do not match';
                passwordMatchMessage.className = 'form-text text-danger';
                confirmPassword.classList.remove('is-valid');
                confirmPassword.classList.add('is-invalid');
            }
        } else {
            passwordMatchMessage.textContent = '';
            confirmPassword.classList.remove('is-valid', 'is-invalid');
        }
    }
}

/**
 * Initialize Login Form validation
 */
function initializeLoginValidation(loginForm) {
    loginForm.addEventListener('submit', function(e) {
        if (!validateLoginForm()) {
            e.preventDefault();
        }
    });
}

/**
 * Real-time username validation
 */
function validateUsername() {
    const username = this.value.trim();
    const usernameRegex = /^[a-zA-Z0-9_]{3,}$/;
    
    updateValidationState(this, usernameRegex.test(username));
}

/**
 * Real-time email validation
 */
function validateEmail() {
    const email = this.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    updateValidationState(this, emailRegex.test(email));
}

/**
 * Update Bootstrap validation classes for a field
 */
function updateValidationState(field, isValid) {
    if (field.value.length > 0) {
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        }
    } else {
        field.classList.remove('is-valid', 'is-invalid');
    }
}

/**
 * Validate Signup Form comprehensively
 */
function validateSignupForm() {
    const fields = [
        { id: 'username', validator: validateUsernameField },
        { id: 'email', validator: validateEmailField },
        { id: 'password', validator: validatePasswordField },
        { id: 'confirm_password', validator: validateConfirmPasswordField }
    ];

    let isValid = true;

    // Clear previous validation states
    clearValidationStates();

    // Validate each field
    fields.forEach(({ id, validator }) => {
        if (!validator(id)) {
            isValid = false;
        }
    });

    return isValid;
}

/**
 * Validate Login Form
 */
function validateLoginForm() {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    
    let isValid = true;
    
    clearValidationStates();
    
    if (!validateRequiredField(username, 'Username is required')) {
        isValid = false;
    }
    
    if (!validateRequiredField(password, 'Password is required')) {
        isValid = false;
    }
    
    return isValid;
}

/**
 * Individual field validators for signup form
 */
function validateUsernameField(fieldId) {
    const field = document.getElementById(fieldId);
    const value = field.value.trim();
    const usernameRegex = /^[a-zA-Z0-9_]{3,}$/;
    
    if (!validateRequiredField(field, 'Username is required')) {
        return false;
    }
    
    if (value.length < 3) {
        showError(fieldId, 'Username must be at least 3 characters');
        return false;
    }
    
    if (!usernameRegex.test(value)) {
        showError(fieldId, 'Username can only contain letters, numbers, and underscores');
        return false;
    }
    
    return true;
}

function validateEmailField(fieldId) {
    const field = document.getElementById(fieldId);
    const value = field.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!validateRequiredField(field, 'Email is required')) {
        return false;
    }
    
    if (!emailRegex.test(value)) {
        showError(fieldId, 'Please enter a valid email address');
        return false;
    }
    
    return true;
}

function validatePasswordField(fieldId) {
    const field = document.getElementById(fieldId);
    const value = field.value;
    
    if (!validateRequiredField(field, 'Password is required')) {
        return false;
    }
    
    if (value.length < 6) {
        showError(fieldId, 'Password must be at least 6 characters');
        return false;
    }
    
    return true;
}

function validateConfirmPasswordField(fieldId) {
    const field = document.getElementById(fieldId);
    const password = document.getElementById('password').value;
    const confirmValue = field.value;
    
    if (!validateRequiredField(field, 'Please confirm your password')) {
        return false;
    }
    
    if (password !== confirmValue) {
        showError(fieldId, 'Passwords do not match');
        return false;
    }
    
    return true;
}

/**
 * Utility function to validate required fields
 */
function validateRequiredField(field, errorMessage) {
    if (!field || field.value.trim() === '') {
        if (field) {
            showError(field.id, errorMessage);
        }
        return false;
    }
    return true;
}

/**
 * Show error message for a specific field
 */
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    // Remove existing error message
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    // Create and append new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    
    field.classList.add('is-invalid');
    field.parentNode.appendChild(errorDiv);
}

/**
 * Clear all validation states and error messages
 */
function clearValidationStates() {
    // Remove error messages
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());
    
    // Remove validation classes from all form fields
    const formFields = document.querySelectorAll('.form-control');
    formFields.forEach(field => {
        field.classList.remove('is-invalid', 'is-valid');
    });
}

/**
 * Clear specific field validation
 */
function clearFieldValidation(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    const errorMessage = field.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
    
    field.classList.remove('is-invalid', 'is-valid');
}