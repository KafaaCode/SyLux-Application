// Auth Pages JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Form validation and enhancement
    const form = document.querySelector('form');
    const inputs = document.querySelectorAll('.form-input');
    const submitBtn = document.querySelector('.btn-primary');

    // Add loading state to submit button
    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'جاري التسجيل...';
        });
    }

    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearError);
    });

    // Password strength checker
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', checkPasswordStrength);
    }

    // Confirm password validation
    const confirmPasswordInput = document.getElementById('password_confirmation');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);
    }
});

function validateField(e) {
    const field = e.target;
    const value = field.value.trim();

    // Remove existing error styling
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    // Validate based on field type
    let isValid = true;
    let errorMessage = '';

    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'هذا الحقل مطلوب';
    } else if (field.type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'يرجى إدخال بريد إلكتروني صحيح';
    } else if (field.name === 'password' && value && value.length < 8) {
        isValid = false;
        errorMessage = 'كلمة المرور يجب أن تكون 8 أحرف على الأقل';
    } else if (field.name === 'password_confirmation' && value) {
        const password = document.getElementById('password').value;
        if (value !== password) {
            isValid = false;
            errorMessage = 'كلمة المرور غير متطابقة';
        }
    }

    if (!isValid) {
        field.classList.add('error');
        showError(field, errorMessage);
    }

    return isValid;
}

function clearError(e) {
    const field = e.target;
    field.classList.remove('error');
    const errorMessage = field.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

function showError(field, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function checkPasswordStrength(e) {
    const password = e.target.value;
    const strengthDiv = document.querySelector('.password-strength');

    if (!strengthDiv) {
        const strengthDiv = document.createElement('div');
        strengthDiv.className = 'password-strength';
        e.target.parentNode.appendChild(strengthDiv);
    }

    if (password.length === 0) {
        strengthDiv.textContent = '';
        return;
    }

    let strength = 0;
    let strengthText = '';

    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    if (strength < 3) {
        strengthDiv.textContent = 'كلمة مرور ضعيفة';
        strengthDiv.className = 'password-strength strength-weak';
    } else if (strength < 4) {
        strengthDiv.textContent = 'كلمة مرور متوسطة';
        strengthDiv.className = 'password-strength strength-medium';
    } else {
        strengthDiv.textContent = 'كلمة مرور قوية';
        strengthDiv.className = 'password-strength strength-strong';
    }
}

function validatePasswordMatch(e) {
    const confirmPassword = e.target.value;
    const password = document.getElementById('password').value;

    if (confirmPassword && password && confirmPassword !== password) {
        e.target.classList.add('error');
        showError(e.target, 'كلمة المرور غير متطابقة');
    } else {
        e.target.classList.remove('error');
        const errorMessage = e.target.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }
}

// Smooth animations
function addSmoothAnimations() {
    const container = document.querySelector('.auth-container');
    if (container) {
        container.style.opacity = '0';
        container.style.transform = 'translateY(30px)';

        setTimeout(() => {
            container.style.transition = 'all 0.6s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100);
    }
}

// Initialize animations
addSmoothAnimations();
