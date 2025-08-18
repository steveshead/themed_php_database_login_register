<?php
$page_title = "App-Based 2FA";
$page = '';
// Include the main.php file
include 'main.php';
// Include TOTP library
require_once 'lib/totp.php';
require_once 'header.php';

// Output message
$msg = '';

// Verify the ID provided
if (isset($_SESSION['tfa_id'])) {
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    $stmt = $pdo->prepare('SELECT email, totp_secret, totp_enabled, username, id, role FROM accounts WHERE id = ?');
    $stmt->execute([ $_SESSION['tfa_id'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If the account exists...
    if ($account && $account['totp_enabled'] == 1) {
        // Account exists and has app-based 2FA enabled
        if (isset($_POST['code'])) {
            // Code submitted via the form
            if (TOTP::verifyCode($account['totp_secret'], $_POST['code'])) {
                // Code accepted, authenticate the user
                session_regenerate_id();
                $_SESSION['account_loggedin'] = TRUE;
                $_SESSION['account_name'] = $account['username'];
                $_SESSION['account_id'] = $account['id'];
                $_SESSION['account_role'] = $account['role'];
                
                // Destroy tfa session variables
                unset($_SESSION['tfa_id']);
                
                // Redirect to home page
                header('Location: index.php');
                exit;
            } else {
                $msg = 'Incorrect code provided!';
            }
        }
    } else {
        exit('Invalid request or 2FA not enabled for this account!');
    }
} else {
    exit('Invalid request!');
}
?>

<section class="py-5">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-4 offset-4">
                <h2>Two-Factor Authentication</h2>

                <p class="py-2">Please enter the code from your authenticator app.</p>

                <form action="app-twofactor.php" method="post" class="form">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-4 input-group">
                                <input class="form-control" type="text" name="code" placeholder="Enter Code" id="code" required>
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($msg): ?>
                        <div class="msg alert alert-danger">
                            <?=$msg?>
                        </div>
                    <?php endif; ?>

                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>