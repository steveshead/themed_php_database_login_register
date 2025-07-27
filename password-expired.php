<?php
include 'main.php';
// Make sure $pdo is accessible
global $pdo;
$page_title = 'Password Expired';
$page = 'No Header';
require_once 'header.php';

// Check if user is logged in with a temporary session for password change
if (!isset($_SESSION['password_expired_id'])) {
    // If not, redirect to login page
    header('Location: login.php');
    exit;
}

// Get the account ID from the session
$account_id = $_SESSION['password_expired_id'];

// Process form submission
if (isset($_POST['password'], $_POST['cpassword'])) {
    // Validate the password
    if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8) {
        $error_msg = 'Password must be between 8 and 20 characters long!';
    } else if (!preg_match('/[A-Z]/', $_POST['password'])) {
        $error_msg = 'Password must contain at least one uppercase letter!';
    } else if (!preg_match('/[a-z]/', $_POST['password'])) {
        $error_msg = 'Password must contain at least one lowercase letter!';
    } else if (!preg_match('/[0-9]/', $_POST['password'])) {
        $error_msg = 'Password must contain at least one number!';
    } else if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $_POST['password'])) {
        $error_msg = 'Password must contain at least one special character (!@#$%^&*(),.?":{}|<>)!';
    } else if ($_POST['password'] != $_POST['cpassword']) {
        $error_msg = 'Passwords do not match!';
    } else {
        // Hash the new password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Update the password and password_changed date in the database
        $date = date('Y-m-d\TH:i:s');
        $stmt = $pdo->prepare('UPDATE accounts SET password = ?, password_changed = ? WHERE id = ?');
        $stmt->execute([$password, $date, $account_id]);

        // Get the account details
        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
        $stmt->execute([$account_id]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set up the session for the user
        session_regenerate_id();
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_name'] = $account['username'];
        $_SESSION['first_name'] = $account['first_name'];
        $_SESSION['last_name'] = $account['last_name'];
        $_SESSION['account_id'] = $account['id'];
        $_SESSION['account_role'] = $account['role'];
        $_SESSION['avatar'] = $account['avatar'];
        $_SESSION['facebook'] = $account['facebook'];
        $_SESSION['instagram'] = $account['instagram'];
        $_SESSION['twitter'] = $account['twitter'];

        // Set the last activity timestamp for session timeout tracking
        $_SESSION['last_activity'] = time();

        // Remove the password_expired_id from the session
        unset($_SESSION['password_expired_id']);

        // Update last seen date
        $stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
        $stmt->execute([$date, $account['id']]);

        // Redirect to the home page
        header('Location: index.php?password_updated=1');
        exit;
    }
}
?>

<section class="py-5">
    <div class="container pb-5">
        <div class="row pt-4">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="mb-4 text-center">Password Expired</h2>
                        <p class="text-center mb-4">Your password has expired and needs to be changed for security reasons.</p>

                        <?php if (isset($error_msg)): ?>
                            <div class="alert alert-danger"><?= $error_msg ?></div>
                        <?php endif; ?>

                        <form action="password-expired.php" method="post">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <div class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="form-text">Password must be between 8 and 20 characters, include uppercase and lowercase letters, numbers, and special characters.</div>
                            </div>

                            <div class="mb-3">
                                <div class="password-strength-meter">
                                    <div class="progress" style="height: 8px;">
                                        <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div id="password-strength-text" class="mt-1 small text-muted">Password strength: <span>None</span></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="cpassword" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="cpassword" id="cpassword" required>
                                    <div class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
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
const strengthBar = document.getElementById('password-strength-bar');
const strengthText = document.getElementById('password-strength-text').querySelector('span');

passwordField.addEventListener('input', function() {
    const password = this.value;

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

    if (!password) {
        // Reset strength meter for empty password
        strengthBar.style.width = '0%';
        strengthBar.setAttribute('aria-valuenow', 0);
        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success');
        strengthBar.classList.add('bg-secondary');
        strengthText.textContent = "None";
    }
});
</script>

<?php require 'footer.php'; ?>
