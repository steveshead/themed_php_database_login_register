<?php
$page_title = "Resend Activation";
$page = '';
require_once 'header.php';
include 'main.php';
// Error message variable
$error_msg = '';
// Success message variable
$success_msg = '';
// Now we check if the email from the resend activation form was submitted, isset() will check if the email exists.
if (isset($_POST['email'])) {
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    $stmt = $pdo->prepare('SELECT activation_code FROM accounts WHERE email = ? AND activation_code != "" AND activation_code != "activated" AND activation_code != "deactivated"');
    $stmt->execute([ $_POST['email'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the account exists:
    if ($account) {
        // account exists
        // Send activation email
        send_activation_email($_POST['email'], $account['activation_code']);
        // Output success message
        $success_msg = 'Activaton link has been sent to your email!';
    } else {
        $error_msg = 'An account with that email doesn\'t exist or is already activated!';
    }
}
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-4">
                <h1>Resend Activation Email</h1>

                <form action="resend-activation.php" method="post" class="form">

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