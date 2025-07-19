<?php
include 'main.php';
// check CSRF token
if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
    exit('Error: Incorrect token provided!');
}
// check for login attempts for brute force checks
$login_attempts = login_attempts($pdo, FALSE);
if ($login_attempts && $login_attempts['attempts_left'] <= 0) {
    exit('Error: You cannot login right now! Please try again later!');
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    $login_attempts = login_attempts($pdo);
	// Could not retrieve the captured data, output error
	exit('Error: Please fill both the username and password fields!');
}
// Prepare our SQL query and find the account associated with the login details
// Preparing the SQL statement will prevent SQL injection
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username = ?');
$stmt->execute([ $_POST['username'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if the account exists
if ($account) {
	// Account exists... Verify the password
	if (password_verify($_POST['password'], $account['password'])) {
		// Check if the account is activated
		if (account_activation && $account['activation_code'] != 'activated') {
			// User has not activated their account, output the message
			echo 'Error: Please activate your account to login! Click <a href="resend-activation.php" class="form-link">here</a> to resend the activation email.';
		} else if ($account['activation_code'] == 'deactivated') {
			// The account is deactivated
			echo 'Error: Your account has been deactivated!';
		} else if (account_approval && !$account['approved']) {
			// The account is not approved
			echo 'Error: Your account has not been approved yet!';
		} else {
			// Verification success! User has loggedin!
			// Declare the session variables, which will basically act like cookies, but will store the data on the server as opposed to the client
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
			// IF the "remember me" checkbox is checked...
			if (isset($_POST['remember_me'])) {
				// Generate a hash that will be stored as a cookie and in the database. It will be used to identify the user.
				$cookie_hash = !empty($account['remember_me_code']) ? $account['remember_me_code'] : password_hash($account['id'] . $account['username'] . secret_key, PASSWORD_DEFAULT);
				// The number of days the user will be remembered
				$days = 30;
				// Create the cookie
				setcookie('remember_me', $cookie_hash, (int)(time()+60*60*24*$days));
				// Update the "rememberme" field in the accounts table with the new hash
				$stmt = $pdo->prepare('UPDATE accounts SET remember_me_code = ? WHERE id = ?');
				$stmt->execute([ $cookie_hash, $account['id'] ]);
			}
			// Update last seen date
			$date = date('Y-m-d\TH:i:s');
			$stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
			$stmt->execute([ $date, $account['id'] ]);

            $ip = $_SERVER['REMOTE_ADDR'];
            $stmt = $pdo->prepare('DELETE FROM login_attempts WHERE ip_address = ?');
            $stmt->execute([ $ip ]);
			// Success! Redirect to the home page
			// Output msg: do not change this line as the AJAX code depends on it
			echo 'Redirect: index.php';
		}
	} else {
		// Incorrect password
        $login_attempts = login_attempts($pdo, TRUE);
        echo 'Error: Incorrect username and/or password! You have ' . $login_attempts['attempts_left'] . ' attempts remaining!';
	}
} else {
	// Incorrect username
    $login_attempts = login_attempts($pdo, TRUE);
    echo 'Error: Incorrect username and/or password! You have ' . $login_attempts['attempts_left'] . ' attempts remaining!';
}
?>