<?php // Admin panel link - will only be visible if the user is an admin
$admin_panel_link = isset($_SESSION['account_role']) && $_SESSION['account_role'] === 'Admin' ? '<a class="nav-link text-uppercase" href="admin/index.php" target="_blank">Admin</a>' : '';
// Get the current file name (eg. home.php, profile.php)
$current_file_name = basename($_SERVER['PHP_SELF']);
// Check if user is logged in
$logged_in = isset($_SESSION['account_loggedin']) && $_SESSION['account_loggedin'] === TRUE;
// CSS class for nav items that should be hidden when not logged in
$nav_item_class = !$logged_in ? 'nav-item me-2 display-none' : 'nav-item me-2';
// Indenting the below code may cause HTML validation errors
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$page_title?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- Default favicon (for browsers that don't support media queries in link tags) -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/favicon/favicon_light_theme.svg" id="faviconTag">
</head>

<header class="shadow bg-white sticky-top">
    <div class="container">
        <nav class="position-relative navbar navbar-expand-lg fixed-top navbar-light py-3 mb-5">
            <a class="navbar-brand" href="#">
                <img src="assets/logos/novus/novus.png" alt="" width="106">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="side-menu" data-target="#sideMenuHeaders07" aria-controls="sideMenuHeaders07" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav position-absolute top-50 start-50 translate-middle">

                    <li class="nav-item me-2"><a class="nav-link text-uppercase <?= $current_file_name === 'index.php' ? 'active' : '' ?>" href="/">Home</a></li>
                    <li class="<?=$nav_item_class?>"><a class="nav-link text-uppercase <?= $current_file_name === 'profile.php' ? 'active' : '' ?>" href="profile.php">Profile</a></li>
                    <li class="nav-item me-2"><a class="nav-link text-uppercase <?= $current_file_name === 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
                    <li class="<?=$nav_item_class?> "><?=$admin_panel_link?></li>
                    <li class="<?=$nav_item_class?> nav-item me-2"><a class="btn btn-primary btn-sm mt-1 text-uppercase" href="logout.php">Logout</a></li>
                </ul>
                <div class="ms-auto <?= $logged_in ? 'display-none' : '' ?>">
                    <a class="btn btn-outline-primary me-2" href="login.php">Log In</a>
                    <a class="btn btn-primary" href="register.php">Sign Up</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<body>
