<?php
$page_title = 'Member Register';
$page = 'No Header';
include 'main.php';
require_once 'header.php';

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
// add CSRF token
$_SESSION['token'] = hash('sha256', uniqid(rand(), true));
?>
<section class="py-5">
    <div class="container pb-5 pt-4">
        <div class="row">
            <div class="col-md-4 offset-1">
                <div class="register">

                    <form action="register-process.php" method="post" class="form register-form">
                        <span class="text-muted">Sign Up</span>
                        <h2 class="mb-4 fw-light">Join our community</h2>
                        <div class="mb-3 input-group">
                            <input class="form-control" type="text" name="username" placeholder="Username" id="username" required/>
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                              </span>
                        </div>

                        <div class="mb-3 input-group">
                            <input type="password" class="form-control"  name="password" placeholder="Password" id="password" required/>
                            <i id="togglePassword" class="fa-regular fa-eye" style="position: absolute; right: 60px; top: 50%; transform: translateY(-50%); cursor: pointer; color: black;"></i>

                            <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                </svg>
                            </div>
                        </div>

                        <div class="mb-3 input-group">
                            <input type="password" class="form-control"  name="cpassword" placeholder="Confirm password" id="cpassword" required/>

                            <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                </svg>
                            </div>
                        </div>

                        <div class="mb-3 input-group">
                            <input class="form-control" type="email" name="email" placeholder="Email Address" id="email" required/>
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                </svg>
                              </span>
                        </div>

                        <div id="passwordStrength" class="passwordStrength" style="display: none;"></div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="terms-and-conditions.php" class="text-decoration-none">Terms and Conditions</a> and <a href="privacy-policy.php" class="text-decoration-none">Privacy Policy</a></label>
                        </div>

                        <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
                        <div class="msg"></div>

                        <button class="btn btn-primary mb-2" type="submit">Register</button>

                        <p style="font-size:17px !important" class="register-link">Already have an account? <a class="text-decoration-none" href="index.php" class="form-link">Login Here</a></p>

                    </form>

                    <script>
                        // AJAX code
                        const registrationForm = document.querySelector('.register-form');
                        registrationForm.onsubmit = event => {
                            event.preventDefault();
                            fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm), cache: 'no-store' }).then(response => response.text()).then(result => {
                                if (result.toLowerCase().includes('success:')) {
                                    registrationForm.querySelector('.msg').classList.remove('mt-2','alert','alert-danger','alert-success');
                                    registrationForm.querySelector('.msg').classList.add('mt-2','alert','alert-success');
                                    registrationForm.querySelector('.msg').innerHTML = result.replace('Success: ', '');
                                } else if (result.toLowerCase().includes('redirect:')) {
                                    window.location.href = result.replace('Redirect:', '').trim();
                                } else {
                                    registrationForm.querySelector('.msg').classList.remove('mt-2','alert','alert-danger','alert-success');
                                    registrationForm.querySelector('.msg').classList.add('mt-2','alert','alert-danger');
                                    registrationForm.querySelector('.msg').innerHTML = result.replace('Error: ', '');
                                }
                            });
                        };
                    </script>
                </div>
            </div>
            <div class="offset-1 col-lg-4 d-lg-flex align-items-center">
                <img class="img-fluid rounded-circle p-2 border shadow" width="300" src="images/avatar/default_avatar.png" alt=""/>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
