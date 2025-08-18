<?php
$page_title = "Two-Factor Authentication Setup";
$page = '';
// Include the main.php file
include 'main.php';
// Check if user is logged in
check_loggedin($pdo);
// Include TOTP library
require_once 'lib/totp.php';
require_once 'header.php';

// Initialize variables
$msg = '';
$success_msg = '';
$qr_code_url = '';
$secret = '';
$show_qr = false;

// Get user account info
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
$stmt->execute([ $_SESSION['account_id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submissions
if (isset($_POST['action'])) {
    // Enable 2FA
    if ($_POST['action'] === 'enable' && (!isset($account['totp_enabled']) || !$account['totp_enabled'])) {
        // Generate a new secret key
        $secret = TOTP::generateSecret();

        // Store the secret in the database (not enabled yet)
        $stmt = $pdo->prepare('UPDATE accounts SET totp_secret = ? WHERE id = ?');
        $stmt->execute([ $secret, $_SESSION['account_id'] ]);

        // Generate QR code URL
        $issuer = urlencode(mail_name);
        $account_name = urlencode($account['email']);
        $qr_code_url = TOTP::getQRCodeUrl($issuer, $account_name, $secret);

        // Show QR code
        $show_qr = true;
    }
    // Verify and enable 2FA
    else if ($_POST['action'] === 'verify' && isset($_POST['code'])) {
        // Get the secret from the database
        $stmt = $pdo->prepare('SELECT totp_secret FROM accounts WHERE id = ?');
        $stmt->execute([ $_SESSION['account_id'] ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $secret = isset($result['totp_secret']) ? $result['totp_secret'] : '';

        // Verify the code
        if (TOTP::verifyCode($secret, $_POST['code'])) {
            // Enable 2FA
            $stmt = $pdo->prepare('UPDATE accounts SET totp_enabled = 1 WHERE id = ?');
            $stmt->execute([ $_SESSION['account_id'] ]);

            $success_msg = 'Two-factor authentication has been enabled successfully!';

            // Refresh account data
            $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
            $stmt->execute([ $_SESSION['account_id'] ]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $msg = 'Invalid verification code. Please try again.';

            // Show QR code again
            $issuer = urlencode(mail_name);
            $account_name = urlencode($account['email']);
            $qr_code_url = TOTP::getQRCodeUrl($issuer, $account_name, $secret);
            $show_qr = true;
        }
    }
    // Disable 2FA
    else if ($_POST['action'] === 'disable' && isset($account['totp_enabled']) && $account['totp_enabled']) {
        // Verify the code before disabling
        if (isset($_POST['code'])) {
            // Verify the code
            if (isset($account['totp_secret']) && TOTP::verifyCode($account['totp_secret'], $_POST['code'])) {
                // Disable 2FA
                $stmt = $pdo->prepare('UPDATE accounts SET totp_enabled = 0, totp_secret = NULL WHERE id = ?');
                $stmt->execute([ $_SESSION['account_id'] ]);

                $success_msg = 'Two-factor authentication has been disabled.';

                // Refresh account data
                $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
                $stmt->execute([ $_SESSION['account_id'] ]);
                $account = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $msg = 'Invalid verification code. Please try again.';
            }
        }
    }
}
?>

<section class="py-5">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2>Two-Factor Authentication Setup</h2>

                <?php if ($success_msg): ?>
                    <div class="alert alert-success">
                        <?=$success_msg?>
                    </div>
                <?php endif; ?>

                <?php if ($msg): ?>
                    <div class="alert alert-danger">
                        <?=$msg?>
                    </div>
                <?php endif; ?>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">App-Based Two-Factor Authentication</h5>

                        <?php if ((!isset($account['totp_enabled']) || !$account['totp_enabled']) && !$show_qr): ?>
                            <p>Enhance your account security by enabling two-factor authentication. This requires you to enter a verification code from an authenticator app in addition to your password when logging in.</p>

                            <form action="twofactor-setup.php" method="post">
                                <input type="hidden" name="action" value="enable">
                                <button type="submit" class="btn btn-primary">Enable Two-Factor Authentication</button>
                            </form>
                        <?php elseif ($show_qr): ?>
                            <p>Scan this QR code with your authenticator app (like Google Authenticator, Authy, or Microsoft Authenticator):</p>

                            <div class="text-center my-4">
                                <!-- Alternative: qr-server.com -->
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?=urlencode($qr_code_url)?>" alt="QR Code">
<!--                                <img src="https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=--><?php //=urlencode($qr_code_url)?><!--" alt="QR Code">-->
                            <p>Or manually enter this code in your app: <strong><?=htmlspecialchars($secret, ENT_QUOTES)?></strong></p>

                            <form action="twofactor-setup.php" method="post" class="mt-4">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter the 6-digit code from your app" required>
                                </div>
                                <input type="hidden" name="action" value="verify">
                                <button type="submit" class="btn btn-primary">Verify and Enable</button>
                            </form>
                        <?php else: ?>
                            <p class="text-success">Two-factor authentication is currently <strong>enabled</strong> for your account.</p>

                            <form action="twofactor-setup.php" method="post" class="mt-4">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter the 6-digit code from your app" required>
                                </div>
                                <input type="hidden" name="action" value="disable">
                                <button type="submit" class="btn btn-danger">Disable Two-Factor Authentication</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="profile.php" class="btn btn-secondary">Back to Profile</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
