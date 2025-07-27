// Burger menus
document.addEventListener('DOMContentLoaded', function() {
    // open/close
    const toggler = document.querySelectorAll('[data-toggle="side-menu"]');

    if (toggler.length) {
        for (var i = 0; i < toggler.length; i++) {
            const target = toggler[i].getAttribute('data-target');

            if (target.length) {
                toggler[i].addEventListener('click', function(event) {
                    event.preventDefault();
                    const menu = document.querySelector(target);
        
                    if (menu) {
                        menu.classList.toggle('d-none');
                    }
                });
            }
        }
    }
});

// Password validation function
function validatePassword(password) {
    const errors = [];

    // Check length
    if (password.length < 8 || password.length > 20) {
        errors.push("Password must be between 8 and 20 characters long.");
    }

    // Check for uppercase letter
    if (!/[A-Z]/.test(password)) {
        errors.push("Password must contain at least one uppercase letter.");
    }

    // Check for lowercase letter
    if (!/[a-z]/.test(password)) {
        errors.push("Password must contain at least one lowercase letter.");
    }

    // Check for number
    if (!/[0-9]/.test(password)) {
        errors.push("Password must contain at least one number.");
    }

    // Check for special character
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        errors.push("Password must contain at least one special character (!@#$%^&*(),.?\":{}|<>).");
    }

    return errors;
}

// Password strength calculation function
function calculatePasswordStrength(password) {
    // If password is empty, return 0
    if (!password) return 0;

    let score = 0;

    // Length contribution (up to 25 points)
    if (password.length >= 8) score += 10;
    if (password.length >= 12) score += 10;
    if (password.length >= 16) score += 5;

    // Character variety contribution
    if (/[A-Z]/.test(password)) score += 10; // Uppercase
    if (/[a-z]/.test(password)) score += 10; // Lowercase
    if (/[0-9]/.test(password)) score += 10; // Numbers
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score += 15; // Special chars

    // Bonus for combination of character types
    let typesCount = 0;
    if (/[A-Z]/.test(password)) typesCount++;
    if (/[a-z]/.test(password)) typesCount++;
    if (/[0-9]/.test(password)) typesCount++;
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) typesCount++;

    if (typesCount >= 3) score += 10;
    if (typesCount === 4) score += 10;

    // Penalize for patterns
    if (/(.)\1\1/.test(password)) score -= 10; // Repeated characters
    if (/^[a-zA-Z]+$/.test(password)) score -= 10; // Letters only
    if (/^[0-9]+$/.test(password)) score -= 10; // Numbers only

    // Ensure score is between 0 and 100
    return Math.max(0, Math.min(100, score));
}

// Function to get strength label based on score
function getStrengthLabel(score) {
    if (score === 0) return { label: "None", color: "secondary" };
    if (score < 30) return { label: "Very Weak", color: "danger" };
    if (score < 50) return { label: "Weak", color: "warning" };
    if (score < 70) return { label: "Medium", color: "info" };
    if (score < 90) return { label: "Strong", color: "primary" };
    return { label: "Very Strong", color: "success" };
}

// Add event listener to password field
const passwordField = document.getElementById('password');
const msgDiv = document.querySelector('.msg');
const strengthBar = document.getElementById('password-strength-bar');
const strengthText = document.getElementById('password-strength-text').querySelector('span');

passwordField.addEventListener('input', function() {
    const password = this.value;
    const errors = validatePassword(password);

    // Update password strength meter
    const strengthScore = calculatePasswordStrength(password);
    const strengthInfo = getStrengthLabel(strengthScore);

    // Update the progress bar
    strengthBar.style.width = strengthScore + '%';
    strengthBar.setAttribute('aria-valuenow', strengthScore);

    // Remove all color classes and add the appropriate one
    strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success', 'bg-secondary');
    strengthBar.classList.add('bg-' + strengthInfo.color);

    // Update the strength text
    strengthText.textContent = strengthInfo.label;

    // Update requirements message
    if (password.length > 0) {
        if (errors.length > 0) {
            msgDiv.classList.remove('alert-success');
            msgDiv.classList.add('mt-2', 'alert', 'alert-danger');
            msgDiv.innerHTML = "<strong>Password Requirements:</strong><ul style='margin-bottom: 0; padding-left: 20px;'>" +
                errors.map(error => "<li>" + error + "</li>").join('') + "</ul>";
        } else {
            msgDiv.classList.remove('alert-danger');
            msgDiv.classList.add('mt-2', 'alert', 'alert-success');
            msgDiv.innerHTML = "Password meets all requirements!";
        }
    } else {
        msgDiv.innerHTML = "";
        msgDiv.classList.remove('mt-2', 'alert', 'alert-danger', 'alert-success');

        // Reset strength meter for empty password
        strengthBar.style.width = '0%';
        strengthBar.setAttribute('aria-valuenow', 0);
        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success');
        strengthBar.classList.add('bg-secondary');
        strengthText.textContent = "None";
    }
});

// AJAX code
const registrationForm = document.querySelector('.register-form');
registrationForm.onsubmit = event => {
    event.preventDefault();

    // Validate password before submission
    const password = passwordField.value;
    const errors = validatePassword(password);

    if (errors.length > 0) {
        msgDiv.classList.remove('alert-success');
        msgDiv.classList.add('mt-2', 'alert', 'alert-danger');
        msgDiv.innerHTML = "<strong>Please fix the following issues:</strong><ul style='margin-bottom: 0; padding-left: 20px;'>" +
            errors.map(error => "<li>" + error + "</li>").join('') + "</ul>";
        return;
    }

    fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm), cache: 'no-store' }).then(response => response.text()).then(result => {
        if (result.toLowerCase().includes('success:')) {
            registrationForm.querySelector('.msg').classList.remove('mt-2','alert','alert-danger','alert-success');
            registrationForm.querySelector('.msg').classList.add('mt-2','alert','alert-success');
            registrationForm.querySelector('.msg').innerHTML = result.replace('Success: ', '');
        } else if (result.toLowerCase().includes('redirect:')) {
            window.location.href = result.replace('Redirect:', '').trim();
        } else {
            registrationForm.querySelector('.msg').classList.remove('mt-2','alert','alert-danger','alert-success');
            registrationForm.querySelector('.msg').classList.add('mt-2','alert','alert-danger');
            registrationForm.querySelector('.msg').innerHTML = result.replace('Error: ', '');
        }
    });
};
