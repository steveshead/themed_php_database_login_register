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
        // Set the last activity timestamp for session timeout tracking
        $_SESSION['last_activity'] = time();
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

// Check if the user was redirected due to session timeout
$timeout_message = '';
if (isset($_GET['timeout']) && $_GET['timeout'] == 1) {
    $timeout_message = 'Your session has expired due to inactivity. Please log in again.';
}
?>

<section class="position-relative py-5">
    <div class="container pb-5">
        <div class="row pt-4">
            <div class="col-lg-4 offset-1 pe-5">
                <div class="mb-4">
                    <form action="authenticate.php" class="login-form">
                        <span class="text-muted">Sign In</span>
                        <h2 class="mb-4 fw-light">Login to our community</h2>
                        <div class="mb-3 input-group">
                            <input class="form-control" type="text" name="username" placeholder="Enter Your Username" id="username" required/>
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                          </span>
                        </div>
                        <div class="mb-3 input-group">
                            <input type="password" class="form-control"  name="password" placeholder="Enter your password" id="password" required/>
                            <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                </svg>
                            </div>
                        </div>

                        <button class="btn btn-primary mb-2 w-100" type="submit">Sign In</button>

                        <div class="mb-3 input-group">

                            <div class="container p-0">
                                <div class="row d-flfex">
                                    <div class="col-lg-6">
                                        <label id="remember_me" class="fw-light">
                                            <input class="me-2" type="checkbox" name="remember_me">Remember me
                                        </label>
                                    </div>
                                    <div class="col-lg-6 d-flex justify-content-end">
                                        <a href="forgot-password.php" class="text-decoration-none fw-light">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
                        <div class="msg">
                            <?php if (!empty($timeout_message)): ?>
                            <div class="mt-2 alert alert-warning"><?= $timeout_message ?></div>
                            <?php endif; ?>
                        </div>


                    </form>
                    <p class="mb-4 text-muted text-center">or continue with</p>

                    <a href="facebook-oauth.php" class="fb-btn">
                        <button class="btn btn-outline-secondary mb-2 w-100 text-start" href="#">
                            <img class="img-fluid me-2" src="assets/logos/facebook-sign.svg"/>
                            <span>Sign In with Facebook</span>
                        </button>
                    </a>

                    <a href="google-oauth.php" class="gl-btn">
                        <button class="btn btn-outline-secondary w-100 text-start" href="#">
                            <img class="img-fluid me-2" src="assets/logos/google-sign.svg"/>
                            <span>Sign In with Google</span>
                        </button>
                    </a>

                    <p class="mt-4" style="font-size:17px !important;"><a class="text-decoration-none" href="#">Police privacy</a> and <a class="text-decoration-none" href="#">Terms of Use</a></p>
                </div>
            </div>

            <div class="offset-1 col-lg-4 d-lg-flex align-items-center">
                <img class="img-fluid rounded-circle p-2 border shadow" width="400" src="images/avatar/default_avatar.png" alt=""/>
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
                    loginForm.querySelector('.msg').classList.remove('mt-2','alert','alert-danger','alert-success');
                    loginForm.querySelector('.msg').classList.add('mt-2','alert','alert-success');
                    loginForm.querySelector('.msg').innerHTML = result.replace('Success: ', '');
                } else if (result.toLowerCase().includes('redirect:')) {
                    window.location.href = result.replace('Redirect:', '').trim();
                } else if (result.includes('tfa:')) {
                    window.location.href = result.replace('tfa: ', '');
                } else {
                    loginForm.querySelector('.msg').classList.remove('mt-2','alert','alert-danger','alert-success');
                    loginForm.querySelector('.msg').classList.add('mt-2','alert','alert-danger');
                    loginForm.querySelector('.msg').innerHTML = result.replace('Error: ', '');
                }
            });
        };
    </script>
</section>

<?php require 'footer.php'; ?>
