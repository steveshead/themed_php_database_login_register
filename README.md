# Welcome to the Themed PHP User Login and Registration System
## Overview

This system provides a simple themed user login and registration functionality using MySql to store user details.

### Current Date
`2025-07-18`

## Admin Files
- `admin.js`
- `account.php`
- `accounts.php`
- `accounts_export.php`
- `accounts_import.php`
- `email_templates.php`
- `index.php`
- `main.php`
- `roles.php`
- `settings.php`
- `admin.scss`
- `admin.css`

## Main App Files
- `activation-email-template.html`
- `contact-email-template.html`
- `notification-email-template.html`
- `resetpass-email-template.html`
- `README.md`
- `about.php`
- `activate.php`
- `authenticate.php`
- `avatar.php`
- `config.php`
- `contact.php`
- `footer.php`
- `forgot-password.php`
- `google-oauth.php`
- `header.php`
- `index.php`
- `login.php`
- `logout.php`
- `main.php`
- `profile.php`
- `register.php`
- `register-process.php`
- `resend-activation.php`
- `reset-password.php`
- `mysql.sql`

## PHP Databaseless User Login and Registration System

Written in PHP this script uses MySql to store user details. It has two user roles: admin and member.
I have setup one user for each role with default values. Users and admins can edit their user 
details from the 'edit profile' link in their dashboard.

**User**: Admin\
**Password**: admin

**User**: Member\
**Password**: member

You can add, edit and delete users through the admin panel, or users can register on the website itself.
The script will check to see if the email address has already been used. You can have as many members or admins as you need.

## Google OAuth Sign In
For google oauth to work you need to configure oauth in your google workspace dashboard, then replace the following in config.php:

Replace **YOUR_CLIENT_ID** with your google auth client ID\
Replace **YOUR_SECRET_KEY** with your google auth client secret\
Replace http://loginregistration-themed.local:8890/google-oauth.php with your website URL/google-oauth.php\

Note the google login has not been tested on a public domain. Use at your own risk.
