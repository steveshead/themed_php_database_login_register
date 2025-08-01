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

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.getElementById('passwordStrength');

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
            passwordStrength.style.backgroundColor = 'red';
        } else if (strength <= 4) {
            message = 'Medium';
            passwordStrength.style.backgroundColor = 'orange';
        } else {
            message = 'Strong';
            passwordStrength.style.backgroundColor = 'green';
        }

        passwordStrength.textContent = message;
    });
});