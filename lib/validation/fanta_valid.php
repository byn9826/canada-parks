<?php
//Validation Lib created by Fantastic5 in Canada Parks Project
//Author: Irfaan, Sam, Duc, Navpreet, BAO
class Fanta_Valid
{
    // Constant declaration
    // ---------------------
    const PHONE_REGEX = "/^[0-9]{3}[ |-]?[0-9]{3}[ |-]?[0-9]{4}$/";

    // Public Static Functions
    // -----------------------

    public static function sanitizeUserInput($value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    // Function to validate is string is not null or empty
    public static function isNullOrEmpty($value) {
        $trim_value = trim($value);
        return !isset($value) || $trim_value === "";
    }

    // Function to validate if email address is in a valid format
    public static function isEmailValid($value) {
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL);
    }

    // Function to validate if gender value is male or female
    public static function isGenderValid($value) {
        if(strcasecmp($value, "male") == 0 || strcasecmp($value, "female") == 0) {
            return true;
        } else {
            return false;
        }
    }

    // Function to validate if phone number is in acceptable formats
    public static function isPhoneNumValid($value) {
        return preg_match(self::PHONE_REGEX, trim($value));
    }

    // Function to test if string isn't below minimum length
    public static function isAboveMinLength($value, $minLength) {
        return strlen($value) >= $minLength;
    }

    // Function to test if string isn't above maximum length
    public static function isBelowMaxLength($value, $maxLength) {
        return strlen($value) <= $maxLength;
    }

    // Function to check if a number is in the required range
    public static function isNumberInRange($value, $minValue, $maxValue) {
        return is_numeric($value) && $value >= $minValue && $value <= $maxValue;
    }
}
