<?php
$page_title = 'Profile Page';
$page = '';
include 'main.php';
// Check logged-in
check_loggedin($pdo);
require_once 'header.php';
// Error message variable
$error_msg = '';
// Success message variable
$success_msg = '';
// Retrieve additional account info from the database because we don't have them stored in sessions
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
$stmt->execute([ $_SESSION['account_id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Handle edit profile post data
if (isset($_POST['username'], $_POST['npassword'], $_POST['cpassword'], $_POST['email'])) {
    // Make sure the submitted registration values are not empty.
    if (empty($_POST['username']) || empty($_POST['email'])) {
        $error_msg = 'The input fields must not be empty!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_msg = 'Please provide a valid email address!';
    } else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $error_msg = 'Username must contain only letters and numbers!';
    } else if (!empty($_POST['npassword'])) {
        // Only validate password if one was entered
        $password = $_POST['npassword'];
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (strlen($password) < 8 || strlen($password) > 24) {
            $error_msg = 'Password must be between 8 and 24 characters long!';
        } else if (!$uppercase) {
            $error_msg = 'Password must contain at least one uppercase letter!';
        } else if (!$lowercase) {
            $error_msg = 'Password must contain at least one lowercase letter!';
        } else if (!$number) {
            $error_msg = 'Password must contain at least one number!';
        } else if (!$specialChars) {
            $error_msg = 'Password must contain at least one special character!';
        } else if ($_POST['cpassword'] != $_POST['npassword']) {
            $error_msg = 'Passwords do not match!';
        }
    }
	// No validation errors... Process update
	if (empty($error_msg)) {
		// Check if new username or email already exists in the database
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM accounts WHERE (username = ? OR email = ?) AND username != ? AND email != ?');
		$stmt->execute([ $_POST['username'], $_POST['email'], $account['username'], $account['email'] ]);
		// Account exists? Output error...
		if ($stmt->fetchColumn() > 0) {
			$error_msg = 'Account already exists with that username and/or email!';
		} else {
			// No errors occurred, update the account...
			// Hash the new password if it was posted and is not blank
			$password = !empty($_POST['npassword']) ? password_hash($_POST['npassword'], PASSWORD_DEFAULT) : $account['password'];
			// If email has changed, generate a new activation code
			$activation_code = account_activation && $account['email'] != $_POST['email'] ? hash('sha256', uniqid() . $_POST['email'] . secret_key) : $account['activation_code'];
			// Update the account
			$stmt = $pdo->prepare('UPDATE accounts SET first_name = ?, last_name = ?, username = ?, password = ?, email = ?, occupation = ?, motto = ?, location = ?, facebook = ?, instagram = ?, twitter = ?, activation_code = ? WHERE id = ?');
			$stmt->execute([ $_POST['first_name'], $_POST['last_name'], $_POST['username'], $password, $_POST['email'], $_POST['occupation'], $_POST['motto'], $_POST['location'], $_POST['facebook'], $_POST['instagram'], $_POST['twitter'], $activation_code, $_SESSION['account_id'] ]);
			// Update the session variables
			$_SESSION['account_name'] = $_POST['username'];
			$_SESSION['first_name'] = $_POST['first_name'];
			// If email has changed, logout the user and send a new activation email
			if (account_activation && $account['email'] != $_POST['email']) {
				// Account activation required, send the user the activation email with the "send_activation_email" function from the "main.php" file
				send_activation_email($_POST['email'], $activation_code);
				// Logout the user
				unset($_SESSION['account_loggedin']);
				// Output success message
				$success_msg = 'You have changed your email address! You need to re-activate your account!';
			} else {
				// Profile updated successfully, redirect the user back to the profile page
				header('Location: profile.php');
				exit;
			}
		}
	}
}
?>

<?php if (!isset($_GET['action'])): ?>

<!-- View Profile Page -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-2">
                    <div class="text-center">
                        <h2 class="fw-light mb-4">User Details</h2>
                        <img src="<?= !empty($account['avatar']) ? htmlspecialchars($account['avatar'], ENT_QUOTES) : '/images/avatar/default_avatar.png' ?>" class="rounded-circle img-fluid p-2 border shadow" style="width: 200px;">
                        <h1 class="my-3 fw-light"><?= isset($account['first_name']) ? htmlspecialchars($account['first_name'], ENT_QUOTES)  . ' ' . htmlspecialchars($account['last_name'], ENT_QUOTES) : htmlspecialchars($account['username']) ?></h1>
                        <h3 class="text-muted mb-1 fw-light"><?= htmlspecialchars($account['occupation'], ENT_QUOTES)?></h3>
                        <p class="text-muted mb-4 fst-italic"><?= htmlspecialchars($account['motto'], ENT_QUOTES)?></p>
                        <ul class="list-unstyled d-flex align-items-center justify-content-center mb-4">
                            <li class="ms-3">
                                <a class="link-body-emphasis" href="https://www.facebook.com/<?=htmlspecialchars($account['facebook'], ENT_QUOTES)?>" aria-label="Facebook">
                                    <img src="assets/icons/facebook-blue.svg" alt="">
                                </a>
                            </li>
                            <li class="ms-3">
                                <a class="link-body-emphasis" href="https://www.instagram.com/<?=htmlspecialchars($account['instagram'], ENT_QUOTES)?>" aria-label="Instagram">
                                    <img src="assets/icons/instagram-blue.svg" alt="">
                                </a>
                            </li>
                            <li class="ms-3">
                                <a class="link-body-emphasis" href="https://www.x.com/<?=htmlspecialchars($account['twitter'], ENT_QUOTES)?>" aria-label="Twitter">
                                    <img src="assets/icons/twitter-blue.svg" alt="">
                                </a>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center mb-2">
                            <a class="btn btn-primary me-1" href="?action=edit">Edit Profile</a>
                            <a href="twofactor-setup.php" class="btn btn-outline-primary mx-1">2FA Settings</a>
                            <a href="logout.php" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h2 class="fw-light mb-4">Profile Details</h2>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>First Name</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?= htmlspecialchars($account['first_name'], ENT_QUOTES) ?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Last Name</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?= htmlspecialchars($account['last_name'], ENT_QUOTES) ?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Username</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?= htmlspecialchars($account['username'], ENT_QUOTES) ?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Email</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?=htmlspecialchars($account['email'], ENT_QUOTES)?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Occupation</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?= htmlspecialchars($account['occupation'], ENT_QUOTES)?></p>
                            </div>
                        </div>

                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <p class="mb-0"><strong>Motto</strong></p>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-muted mb-0"><?= htmlspecialchars($account['motto'], ENT_QUOTES)?></p>
                        </div>
                    </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Location</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?= htmlspecialchars($account['location'], ENT_QUOTES)?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Role</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?= htmlspecialchars($account['role'], ENT_QUOTES)?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Registered</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?=date('F jS, Y', strtotime($account['registered']))?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Facebook</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?=htmlspecialchars($account['facebook'], ENT_QUOTES)?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Instagram</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?=htmlspecialchars($account['instagram'], ENT_QUOTES)?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <p class="mb-0"><strong>Twitter</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0"><?=htmlspecialchars($account['twitter'], ENT_QUOTES)?></p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

<?php elseif ($_GET['action'] == 'edit'): ?>

<!-- Edit Profile Page -->
<section class="edit-profile py-5">
    <div class="container">
        <div class="row mb-2">
            <div class="col-lg-12">
                <h2 class="fw-light text-center mb-3">Update Profile</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <img width="375" class="border rounded p-2 shadow-sm" src="<?= !empty($account['avatar']) ? htmlspecialchars($account['avatar'], ENT_QUOTES) : '/images/avatar/default_avatar.png' ?>">
            </div>
            <div class="col-lg-4">
                <form action="profile.php?action=edit" method="post" class="form form-small">

                    <div class="input-group mb-3">
                        <span class="input-group-text">First Name</span>
                        <input class="form-control" type="text" name="first_name" placeholder="First Name" id="first_name" value="<?=htmlspecialchars($account['first_name'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Last Name</span>
                        <input class="form-control" type="text" name="last_name" placeholder="Last Name" id="last_name" value="<?=htmlspecialchars($account['last_name'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Username</span>
                        <input class="form-control" type="text" name="username" placeholder="Username" id="username" value="<?=htmlspecialchars($account['username'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">New Password</span>
                        <input class="form-control" type="password" name="npassword" id="npassword" autocomplete="new-password">
                        <i id="togglePassword" class="fa-regular fa-eye" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: black;"></i>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Confirm Password</span>
                        <input class="form-control" type="password" name="cpassword" id="cpassword" autocomplete="new-password">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Email Address</span>
                        <input class="form-control" type="email" name="email" placeholder="Email Address" id="email" value="<?=htmlspecialchars($account['email'], ENT_QUOTES)?>" required>
                    </div>

                    <div id="passwordStrength" class="passwordStrength" style="display: none;"></div>

                </div>
            <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Occupation</span>
                        <input class="form-control" type="text" name="occupation" placeholder="Occupation" id="occupation" value="<?=htmlspecialchars($account['occupation'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Motto</span>
                        <input class="form-control" type="text" name="motto" placeholder="Motto" id="motto" value="<?=htmlspecialchars($account['motto'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Location</span>
                        <input class="form-control" type="text" name="location" placeholder="Location" id="location" value="<?=htmlspecialchars($account['location'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Facebook</span>
                        <input class="form-control" type="text" name="facebook" placeholder="Facebook" id="facebook" value="<?=htmlspecialchars($account['facebook'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Instagram</span>
                        <input class="form-control" type="text" name="instagram" placeholder="instagram" id="instagram" value="<?=htmlspecialchars($account['instagram'], ENT_QUOTES)?>">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Twitter</span>
                        <input class="form-control" type="text" name="twitter" placeholder="twitter" id="twitter" value="<?=htmlspecialchars($account['twitter'], ENT_QUOTES)?>">
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

                    <div class="my-4">
                        <button class="btn btn-primary me-2" type="submit">Update Profile</button>
                        <a href="avatar.php" class="btn btn-outline-primary me-2" type="submit"><?= !empty($account['avatar']) ? 'Change Avatar' : 'Upload Avatar' ?></a>
                        <a href="profile.php" class="btn btn-outline-secondary">View Profile</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>

<?php require 'footer.php'; ?>
