<?php
//--- Constants declaration
//--- ---------------------
define("PHONE_REGEX", "/^[0-9]{3}[ |-]?[0-9]{3}[ |-]?[0-9]{4}$/");

//--- Functions declaration
//--- ---------------------
// Function to validate name
function validateName(&$sName, &$sNameError) {
    $sName = trim($sName);
    if(empty($sName)) {
        $sNameError = "Please enter a name";
    }
}

// Function to validate email address
function validateEmail(&$sEmail, &$sEmailError) {
    $sEmail = trim($sEmail);
    if(empty($sEmail)) {
        $sEmailError = "Please enter an email address";
    } elseif (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
        $sEmailError = "Please enter a valid email address";
    }
}

// Function to validate a phone number
function validatePhoneNumber(&$sPhoneNumber, &$sPhoneNumError) {
    $iPhoneNumber = trim($sPhoneNumber);
    if(!empty($sPhoneNumber)) { // Not testing empty because field is not required
        if(!preg_match(PHONE_REGEX, $sPhoneNumber)) {
            $sPhoneNumError = "Please enter a valid phone number";
        }
    }
}

// Function to check if an option is selected from a dropdown
function validateDropDownSelection($sDropDownValue, $sNoSelectionValue, &$sDropDownError) {
    if($sDropDownValue === $sNoSelectionValue) {
        $sDropDownError = "Please select an option";
    }
}

// Function to validate if a message is entered
function validateMessage($sMessage, &$sMessageError) {
    if(empty($sMessage)) {
        $sMessageError = "Please enter a message";
    }
}

// Function to display navigation links
function display_navigation($lstNavLinks) {
    $NavigationItems = "";
    // Loop to construct navigation links
    $NavigationItems .= "<ul>";
    foreach ($lstNavLinks as $navItem) {
        $NavigationItems .= "<li><a href=" . $navItem['navUrl'] . ">" . $navItem['navText'] . "</a></li>";
    }
    return $NavigationItems;
}

// Function to populate options of a dropdown list
/**
 * @param $lstOptions - An array of options as key->value pairs
 * @param $formValue - The value selected by the user when form is submitted
 * @return string - Returns a string of the options
 */
function displayDropDownOptions($lstOptions, $formValue) {
    $DropDownOptions = "";
    foreach($lstOptions as $key => $text) {
        $DropDownOptions .= "<option value='$key' ";
        if($formValue === $key) {
            $DropDownOptions .= "selected";
        }
        $DropDownOptions .= ">$text</option>";
    }
    return $DropDownOptions;
}