<?php
$page_title = 'Member Register';
$page = 'No Header';
require_once 'header.php';
include 'main.php';
// No need for the user to see the login form if they're logged-in, so redirect them to the home page
if (isset($_SESSION['account_loggedin'])) {
	// If the user is not logged in, redirect to the home page.
    header('Location: index.php');
    exit;
}
// Also check if they are "remembered"
if (isset($_COOKIE['remember_me']) && !empty($_COOKIE['remember_me'])) {
	// If the remember me cookie matches one in the database then we can update the session variables and the user will be logged-in.
	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE remember_me_code = ?');
	$stmt->execute([ $_COOKIE['remember_me'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($account) {
		// Authenticate the user
		session_regenerate_id();
		$_SESSION['account_loggedin'] = TRUE;
		$_SESSION['account_name'] = $account['username'];
		$_SESSION['account_id'] = $account['id'];
        $_SESSION['account_role'] = $account['role'];
		// Update last seen date
		$date = date('Y-m-d\TH:i:s');
		$stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
		$stmt->execute([ $date, $account['id'] ]);
		// Redirect to home page
        header('Location: index.php');
		exit;
	}
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="register">
                <div class="icon">
                    <!-- You could add your own site logo or icon here -->
                    <svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                </div>
                <h1>Member Register</h1>
                <form action="register-process.php" method="post" class="form register-form">

                    <div class="mb-3 input-group">
                        <input class="form-control" type="text" name="username" placeholder="Enter Your Username" id="username" required/>
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                          </span>
                    </div>

                    <div class="mb-3 input-group">
                        <input type="password" class="form-control"  name="password" placeholder="Enter your password" id="password" required/>
                        <div class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 22" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                    </div>

                    <div class="mb-3 input-group">
                        <input type="password" class="form-control"  name="cpassword" placeholder="Confirm password" id="cpassword" required/>
                        <div class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 22" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                    </div>

                    <div class="mb-3 input-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" id="email" required/>
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                          </span>
                    </div>

                    <div class="msg mb-2"></div>

                    <button class="btn btn-primary mb-2" type="submit">Register</button>

                    <p class="register-link">Already have an account? <a href="index.php" class="form-link">Login Here</a></p>

                </form>

                <script>
                    // AJAX code
                    const registrationForm = document.querySelector('.register-form');
                    registrationForm.onsubmit = event => {
                        event.preventDefault();
                        fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm), cache: 'no-store' }).then(response => response.text()).then(result => {
                            if (result.toLowerCase().includes('success:')) {
                                registrationForm.querySelector('.msg').classList.remove('error','success');
                                registrationForm.querySelector('.msg').classList.add('success');
                                registrationForm.querySelector('.msg').innerHTML = result.replace('Success: ', '');
                            } else if (result.toLowerCase().includes('redirect:')) {
                                window.location.href = result.replace('Redirect:', '').trim();
                            } else {
                                registrationForm.querySelector('.msg').classList.remove('error','success');
                                registrationForm.querySelector('.msg').classList.add('error');
                                registrationForm.querySelector('.msg').innerHTML = result.replace('Error: ', '');
                            }
                        });
                    };
                </script>
            </div>
        </div>
    </div>
</div>

<?= require 'footer.php'; ?>