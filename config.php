<?php
// Your MySQL database hostname.
define('db_host','localhost');
// Your MySQL database username.
define('db_user','root');
// Your MySQL database password.
define('db_pass','root');
// Your MySQL database name.
define('db_name','loginregistration-themed');
// Your MySQL database charset.
define('db_charset','utf8mb4');
// The secret key used for hashing purposes. Change this to a random unique string.
define('secret_key','yoursecretkey');
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

// Uncomment the below to output all errors
// ini_set('log_errors', true);
// ini_set('error_log', 'error.log');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>