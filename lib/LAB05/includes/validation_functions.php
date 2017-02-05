<?php

/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 04-Feb-17
 * Time: 8:58 PM
 */
class validation_functions
{
    // Constant declaration
    // ---------------------
    const PHONE_REGEX = "/^[0-9]{3}[ |-]?[0-9]{3}[ |-]?[0-9]{4}$/";


    // Constructor function
    // --------------------
    /*
     * Use of a private constructor, to prevent instantiating this class.
     * This is done on purpose, as I want a static class to act as a library
     */
    private function __construct() { }


    // Public Static Functions
    // -----------------------
    // Function to validate is string is not null or empty
    public static function isNullOrEmpty($value) {
        return !isset($value) || $value === "";
    }

    // Function to validate if email address is in a valid format
    public static function isEmailValid($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    // Function to validate if phone number is in acceptable formats
    public static function isPhoneNumValid($value) {
        return preg_match(self::PHONE_REGEX, $value);
    }

    // Function to test if string isn't below minimum length
    public static function isAboveMinLength($value, $minLength) {
        return strlen($value) >= $minLength;
    }

    // Function to test if string isn't above maximum length
    public static function isBelowMaxLength($value, $maxLength) {
        return strlen($value) <= $maxLength;
    }

    // Function to generate a list of navigation links.
    // [Takes a 2D array[['URL', 'Text'], ['URL', 'Text']] as input]
    public static function generateNavigationList($lstNavLinks) {
        $Navigation = "<ul>";
        // Loop to construct navigation links
        foreach($lstNavLinks as $navItem) {
            $Navigation .= "<li><a href=" . $navItem[0] . ">" . $navItem[1] . "</a></li>";
        }
        $Navigation .= "</ul>";
        return $Navigation;
    }

    // Function to generate option list for dropdown control
    // [Takes array('VALUE' => 'Text') as input and selected value from user]
    public static function generateDropDownOpt($lstOptions, $selectedValue) {
        $dropDownOpt = "";
        foreach($lstOptions as $Value => $Text) {
            $dropDownOpt .= "<option value='$Value' ";
            if($selectedValue === $Value) {
                $dropDownOpt .= "selected";
            }
            $dropDownOpt .= ">$Text</option>";
        }
        return $dropDownOpt;
    }

}