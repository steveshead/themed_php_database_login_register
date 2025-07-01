<?php
session_start();
// Destroy the session associated with the user
session_destroy();
// If the user is remembered, delete the cookie
if (isset($_COOKIE['remember_me'])) {
    unset($_COOKIE['remember_me']);
    setcookie('remember_me', '', time() - 3600);
}
// Redirect to the login page:
header('Location: index.php');
?>