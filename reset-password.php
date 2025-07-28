<?php
$page_title = "Reset Password";
$page = '';
require_once 'header.php';
include 'main.php';
// Error message variable
$error_msg = '';
// Success message variable
$success_msg = '';
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE reset_code = ?');
    $stmt->execute([ $_GET['code'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the account exists...
    if ($account) {
		// Validate form data
        if (isset($_POST['npassword'], $_POST['cpassword'])) {
            if (strlen($_POST['npassword']) > 20 || strlen($_POST['npassword']) < 5) {
            	$error_msg = 'Password must be between 5 and 20 characters long!';
            } else if ($_POST['npassword'] != $_POST['cpassword']) {
                $error_msg = 'Passwords must match!';
            } else {
				// Hash the new password
				$password = password_hash($_POST['npassword'], PASSWORD_DEFAULT);
				// Update the password in the database
                $stmt = $pdo->prepare('UPDATE accounts SET password = ?, reset_code = "" WHERE reset_code = ?');
                $stmt->execute([ $password, $_GET['code'] ]);
				// Output success message
                $success_msg = 'Password has been reset! You can now <a href="index.php" class="form-link">login</a>!';
            }
        }
    } else {
		// Coundn't find the account with that reset code
        exit('Incorrect code provided!');
    }
} else {
	// No code specified in the URL (GET request)
    exit('No code provided!');
}
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-3">
                <h1>Reset Passsword</h1>

                <form action="reset-password.php?code=<?=$_GET['code']?>" method="post" class="form" autocomplete="off">

                    <label class="form-label" for="npassword">Password</label>
                    <div class="form-group">
                        <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                        <input class="form-input" type="password" name="npassword" placeholder="New Password" id="npassword" autocomplete="new-password" required>
                    </div>

                    <label class="form-label" for="cpassword">Confirm Password</label>
                    <div class="form-group mar-bot-5">
                        <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                        <input class="form-input" type="password" name="cpassword" placeholder="Confirm Password" id="cpassword" autocomplete="new-password" required>
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

<?= require 'footer.php'; ?>