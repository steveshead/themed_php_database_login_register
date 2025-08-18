<?php
/**
 * TOTP (Time-based One-Time Password) Implementation
 * Based on RFC 6238 (https://tools.ietf.org/html/rfc6238)
 */

class TOTP {
    /**
     * Generate a random secret key
     * 
     * @param int $length Length of the secret key
     * @return string Base32 encoded secret key
     */
    public static function generateSecret($length = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[random_int(0, strlen($chars) - 1)];
        }
        
        return $secret;
    }
    
    /**
     * Generate a TOTP code
     * 
     * @param string $secret Base32 encoded secret key
     * @param int $time Current time (Unix timestamp)
     * @param int $digits Number of digits in the code (default: 6)
     * @param int $period Time period for the code in seconds (default: 30)
     * @return string TOTP code
     */
    public static function generateCode($secret, $time = null, $digits = 6, $period = 30) {
        if ($time === null) {
            $time = time();
        }
        
        // Calculate counter value based on time
        $counter = floor($time / $period);
        
        // Decode the secret from base32
        $secret = self::base32Decode($secret);
        
        // Convert counter to binary (64-bit, big-endian)
        $binary = pack('J', $counter);
        
        // Calculate HMAC-SHA1 hash
        $hash = hash_hmac('sha1', $binary, $secret, true);
        
        // Get offset (last 4 bits of the hash)
        $offset = ord($hash[19]) & 0x0F;
        
        // Get 4 bytes from the hash starting at the offset
        $value = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;
        
        // Generate code by taking modulo and padding
        $code = $value % pow(10, $digits);
        
        // Pad with leading zeros if necessary
        return str_pad($code, $digits, '0', STR_PAD_LEFT);
    }
    
    /**
     * Verify a TOTP code
     * 
     * @param string $secret Base32 encoded secret key
     * @param string $code Code to verify
     * @param int $window Time window in periods to check (default: 1)
     * @param int $time Current time (Unix timestamp)
     * @param int $digits Number of digits in the code (default: 6)
     * @param int $period Time period for the code in seconds (default: 30)
     * @return bool True if code is valid, false otherwise
     */
    public static function verifyCode($secret, $code, $window = 1, $time = null, $digits = 6, $period = 30) {
        if ($time === null) {
            $time = time();
        }
        
        // Check codes in the time window
        for ($i = -$window; $i <= $window; $i++) {
            $checkTime = $time + ($i * $period);
            $checkCode = self::generateCode($secret, $checkTime, $digits, $period);
            
            if (hash_equals($checkCode, $code)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Generate a QR code URL for the secret
     * 
     * @param string $issuer Issuer name (e.g., your website name)
     * @param string $accountName Account name (e.g., user's email)
     * @param string $secret Base32 encoded secret key
     * @return string URL for QR code
     */
    public static function getQRCodeUrl($issuer, $accountName, $secret) {
        // Decode inputs in case they're already encoded
        $issuer = urldecode($issuer);
        $accountName = urldecode($accountName);
        $secret = urldecode($secret);

        return "otpauth://totp/{$issuer}:{$accountName}?secret={$secret}&issuer={$issuer}";
    }
    
    /**
     * Decode a base32 encoded string
     * 
     * @param string $base32 Base32 encoded string
     * @return string Decoded string
     */
    private static function base32Decode($base32) {
        $base32 = strtoupper($base32);
        $base32 = str_replace('=', '', $base32);
        
        $mapping = [
            'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7,
            'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15,
            'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23,
            'Y' => 24, 'Z' => 25, '2' => 26, '3' => 27, '4' => 28, '5' => 29, '6' => 30, '7' => 31
        ];
        
        $bits = '';
        for ($i = 0; $i < strlen($base32); $i++) {
            $char = $base32[$i];
            if (isset($mapping[$char])) {
                $bits .= str_pad(decbin($mapping[$char]), 5, '0', STR_PAD_LEFT);
            }
        }
        
        $result = '';
        for ($i = 0; $i + 8 <= strlen($bits); $i += 8) {
            $byte = substr($bits, $i, 8);
            $result .= chr(bindec($byte));
        }
        
        return $result;
    }
}