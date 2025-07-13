<?php
// The main file contains the database connection, session initializing, and functions, other PHP files will depend on this file.
// Include the configuration file
include_once 'config.php';
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// Namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Connect to the MySQL database using the PDO interface
try {
	$pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=' . db_charset, db_user, db_pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to database: ' . $exception->getMessage());
}
// The below function will check if the user is logged-in and also check the remember me cookie
function check_loggedin($pdo, $redirect_file = 'index.php') {
	// Comment the below code if you don't want to update the last seen date on each page load
	if (isset($_SESSION['account_loggedin'])) {
		$date = date('Y-m-d\TH:i:s');
		$stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
		$stmt->execute([ $date, $_SESSION['account_id'] ]);
	}
	// Check for remember me cookie variable and loggedin session variable
    if (isset($_COOKIE['remember_me']) && !empty($_COOKIE['remember_me']) && !isset($_SESSION['account_loggedin'])) {
    	// If the remember me cookie matches one in the database then we can update the session variables.
    	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE remember_me_code = ?');
    	$stmt->execute([ $_COOKIE['remember_me'] ]);
    	$account = $stmt->fetch(PDO::FETCH_ASSOC);
		// If account exists...
    	if ($account) {
    		// Found a match, update the session variables and keep the user logged-in
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
    	} else {
    		// If the user is not remembered redirect to the login page.
    		header('Location: ' . $redirect_file);
    		exit;
    	}
    } else if (!isset($_SESSION['account_loggedin'])) {
    	// If the user is not logged in redirect to the login page.
    	header('Location: ' . $redirect_file);
    	exit;
    }
}
// Send activation email function
function send_activation_email($email, $code) {
	if (!mail_enabled) return;
	// Include PHPMailer library
	include_once 'lib/phpmailer/Exception.php';
	include_once 'lib/phpmailer/PHPMailer.php';
	include_once 'lib/phpmailer/SMTP.php';
	// Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try {
		// Server settings
		if (SMTP) {
			$mail->isSMTP();
			$mail->Host = smtp_host;
			$mail->SMTPAuth = true;
			$mail->Username = smtp_user;
			$mail->Password = smtp_pass;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = smtp_port;
		}
		// Recipients
		$mail->setFrom(mail_from, mail_name);
		$mail->addAddress($email);
		$mail->addReplyTo(mail_from, mail_name);
		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Account Activation Required';
		// Activation link
		$activate_link = base_url . 'activate.php?code=' . $code;
		// Read the template contents and replace the "%link" placeholder with the above variable
		$email_template = str_replace('%link%', $activate_link, file_get_contents('activation-email-template.html'));
		// Email body content
		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,minimum-scale=1"><title>Account Activation Required</title></head><body style="margin:0;padding:0">' . $email_template . '</body></html>';
		// Set email body
		$mail->Body = $body;
		$mail->AltBody = strip_tags($email_template);
		// Send mail
		$mail->send();
	} catch (Exception $e) {
		// Output error message
		exit('Error: Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
	}
}
// Send notification email function
function send_notification_email($account_id, $account_username, $account_email, $account_date) {
	if (!mail_enabled) return;
	// Include PHPMailer library
	include_once 'lib/phpmailer/Exception.php';
	include_once 'lib/phpmailer/PHPMailer.php';
	include_once 'lib/phpmailer/SMTP.php';
	// Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try {
		// Server settings
		if (SMTP) {
			$mail->isSMTP();
			$mail->Host = smtp_host;
			$mail->SMTPAuth = true;
			$mail->Username = smtp_user;
			$mail->Password = smtp_pass;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = smtp_port;
		}
		// Recipients
		$mail->setFrom(mail_from, mail_name);
		$mail->addAddress(notification_email);
		$mail->addReplyTo(mail_from, mail_name);
		// Content
		$mail->isHTML(true);
		$mail->Subject = 'A new user has registered!';
		// Read the template contents and replace the "%link" placeholder with the above variable
		$email_template = str_replace(['%id%','%username%','%date%','%email%'], [$account_id, htmlspecialchars($account_username, ENT_QUOTES), $account_date, $account_email], file_get_contents('notification-email-template.html'));
		// Email body content
		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,minimum-scale=1"><title>A new user has registered!</title></head><body style="margin:0;padding:0">' . $email_template . '</body></html>';
		// Set email body
		$mail->Body = $body;
		$mail->AltBody = strip_tags($email_template);
		// Send mail
		$mail->send();
	} catch (Exception $e) {
		// Output error message
		exit('Error: Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
	}
}
// Send password reset email function
function send_password_reset_email($email, $username, $code) {
	if (!mail_enabled) return;
	// Include PHPMailer library
	include_once 'lib/phpmailer/Exception.php';
	include_once 'lib/phpmailer/PHPMailer.php';
	include_once 'lib/phpmailer/SMTP.php';
	// Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try {
		// Server settings
		if (SMTP) {
			$mail->isSMTP();
			$mail->Host = smtp_host;
			$mail->SMTPAuth = true;
			$mail->Username = smtp_user;
			$mail->Password = smtp_pass;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = smtp_port;
		}
		// Recipients
		$mail->setFrom(mail_from, mail_name);
		$mail->addAddress($email);
		$mail->addReplyTo(mail_from, mail_name);
		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Password Reset';
		// Password reset link
		$reset_link = base_url . 'reset-password.php?code=' . $code;
		// Read the template contents and replace the "%link%" placeholder with the above variable
		$email_template = str_replace(['%link%','%username%'], [$reset_link,htmlspecialchars($username, ENT_QUOTES)], file_get_contents('resetpass-email-template.html'));
		// Email body content
		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,minimum-scale=1"><title>Password Reset</title></head><body style="margin:0;padding:0">' . $email_template . '</body></html>';
		// Set email body
		$mail->Body = $body;
		$mail->AltBody = strip_tags($email_template);
		// Send mail
		$mail->send();
	} catch (Exception $e) {
		// Output error message
		exit('Error: Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
	}
}

