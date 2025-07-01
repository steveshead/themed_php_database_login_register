# Welcome to the PHP User Login and Registration System
## Overview

This system provides a simple user login and registration functionality using MySql to store user details.

### Current Date
`2025-06-23`

## Available Files
- `activation-email-template.html`
- `notification-email-template.html`
- `resetpass-email-template.html`
- `activate.php`
- `authenticate.php`
- `config.php`
- `footer.php`
- `forgot-password.php`
- `header.php`
- `home.php`
- `index.php`
- `logout.php`
- `main.php`
- `profile.php`
- `register-process.php`
- `resend-activation.php`
- `reset-password.php`
- `styles.scss`
- `styles.css`
- `phplogin.sql`

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