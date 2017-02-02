<?php
    // Array to store location options
    $lstLocations = ['NONE' => '-- Choose a Town --',
                     'TO' => 'Toronto',
                     'RE' => 'Rexdale',
                     'NY' => 'North York',
                     'SC' => 'Scarborough',
                     'MI' => 'Mississauga',
                     'BR' => 'Brampton',
                     'VA' => 'Vaughan',
                     'MA' => 'Markham',
                     'RH' => 'Richmond Hill',
                     'OT' => 'Others'
                    ];
?>
<main class="main">
    <div class="wrapper">
        <p>Please take some time to fill out this short survey on Web Development Program. This short survey is an exercise from the HTTP 5202 Web Application Development 2 lab.</p>
        <form name="frmSurvey" action="index.php" method="post" class="survey-from">
            <div>
                <div><label for="txt_name" class="label">Your Name<span class="field-required">&nbsp;*</span></label></div>
                <div><input type="text" id="txt_name" name="txt_name" value="<?php echo $name ?>" placeholder="Enter your name here ..." class="form-input" /></div>
                <div id="no-name" class="validation-error">Please enter a name</div>
                <div class="field-required"><?php if(isset($nameError)) {echo $nameError;} ?></div>
            </div>
            <div>
                <div><label for="txt_email" class="label">Email Address<span class="field-required">&nbsp;*</span></label></div>
                <div><input type="text" id="txt_email" name="txt_email" value="<?php echo $email ?>" placeholder="Enter your email here ..." class="form-input" /></div>
                <div id="no-email" class="validation-error">Please enter an email address</div>
                <div class="field-required"><?php if(isset($emailError)) {echo $emailError;} ?></div>
            </div>
            <fieldset>
                <legend class="label">Gender</legend>
                <input type="radio" id="M" value="M" name="gender" <?php if($gender === 'M') {echo 'checked';} ?> /><label for="M">Male</label>
                <input type="radio" id="F" value="F" name="gender" <?php if($gender === 'F') {echo 'checked';} ?> /><label for="F">Female</label>
            </fieldset>
            <div>
                <div><label for="txt_phone" class="label">Phone Number</label></div>
                <div><input type="text" id="txt_phone" name="txt_phone" value="<?php echo $phoneNumber ?>" placeholder="647 685 9999" class="form-input" /></div>
                <div id="wrong-phone" class="validation-error">Please enter a valid phone number</div>
                <div class="field-required"><?php if(isset($phoneNumError)) {echo $phoneNumError;} ?></div>
            </div>
            <div>
                <div><label for="location" class="label">Where do you come from?<span class="field-required">&nbsp;*</span></label></div>
                <div>
                    <select id="location" name="opt_location" class="form-input">
                    <?php
                        echo displayDropDownOptions($lstLocations, $location);
                    ?>
                    </select>
                </div>
                <div id="no-location" class="validation-error">Please select where you come from</div>
                <div class="field-required"><?php if(isset($locationError)) {echo $locationError;} ?></div>
            </div>
            <div>
                <!-- This is added so that even if the checkbox is not checked, there is always a value in the $_POST array -->
                <input type="hidden" name="chk_international" value="NO" />
                <input type="checkbox" id="chk_international" name="chk_international" value="YES" <?php if($isInternational === 'YES') echo 'checked'; ?> />
                <label for="chk_international" class="label">&nbsp;Are you an international student at Humber?</label>
            </div>
            <div>
                <div><label for="txt_message" class="label">Why do you like Web Development?<span class="field-required">&nbsp;*</span></label></div>
                <div><textarea id="txt_message" name="txt_message" placeholder="Enter your message here ..." rows="5" class="form-input"><?php echo $message ?></textarea></div>
                <div id="no-msg" class="validation-error">Please enter a message</div>
                <div class="field-required"><?php if(isset($messageError)) {echo $messageError;} ?></div>
            </div>
            <div>
                <button class="button" type="submit" name="send-message">Submit Survey</button>
            </div>
        </form>
    </div>    
</main>