// Send contact form email function
function send_contact_email($name, $email, $subject, $message) {
	if (!mail_enabled) return false;
	// Include PHPMailer library
	include_once 'lib/phpmailer/Exception.php';
	include_once 'lib/phpmailer/PHPMailer.php';
	include_once 'lib/phpmailer/SMTP.php';
	// Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try {
		// Server settings
		if (SMTP) {
			$mail->isSMTP();
			$mail->Host = smtp_host;
			$mail->SMTPAuth = true;
			$mail->Username = smtp_user;
			$mail->Password = smtp_pass;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = smtp_port;
		}
		// Recipients
		$mail->setFrom(mail_from, mail_name);
		$mail->addAddress(notification_email); // Send to the site admin
		$mail->addReplyTo($email, $name); // Set reply-to as the sender's email
		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Contact Form: ' . $subject;

		// Get current date
		$date = date('Y-m-d H:i:s');

		// Read the template contents and replace the placeholders with the actual values
		$email_template = str_replace(['%name%', '%email%', '%subject%', '%date%', '%message%'], 
			[htmlspecialchars($name, ENT_QUOTES), htmlspecialchars($email, ENT_QUOTES), htmlspecialchars($subject, ENT_QUOTES), $date, nl2br(htmlspecialchars($message, ENT_QUOTES))], 
			file_get_contents('contact-email-template.html'));

		// Email body content
		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,minimum-scale=1"><title>Contact Form Submission</title></head><body style="margin:0;padding:0">' . $email_template . '</body></html>';

		// Set email body
		$mail->Body = $body;
		$mail->AltBody = "Name: $name\nEmail: $email\nSubject: $subject\nDate: $date\nMessage: $message";

		// Send mail
		$mail->send();
		return true;
	} catch (Exception $e) {
		// Return false on error
		return false;
	}
}
?>
