<?php
$page_title = 'Activate Account';
$page = '';
include 'main.php';
require_once 'header.php';
// Success message variable
$success_msg = '';
// First we check if the email and code exists, these variables will appear as parameters in the URL
if (isset($_GET['code']) && !empty($_GET['code'])) {
	// Check if the account exists with the specified activation code
	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE activation_code = ? AND activation_code != "activated" AND activation_code != "deactivated"');
	$stmt->execute([ $_GET['code'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
	// If account exists with the requested code
	if ($account) {
		// Update the activation code column to "activated" - this is how we can check if the user has activated their account
		$stmt = $pdo->prepare('UPDATE accounts SET activation_code = "activated" WHERE activation_code = ?');
		$stmt->execute([ $_GET['code'] ]);
		// Output success message
		$success_msg = 'Your account is now activated! You can now <a href="index.php" class="form-link">Login</a>.';
	} else {
		// Account with the code specified does not exist
		exit('The account is already activated or doesn\'t exist!');
	}
} else {
	exit('No code was specified!');
}
?>

		<div class="login">

			<h1>Activate Account</h1>

			<div class="form register-form">

				<div class="msg success">
					<?=$success_msg?>
				</div>

			</div>
<?= require 'footer.php'; ?>