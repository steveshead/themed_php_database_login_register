<?php
include 'main.php';
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['cpassword'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('Error: Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Error: Please complete the registration form!');
}
// Check to see if the email is valid.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Error: Please provide a valid email address!');
}
// Username must contain only characters and numbers.
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    exit('Error: Username must contain only letters and numbers!');
}
// Password must be between 8 and 24 characters long.
$password=$_POST['password'];
$uppercase   = preg_match('@[A-Z]@', $password);
$lowercase   = preg_match('@[a-z]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$specialChars || strlen($password) > 24 || strlen($password) < 8) {
    exit('Error: Password should include at least one upper case and one lower case character, one number and one special character, and be between 8 and 24 characters!');
} else {
    echo 'Strong password! ';
}
// Check if both the password and confirm password fields match
if ($_POST['cpassword'] != $_POST['password']) {
	exit('Error: Passwords do not match!');
}
// Check if the account with that username already exists
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username = ? OR email = ?');
$stmt->execute([ $_POST['username'], $_POST['email'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Store the result, so we can check if the account exists in the database.
if ($account) {
	// Username already exists
	echo 'Error: Username and/or email exists!';
} else {
	// Username doesnt exist, insert new account
	// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	// Generate unique activation code
	$activation_code = account_activation ? hash('sha256', uniqid() . $_POST['email'] . secret_key) : 'activated';
	// Approval required?
	$approved = account_approval ? 0 : 1;
	// Default role
	$role = 'Member';
	// Current date
	$date = date('Y-m-d\TH:i:s');
	// Prepare query; prevents SQL injection
    $stmt = $pdo->prepare('INSERT INTO accounts (username, password, email, activation_code, role, registered, last_seen, approved, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt->execute([ $_POST['username'], $password, $_POST['email'], $activation_code, $role, $date, $date, $approved, $ip ]);
	// Get last insert ID
	$id = $pdo->lastInsertId();
	// Send notification email
	if (notifications_enabled) {
		send_notification_email($id, $_POST['username'], $_POST['email'], $date);
	}
	// If account activation is required, send activation email
	if (account_activation) {
		// Account activation required, send the user the activation email with the "send_activation_email" function from the "main.php" file
		send_activation_email($_POST['email'], $activation_code);
		echo 'Success: Please check your email to activate your account!';
	} else {
		// Automatically authenticate the user if the option is enabled
		if (auto_login_after_register) {
			// Regenerate session ID
			session_regenerate_id();
			// Declare session variables
			$_SESSION['account_loggedin'] = TRUE;
			$_SESSION['account_name'] = $_POST['username'];
			$_SESSION['account_id'] = $id;
			$_SESSION['account_role'] = $role;		
			// Do not change the output message as the AJAX code will use this to detect if the registration was successful and redirect to the home page
			echo 'Redirect: index.php';
		} else {
			echo 'Success: You have successfully registered! You can now login!';
		}
	}
}
?>