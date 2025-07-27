# Welcome to the Themed PHP User Login and Registration System
## Overview

This system provides a simple themed user login and registration functionality using MySql to store user details.
This script utilizes Brute Force and CSRF protections, as well as being able to use 2FA, and has configurable google and facebook
OAuth logins.

### Current Date
`2025-07-27`

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
- `twofactor-email-template.html`
- `README.md`
- `about.php`
- `activate.php`
- `authenticate.php`
- `avatar.php`
- `config.php`
- `contact.php`
- `facebook-oauth.php`
- `footer.php`
- `forgot-password.php`
- `google-oauth.php`
- `header.php`
- `index.php`
- `login.php`
- `logout.php`
- `main.php`
- `password-expired.php`
- `profile.php`
- `register.php`
- `register-process.php`
- `resend-activation.php`
- `reset-password.php`
- `twofactor.php`
- `mysql.sql`

## PHP User Login and Registration System with MySQL

Written in PHP this script uses MySql to store user details. It has two user roles: admin and member.
I have setup one user for each role with default values. Users and admins can edit their user 
details from the 'edit profile' link in their dashboard.

**User**: Admin\
**Password**: admin

**User**: Member\
**Password**: member

You can add, edit and delete users through the admin panel, or users can register on the website itself.
The script will check to see if the email address has already been used. You can have as many members or admins as you need.

## Password Requirements
For security purposes, all passwords must meet the following requirements:
- Between 8 and 20 characters long
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special character (!@#$%^&*(),.?":{}|<>)

Password strength indicator is included on the registration page.

## Password Age Policy
For enhanced security, passwords expire after 90 days by default. Users will be prompted to change their password upon login if it has expired. This helps ensure that passwords are regularly updated.

To change the maximum password age, modify the `password_max_age` setting in config.php. Set it to 0 to disable the password expiration feature.

#### If you are updating from prior to password age being implemented, a database update is required 
To enable the password age policy, you need to run the following SQL script to add the required column to the database:

```sql
-- Add password_changed column to accounts table
ALTER TABLE accounts ADD COLUMN password_changed datetime DEFAULT NULL;
-- Update existing accounts to set the password_changed date to the current date
UPDATE accounts SET password_changed = NOW();
```

This script is also available in the file `password_age.sql` included with the application.

## Google OAuth Sign In
For google oauth to work you need to configure oauth in your google workspace dashboard, then replace the following in config.php:

- Replace **YOUR_CLIENT_ID** with your google auth client ID\
- Replace **YOUR_SECRET_KEY** with your google auth client secret\
- Replace http://loginregistration-themed.local:8890/google-oauth.php with your website URL/google-oauth.php\

Note that google login has not been tested on a public domain. Use at your own risk.

## Facebook OAuth Sign In
For facebook oauth to work you'll need to create a Facebook App, then replace the following in config.php:

- Replace **YOUR_CLIENT_ID** with your facebook oauth app ID\
- Replace **YOUR_SECRET_KEY** with your facebook oauth app secret\
- Replace http://loginregistration-themed.local:8890/google-oauth.php with your website URL/facebook-oauth.php\

Note that facebook login has not been tested on a public domain. Use at your own risk.
