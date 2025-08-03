<?php
// Your MySQL database hostname.
// Load environment variables from .env file
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && $line[0] !== '#') {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Load the .env file
loadEnv(__DIR__ . '/.env');

// Define constants using environment variables
define('db_host', $_ENV['DB_HOST'] ?? 'localhost');
define('db_user', $_ENV['DB_USER'] ?? 'root');
define('db_pass', $_ENV['DB_PASS'] ?? '');
define('db_name', $_ENV['DB_NAME'] ?? 'database');

// Your MySQL database charset.
define('db_charset','utf8mb4');
// The secret key used for hashing purposes. Change this to a random unique string.
define('secret_key','6Ecqf3xF6hIIt3QaRMSp7CLos7gVe87N');
// The base URL of the PHP login system (e.g. https://example.com/phplogin/). Must include a trailing slash.
define('base_url','https://loginregistration-themed.local:8890/');
// The template editor to use for editing product descriptions, email templates, etc.
// List:tinymce=TinyMCE,textarea=Textarea
define('template_editor','tinymce');
/* Registration */
// If enabled, the user will be redirected to the homepage automatically upon registration.
define('auto_login_after_register',false);
// If enabled, the account will require email activation before the user can login.
define('account_activation',true);
// If enabled, the user will require admin approval before the user can login.
define('account_approval',false);
/* Mail */
// If enabled, mail will be sent upon registration with the activation link, etc.
define('mail_enabled',true);
// Send mail from which address?
define('mail_from','steve@steveshead.io');
// The name of your website/business.
define('mail_name','Steve Shead Dot IO');
// If enabled, you will receive email notifications when a new user registers.
define('notifications_enabled',true);
// The email address to send notification emails to.
define('notification_email','steve@steveshead.io');
// Is SMTP server?
define('SMTP',false);
// SMTP Hostname
define('smtp_host','smtp.example.com');
// SMTP Port number
define('smtp_port',465);
// SMTP Username
define('smtp_user','user@example.com');
// SMTP Password
define('smtp_pass','secret');
/* Google OAuth */
// The OAuth client ID associated with your API console account.
define('google_oauth_client_id','YOUR_CLIENT_ID');
// The OAuth client secret associated with your API console account.
define('google_oauth_client_secret','YOUR_SECRET_KEY');
// The URL to the Google OAuth file.
define('google_oauth_redirect_uri','http://loginregistration-themed.local:8890/google-oauth.php');
/* Facebook OAuth */
// The OAuth App ID associated with your Facebook App.
define('facebook_oauth_app_id','YOUR_APP_ID');
// The OAuth App secret associated with your Facebook App.
define('facebook_oauth_app_secret','YOUR_APP_SECRET_ID');
// The URL to the Facebook OAuth file.
define('facebook_oauth_redirect_uri','http://localhost/phplogin/facebook-oauth.php');

/* Session Settings */
// Session timeout in seconds (e.g., 1800 = 30 minutes, 3600 = 60 minutes)
define('session_timeout',3600);

// Uncomment the below to output all errors
// ini_set('log_errors', true);
// ini_set('error_log', 'error.log');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>
