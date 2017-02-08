<?php
    //import fanta valid lib
    include_once("../fanta_valid.php");

    // Initialise variables to hold form field data
    // ---------------------------------
    $name = "";
    $email = "";
    $gender = "";
    $phoneNumber = "";
    $postalCode = "";
    $location = "";
    $isInternational = "";
    $message = "";
    $yourself = "";

    // Perform validation only if form has being submitted
    // ---------------------------------------------------

    if(isset($_POST['send-message'])) {

        $name = Fanta_Valid::sanitizeUserInput($_POST['txt_name']);
        $email = Fanta_Valid::sanitizeUserInput($_POST['txt_email']);
        $gender = $_POST['gender'];
        $phoneNumber = Fanta_Valid::sanitizeUserInput($_POST['txt_phone']);
        $postalCode = Fanta_Valid::sanitizeUserInput($_POST['txt_postalcode']);
        $message = Fanta_Valid::sanitizeUserInput($_POST['txt_message']);
        $yourself = Fanta_Valid::sanitizeUserInput($_POST['txt_self']);

        // Perform validations using fanta_valid library
        // Validate Name
        if(Fanta_Valid::isNullOrEmpty($name)) {
            $nameError = "Please enter a name";
        }

        // Validate Email Address
        if(Fanta_Valid::isNullOrEmpty($email)) {
            $emailError = "Please enter an email address";
        } elseif (!Fanta_Valid::isEmailValid(trim($email))) {
            $emailError = "Please enter a valid email address";
        }

        // Validate Gender
        if(Fanta_Valid::isNullOrEmpty($gender)) {
            $genderError = "Please indicate your gender";
        } elseif (!Fanta_Valid::isGenderValid($gender)) {
            $genderError = "Please don't hack our form";
        }

        // Validate Phone Number
        if(Fanta_Valid::isNullOrEmpty($phoneNumber)) {
            $phoneNumError = "Please enter a valid phone number";
        } elseif(!Fanta_Valid::isPhoneNumValid($phoneNumber)) {
            $phoneNumError = "The phone number format is wrong";
        }

        if(Fanta_Valid::isNullOrEmpty($postalCode)) {
            $postalCodeError = "Please enter a valid postal code";
        } elseif(!Fanta_Valid::isPostalCodeValid($postalCode)) {
            $postalCodeError = "The postal code format is wrong";
        }

        // Validate User Message
        if(Fanta_Valid::isNullOrEmpty($message)) {
            $messageError = "Please enter a message";
        } elseif (!Fanta_Valid::isAboveMinLength($message, 10)) {
            $messageError = "Must be more than 10 characters";
        } elseif (!Fanta_Valid::isBelowMaxLength($message, 20)) {
            $messageError = "Should be less than 20 characters";
        }

        //valid self by isNumberInRange Functions
        if(Fanta_Valid::isNullOrEmpty($yourself)) {
            $yourselfError = "Please enter a number";
        } elseif (!Fanta_Valid::isNumberInRange($yourself, 0, 5)) {
            $yourselfError = "Must be a number between 0 - 5";
        }

        // If form is valid, perform logic after form submission
        if(!isset($nameError) && !isset($emailError) && !isset($genderError) && !isset($postalCodeError) && !isset($phoneNumError) && !isset($messageError) && !isset($yourselfError)) {
            $success = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Validation Library Example</title>
		<meta name="description" content="Example page for canada-parks validation lib" />
		<link rel="stylesheet" type="text/css" href="content.css">
	</head>
	<body>
        <main class="main">
            <div class="wrapper">
                <div id="main-success" <?php if(!isset($success)) echo "class='hide'"; ?> >
                    Success! <br />
                    <?php
                        echo "<h4>" . "Your name: " . "$name" . "</h4>";
                        echo "<h4>" . "Your email: " . "$email" . "</h4>";
                        echo "<h4>" . "Your gender: " . "$gender" . "</h4>";
                        echo "<h4>" . "Your phone number: " . "$phoneNumber" . "</h4>";
                        echo "<h4>" . "Your postal code: " . "$postalCode" . "</h4>";
                        echo "<h4>" . "Your message: " . "$message" . "</h4>";
                        echo "<h4>" . "Yourself feel: " . "$yourself" . "</h4>";
                    ?>
                </div>
                <h1>Example Page for fanta_Valid Lib</h1>
                <p>Please take some time to fill out this short survey on Web Development Program. This short survey is an exercise from the HTTP 5202 Web Application Development 2 lab.</p>
                <form name="frmSurvey" action="index.php" method="post" class="survey-from">
                    <div>
                        <div><label for="txt_name" class="label">Your Name<span class="field-required">&nbsp;*</span></label></div>
                        <div><input type="text" id="txt_name" name="txt_name" value="<?php echo $name ?>" placeholder="Enter your name here ..." class="form-input" /></div>
                        <div class="field-required"><?php if(isset($nameError)) {echo $nameError;} ?></div>
                    </div>
                    <div>
                        <div><label for="txt_email" class="label">Email Address<span class="field-required">&nbsp;*</span></label></div>
                        <div><input type="text" id="txt_email" name="txt_email" value="<?php echo $email ?>" placeholder="Enter your email here ..." class="form-input" /></div>
                        <div class="field-required"><?php if(isset($emailError)) {echo $emailError;} ?></div>
                    </div>
                    <fieldset>
                        <legend class="label">Gender</legend>
                        <input type="radio" id="M" value="Male" name="gender" <?php if($gender === 'Male') {echo 'checked';} ?> /><label for="M">Male</label>
                        <input type="radio" id="F" value="Female" name="gender" <?php if($gender === 'Female') {echo 'checked';} ?> /><label for="F">Female</label>
                        <div class="field-required"><?php if(isset($genderError)) {echo $genderError;} ?></div>
                    </fieldset>
                    <div>
                        <div><label for="txt_phone" class="label">Phone Number</label></div>
                        <div><input type="text" id="txt_phone" name="txt_phone" value="<?php echo $phoneNumber ?>" placeholder="647 685 9999" class="form-input" /></div>
                        <div class="field-required"><?php if(isset($phoneNumError)) {echo $phoneNumError;} ?></div>
                    </div>
                    <div>
                        <div><label for="txt_postalcode" class="label">Postal Code</label></div>
                        <div><input type="text" id="txt_postalcode" name="txt_postalcode" value="<?php echo $postalCode ?>" placeholder="R4T 2Z9 or R4T2Z9 or R4T-2Z9" class="form-input" /></div>
                        <div class="field-required"><?php if(isset($postalCodeError)) {echo $postalCodeError;} ?></div>
                    </div>
                    <div>
                        <div><label for="txt_message" class="label">Why do you like Web Development? Must be between 10 - 20 characters<span class="field-required">&nbsp;*</span></label></div>
                        <div><textarea id="txt_message" name="txt_message" placeholder="Enter your message here ..." rows="5" class="form-input"><?php echo $message ?></textarea></div>
                        <div class="field-required"><?php if(isset($messageError)) {echo $messageError;} ?></div>
                    </div>
                    <div>
                        <div><label for="txt_message" class="label">How you feel about yourself. Must be a number between 1-5<span class="field-required">&nbsp;*</span></label></div>
                        <div><textarea id="txt_message" name="txt_self" placeholder="Enter your word here ..." rows="5" class="form-input"><?php echo $yourself ?></textarea></div>
                        <div class="field-required"><?php if(isset($yourselfError)) {echo $yourselfError;} ?></div>
                    </div>
                    <div>
                        <button class="button" type="submit" name="send-message">Submit Survey</button>
                    </div>
                </form>
            </div>
        </main>
	</body>
</html>
