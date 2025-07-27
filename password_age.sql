-- SQL script to add password_changed column to accounts table
ALTER TABLE accounts ADD COLUMN password_changed datetime DEFAULT NULL;
-- Update existing accounts to set the password_changed date to the current date
UPDATE accounts SET password_changed = NOW();