<?php
class Sanitizer {
    public static function sanitizeString($value) {
        return trim(strip_tags($value));
    }

    public static function sanitizeEmail($email) {
        return trim(filter_var($email, FILTER_SANITIZE_EMAIL));
    }

    public static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function passwordsMatch($pass1, $pass2) {
        return $pass1 === $pass2;
    }
}
?>