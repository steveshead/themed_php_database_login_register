<?php
include 'main.php';
$page_title = 'Member Login';
$page = 'No Header';
require_once 'header.php';

// No need for the user to see the login form if they're logged-in, so redirect them to the home page
if (isset($_SESSION['account_loggedin'])) {
    // If the user is logged in, redirect to the home page.
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
        $_SESSION['facebook'] = $account['facebook'];
        $_SESSION['instagram'] = $account['instagram'];
        $_SESSION['twitter'] = $account['twitter'];
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

<section class="position-relative py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="row pt-4">
                    <div class="col-12 col-md-8 col-lg-10 mx-auto">

                        <div class="mb-4">
                            <form action="authenticate.php" class="login-form">
                                <span class="text-muted">Sign In</span>
                                <h2 class="mb-4 fw-light">Join our community</h2>
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
                                <button class="btn btn-primary mb-2 w-100" type="submit">Sign In</button>
                                <a class="forgot-password text-secondary" href="forgot-password.php">Reset Password</a>
                                <p class="mb-4 text-muted text-center">or continue with</p>
                                <button class="btn btn-outline-secondary mb-2 w-100 text-start" href="#">
                                    <img class="img-fluid me-2" src="assets/logos/facebook-sign.svg"/>
                                    <span>Sign In with Facebook</span>
                                </button>
                                <button class="btn btn-outline-secondary w-100 text-start" href="#">
                                    <img class="img-fluid me-2" src="assets/logos/google-sign.svg"/>
                                    <span>Sign In with Google</span>
                                </button>
                                <p class="mt-4"><a href="#">Police privacy</a> and <a href="#">Terms of Use</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 bg-primary d-lg-flex align-items-center">
                <img class="img-fluid" src="assets/illustrations/walk-dog.png" alt=""/>
            </div>
        </div>
    </div>
    <script>
        // AJAX code
        const loginForm = document.querySelector('.login-form');
        loginForm.onsubmit = event => {
            event.preventDefault();
            fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm), cache: 'no-store' }).then(response => response.text()).then(result => {
                if (result.toLowerCase().includes('success:')) {
                    loginForm.querySelector('.msg').classList.remove('error','success');
                    loginForm.querySelector('.msg').classList.add('success');
                    loginForm.querySelector('.msg').innerHTML = result.replace('Success: ', '');
                } else if (result.toLowerCase().includes('redirect:')) {
                    window.location.href = result.replace('Redirect:', '').trim();
                } else {
                    loginForm.querySelector('.msg').classList.remove('error','success');
                    loginForm.querySelector('.msg').classList.add('error');
                    loginForm.querySelector('.msg').innerHTML = result.replace('Error: ', '');
                }
            });
        };
    </script>
</section>

<?= require 'footer.php'; ?>