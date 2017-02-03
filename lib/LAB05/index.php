<?php
    // PHP Include
    require_once 'includes/functions.php';
    require_once 'includes/humberValid.php';

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

        $Valid = new HumberValid();
        $Valid->setEmail($_POST['txt_email']);
        $Valid->setGender($_POST['gender']);
        echo $Valid->validEmail();
        echo $Valid->validGender();



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
        validateName($name, $nameError);
        validateEmail($email, $emailError);
        validatePhoneNumber($phoneNumber, $phoneNumError);
        validateDropDownSelection($location, "NONE", $locationError);
        validateMessage($message, $messageError);

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
