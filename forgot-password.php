<?php
$page_title = "Forgot Password";
$page = "No Header";
include 'main.php';
require_once 'header.php';
// Error message variable
$error_msg = '';
// Success message variable
$success_msg = '';
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_POST['email'])) {
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    $stmt = $pdo->prepare('SELECT username, email FROM accounts WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the acc exists...
    if ($account) {
        // Email exist, so generate a strong unique reset code
    	$unique_reset_code = hash('sha256', uniqid() . $account['email'] . secret_key);
		// Update the reset code in the database
        $stmt = $pdo->prepare('UPDATE accounts SET reset_code = ? WHERE email = ?');
        $stmt->execute([ $unique_reset_code, $account['email'] ]);
		// Send email with reset link
		send_password_reset_email($account['email'], $account['username'], $unique_reset_code);
		// Output success message
        $success_msg = 'Reset password link has been sent to your email!';
    } else {
		// Output error message
        $error_msg = 'We do not have an account with that email!';
    }
}
?>
    <section class="shadow">
        <div class="bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8 mx-auto text-center">
                        <h2 class="my-2 fw-light text-white text-uppercase">Password Reset</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-lg-4 offset-4">
                <h1>Forgot Password</h1>
                <p>Enter your email address to reset your password.</p>

                <form action="forgot-password.php" method="post" class="form">

                    <div class="mb-3">
                        <input class="form-control py-2 px-3 bg-light border-0" type="email" name="email" id="email" placeholder="Email Address" />
                    </div>

                    <?php if ($error_msg): ?>
                        <div class="alert alert-danger">
                            <?=$error_msg?>
                        </div>
                    <?php elseif ($success_msg): ?>
                        <div class="alert alert-success">
                            <?=$success_msg?>
                        </div>
                    <?php endif; ?>

                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= require 'footer.php'; ?>