<?php
    // PHP Include
    require_once 'includes/functions.php';
    require_once 'includes/humberValid.php';
    require_once 'includes/validation_functions.php';

    // Initialise variables to hold form field data
    // ---------------------------------
    $name = "";
    $email = "";
    $gender = "M";  // Select Male by default
    $phoneNumber = "";
    $location = "";
    $isInternational = "";
    $message = "";

    // Perform validation only if form has being submitted
    // ---------------------------------------------------

    if(isset($_POST['send-message'])) {
        /*
        $Valid = new HumberValid();
        $Valid->setEmail($_POST['txt_email']);
        $Valid->setGender($_POST['gender']);
        $Valid->setPhone($_POST['phone']);
        echo $Valid->validEmail();
        echo $Valid->validGender();
        echo $Valid->validPhone();
        echo $Valid->validNotEmpty($_POST['txt_email']);
        echo $_POST['chk_international'];
        echo $Valid->validCheck($_POST['chk_international'], "YES");
        */


        //var_dump($_POST);
        //--- Get the data from the form
        $name = $_POST['txt_name'];
        $email = $_POST['txt_email'];
        $gender = $_POST['gender'];
        $phoneNumber = $_POST['txt_phone'];
        $location = $_POST['opt_location'];
        $isInternational = $_POST['chk_international'];
        $message = $_POST['txt_message'];

        //--- Form fields validation
        /*
        validateName($name, $nameError);
        validateEmail($email, $emailError);
        validatePhoneNumber($phoneNumber, $phoneNumError);
        validateDropDownSelection($location, "NONE", $locationError);
        validateMessage($message, $messageError);
        */
        // Perform validations using validation_functions library
        // Validate Name
        if(validation_functions::isNullOrEmpty(trim($name))) {
            $nameError = "Please enter a name";
        }

        // Validate Email Address
        if(validation_functions::isNullOrEmpty(trim($email))) {
            $emailError = "Please enter an email address";
        } elseif (!validation_functions::isEmailValid(trim($email))) {
            $emailError = "Please enter a valid email address";
        }

        // Validate Phone Number
        if(!validation_functions::isPhoneNumValid(trim($phoneNumber))) {
            $phoneNumError = "Please enter a valid phone number";
        }

        // Validate City selection
        if($location === "NONE") {
            $locationError = "Please select a city";
        }

        // Validate User Message
        if(validation_functions::isNullOrEmpty(trim($message))) {
            $messageError = "Please enter a message";
        }

        // If form is valid, perform logic after form submission
        if(!isset($nameError) && !isset($emailError) && !isset($phoneNumError) && !isset($locationError) && !isset($messageError)) {
            header("location: submitted.php?name=" . $name . "&email=" . $email . "");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Lab 5 | Web App Dev 2</title>
		<meta name="description" content="Content of page" />
		<link rel="stylesheet" type="text/css" href="styles/header.css">
		<link rel="stylesheet" type="text/css" href="styles/content.css">
		<link rel="stylesheet" type="text/css" href="styles/footer.css">
	</head>
	<body>

        <!-- --- PAGE HEADER --- -->
        <!-- ------------------- -->
        <?php include_once 'includes/header.php'; ?>


        <!-- --- PAGE BODY --- -->
        <!-- ----------------- -->
        <?php include_once 'includes/survey.php'; ?>


		<!-- --- PAGE FOOTER --- -->
        <!-- ------------------- -->
        <?php include_once 'includes/footer.php'; ?>


		<!-- <script src="scripts/script.js"></script>  DISABLE JAVASCRIPT FOR THE PURPOSE OF THIS LAB -->
	</body>
</html>
