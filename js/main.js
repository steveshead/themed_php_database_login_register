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

// show password complexity indicator
document.addEventListener('DOMContentLoaded', function() {
    // Look for either password field
    const passwordInput = document.getElementById('password') || document.getElementById('npassword');
    const passwordStrength = document.getElementById('passwordStrength');

    // Only proceed if we found a password field
    if (passwordInput && passwordStrength) {
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            let strength = 0;
            let message = '';

            // Check for length
            if (password.length >= 8) {
                strength += 1;
            }

            // Check for uppercase letters
            if (/[A-Z]/.test(password)) {
                strength += 1;
            }

            // Check for lowercase letters
            if (/[a-z]/.test(password)) {
                strength += 1;
            }

            // Check for numbers
            if (/[0-9]/.test(password)) {
                strength += 1;
            }

            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 1;
            }

            // Determine strength message and styling
            if (password.length === 0) {
                message = '';
                passwordStrength.style.backgroundColor = 'transparent';
            } else if (strength <= 2) {
                message = 'Weak';
                passwordStrength.style.backgroundColor = 'rgba(220,53,69)';
            } else if (strength <= 4) {
                message = 'Medium';
                passwordStrength.style.backgroundColor = 'rgba(255,193,7)';
            } else {
                message = 'Strong';
                passwordStrength.style.backgroundColor = 'rgba(25,135,84)';
            }

            passwordStrength.textContent = message;
        });
    }
});

function showHideStrength() {
    const password1 = document.getElementById('password');
    const password2 = document.getElementById('npassword');
    const strengthDiv = document.getElementById('passwordStrength');

    // Check if either field has text
    const hasText = (password1 && password1.value.length > 0) ||
        (password2 && password2.value.length > 0);

    // Show or hide the div
    if (hasText) {
        strengthDiv.style.display = 'block';
    } else {
        strengthDiv.style.display = 'none';
    }
}

// Connect the function to both password fields
// Only add event listener if the element exists
const passwordField = document.getElementById('password');
const nPasswordField = document.getElementById('npassword');

if (passwordField) {
    passwordField.addEventListener('input', showHideStrength);
}

if (nPasswordField) {
    nPasswordField.addEventListener('input', showHideStrength);
}