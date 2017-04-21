<?php
    session_start();
    // -- If user not signed in, redirect to sign-in page
    // -- -----------------------------------------------
    if (!isset($_SESSION['user_id']))
    {
        header("location: ../signup/index.php");
    }
    require_once '../lib/DatabaseAccess.php';
    require_once '../lib/validation/fanta_valid.php';
    require_once '../lib/profile/UserDetails.php';
    require_once '../lib/profile/UserAccount.php';
    require_once '../lib/profile/Footprints.php';
    require_once '../lib/profile/Wishlist.php';
    require_once '../admin/model/admin.php';
    require_once '../lib/attitude/default.php';


    // -- Create a database connection
    // -- ----------------------------
    $objConnection = DatabaseAccess::getConnection();


    // -- Create an instance of user details & user account for current user
    // -- ------------------------------------------------------------------
    $objUserAccount = new UserAccount($objConnection, $_SESSION['user_id']);
    $objUserDetails = new UserDetails($objConnection, $_SESSION['user_id']);
    $objFootprints = new Footprints($objConnection, $_SESSION['user_id']);
    $objWishlist = new Wishlist($objConnection, $_SESSION['user_id']);
    $iUserDetailsRead = $objUserDetails->Read();
    if($iUserDetailsRead == 0) {
        die("Unable to read user details at the moment.");
    }

    // -- Find number of items in user's footprint
    $lstFootprints = $objFootprints->GetFootprintsDetails();
    $iNbFootprints = count($lstFootprints);
    $lblFootprints = ($iNbFootprints > 1) ? 'Footprint items' : 'Footprint item';

    // Find number of items in user's wishlist
    $lstParksInWishlist = $objWishlist->GetParksIdInWishlist();
    $iNbWishlistItems = count($lstParksInWishlist);
    $lblWishlist = ($iNbWishlistItems > 1) ? 'Wishlist items' : 'Wishlist item';


    // -- Update user details if user submitted new changes
    // -- -------------------------------------------------
    $iRowUpdated = NULL;
    // Operations on form submit
    if(isset($_POST['submitDetails'])) {
        // Capture and sanitize form data
        $firstName = Fanta_Valid::sanitizeUserInput($_POST['txtFirstName']);
        $lastName = Fanta_Valid::sanitizeUserInput($_POST['txtLastName']);
        if(isset($_POST['gender'])) {
            $gender = $_POST['gender'];
        } else {
            $gender = NULL;
        }
        $dateOfBirth = Fanta_Valid::sanitizeUserInput($_POST['dDOB']);
        $add = Fanta_Valid::sanitizeUserInput($_POST['txtAddress']);
        $city = Fanta_Valid::sanitizeUserInput($_POST['txtCity']);
        $province = Fanta_Valid::sanitizeUserInput($_POST['txtProvince']);
        $nationality = Fanta_Valid::sanitizeUserInput($_POST['txtNationality']);
        $phoneNumber = Fanta_Valid::sanitizeUserInput($_POST['txtPhoneNumber']);
        $lastTrip = Fanta_Valid::sanitizeUserInput($_POST['txtLastTrip']);
        $nextTrip = Fanta_Valid::sanitizeUserInput($_POST['txtNextTrip']);
        $favPlaces = Fanta_Valid::sanitizeUserInput($_POST['txtFavPlaces']);

        // Perform validation of data submitted
        if(!Fanta_Valid::isNullOrEmpty($firstName) && !Fanta_Valid::isNameValid($firstName)) {
            $errFirstName = "Please enter a valid first name";
        }
        if(!Fanta_Valid::isNullOrEmpty($lastName) && !Fanta_Valid::isNameValid($lastName)) {
            $errLastName = "Please enter a valid last name";
        }
        if(!Fanta_Valid::isNullOrEmpty($add) && !Fanta_Valid::isNameValid($add)) {
            $errAddress = "Please enter a valid street address";
        }
        if(!Fanta_Valid::isNullOrEmpty($city) && !Fanta_Valid::isNameValid($city)) {
            $errCity = "Please enter a valid city";
        }
        if(!Fanta_Valid::isNullOrEmpty($province) && !Fanta_Valid::isNameValid($province)) {
            $errProvince = "Please enter a valid province";
        }
        if(!Fanta_Valid::isNullOrEmpty($nationality) && !Fanta_Valid::isNameValid($nationality)) {
            $errNationality = "Please enter a valid nationality";
        }
        if(!Fanta_Valid::isNullOrEmpty($phoneNumber) && !Fanta_Valid::isPhoneNumValid($phoneNumber)) {
            $errPhoneNumber = "Please enter a valid phone number";
        }

        // Update properties of current user details object
        $objUserDetails->setFirstName($firstName);
        $objUserDetails->setLastName($lastName);
        $objUserDetails->setGender($gender);
        $objUserDetails->setDateOfBirth($dateOfBirth);
        $objUserDetails->setAddress($add);
        $objUserDetails->setCity($city);
        $objUserDetails->setProvince($province);
        $objUserDetails->setNationality($nationality);
        $objUserDetails->setPhoneNumber($phoneNumber);
        $objUserDetails->setLastTrip($lastTrip);
        $objUserDetails->setNextTrip($nextTrip);
        $objUserDetails->setFavouritePlaces($favPlaces);

        // Perform update if form pass validation
        if(!isset($errFirstName) && !isset($errLastName) && !isset($errAddress) &&
           !isset($errCity) && !isset($errProvince) && !isset($errNationality) && !isset($errPhoneNumber)) {
            $iRowUpdated = $objUserDetails->Update();
            if($iRowUpdated == 1) {
                $UpdateReport = "Your details have been successfully updated.";
            } else {
                $UpdateReport = "An error occurred while trying to update your details. Please try again.";
            }
        }
    }


    // -- Update account password
    // -- -----------------------
    if(isset($_POST['updatePassword'])) {
        // Flag indicating if form passes validation
        $fFormValid = true;

        // Capture form data
        $oldPassword = Fanta_Valid::sanitizeUserInput($_POST['oldPassword']);
        $newPassword = Fanta_Valid::sanitizeUserInput($_POST['newPassword']);
        $confirmNewPassword = Fanta_Valid::sanitizeUserInput($_POST['confirmNewPassword']);

        // Encrypt new password
        $encryptedPassword = sha1($newPassword);

        // -- Perform validation of data submitted
        # 1. Validate old password entered
        if(Fanta_Valid::isNullOrEmpty($oldPassword)) {
            $errOldPassword = "Please enter the current password";
            $fFormValid = false;
        } elseif (strcmp($objUserAccount->getPassword(), sha1($oldPassword)) !== 0) {
            $errOldPassword = "Incorrect password entered";
            $fFormValid = false;
        }

        # 2. Validate new password entered
        if(Fanta_Valid::isNullOrEmpty($newPassword)) {
            $errNewPassword = "Please enter a new password";
            $fFormValid = false;
        } elseif (strcmp($objUserAccount->getPassword(), $encryptedPassword) === 0) {
            $errNewPassword = "New password must be different from the old password";
            $fFormValid = false;
        }

        # 3. Validate confirm password
        if(Fanta_Valid::isNullOrEmpty($confirmNewPassword)) {
            $errConfirmPassword = "Please re-enter the new password again";
            $fFormValid = false;
        } elseif (strcmp($newPassword, $confirmNewPassword) !== 0) {
            $errConfirmPassword = "Confirm password does not match new password";
            $fFormValid = false;
        }

        // -- If form passes validation, update password
        if($fFormValid) {
            # Send new value to object
            $objUserAccount->setPassword($encryptedPassword);
            # Update account info
            $fRowUpdated = $objUserAccount->Update();
            if($fRowUpdated) {
                $updatePasswordSuccess = "Your password has been successfully updated.";
            } else {
                $updatePasswordError = "Error: Unable to update your password.";
            }
        }

        // Indicate which tab to show
        $tabAccount = true;
    }


    // -- Update account email
    // -- --------------------
    if(isset($_POST['updateEmail'])) {
        // Flag indicating if form passes validation
        $fFormValid = true;

        // Capture form data
        $newEmail = Fanta_Valid::sanitizeUserInput($_POST['newEmail']);
        $password = Fanta_Valid::sanitizeUserInput($_POST['password']);

        // -- Perform validation of data submitted
        # 1. Validate new email address
        if(Fanta_Valid::isNullOrEmpty($newEmail)) {
            $errNewEmail = "Please enter an email address";
            $fFormValid = false;
        } elseif(strcmp($objUserAccount->getEmail(), $newEmail) === 0) {
            $errNewEmail = "You already registered this e-mail";
            $fFormValid = false;
        } elseif (!Fanta_Valid::isEmailValid($newEmail)) {
            $errNewEmail = "Please enter a valid email address";
            $fFormValid = false;
        }

        # 2. Validate password
        if(Fanta_Valid::isNullOrEmpty($password)) {
            $errPassword = "Please enter your password";
            $fFormValid = false;
        } elseif (strcmp($objUserAccount->getPassword(), sha1($password)) !== 0) {
            $errPassword = "Incorrect password entered";
            $fFormValid = false;
        }

        // If form passes validation, update email address
        if($fFormValid) {
            # Send new email to object
            $objUserAccount->setEmail($newEmail);
            # Update account info
            $fRowUpdated = $objUserAccount->Update();
            if($fRowUpdated) {
                $updateEmailSuccess = "Your new e-mail has been successfully updated.";
            } else {
                $updateEmailError = "Error: Unable to update your e-mail address.";
            }
        }

        // Indicate which tab to show
        $tabAccount = true;
    }


    // -- Delete user account
    // -- -------------------
    if(isset($_POST['deleteAccount'])) {

        try {
            // Delete account
            $objUserAccount->deleteAccountPermanently();

            // Logout user and redirect to homepage
            session_unset($_SESSION['user_id']);
            session_unset($_SESSION['user_name']);
            session_destroy();
            header("location: ../");
            exit();

        } catch(PDOException $e) {
            // handle exception
            echo "Error Deleting Account";
        }
    }


    // -- Default tab to open
    if(!isset($tabAccount)) {
        $tabProfile = true;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "../templates/meta.php"; ?>
    <meta name="author" content="Irfaan">
    <title>Profile Settings | Marvel Canada</title>
    <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../static/img/profile/users/custom/jquery.imgareaselect.js"></script>
    <script src="../static/img/profile/users/custom/jquery.form.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- Page Header -->
        <?php include_once "../templates/header.php" ?>

        <!-- Page Body -->
        <main class="container-fluid">
            <div class="row col-md-10 col-md-offset-1">

                <!-- Left column -->
                <div class="col-sm-3 user-sidebar">
                    <div class="user-details">
                        <!-- Profile Avatar Picture -->
                        <div class="avatar">
                            <img id="profile_picture"
                                 data-src="<?php echo $objUserDetails->getProfilePictureURL(); ?>"
                                 data-holder-rendered="true"
                                 src="<?php echo $objUserDetails->getProfilePictureURL(); ?>"
                                 alt="User's avatar or profile picture" />
                            <div>
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#profile_pic_modal" id="change-profile-pic">Change Profile Picture</button>
                            </div>
                        </div>

                        <!-- Profile Name -->
                        <h1 class="name">
                            <span>
                                <?php
                                    echo ($objUserDetails->getFullName() != "")?
                                          $objUserDetails->getFullName() :
                                          ucwords($_SESSION['user_name']);
                                ?>
                            </span>
                        </h1>

                        <!-- User Personal Details -->
                        <div class="user-info">
                            <div><span class="glyphicon glyphicon-map-marker ai-glyphicon"></span><?php echo $objUserDetails->getAddress(); ?></div>
                            <div><span class="glyphicon glyphicon-envelope ai-glyphicon"></span><?php echo $objUserAccount->getEmail(); ?></div>
                            <div><span class="glyphicon glyphicon-time ai-glyphicon"></span><?php echo $objUserDetails->getJoinedOn(); ?></div>
                        </div>

                        <!-- Footprint & Wishlist -->
                        <div class="activities row">
                            <div class="col-xs-6">
                                <a href="." title="View my footprints">
                                    <div><span class="activities__footprint"><?php echo $iNbFootprints ?></span></div>
                                    <div><?php echo $lblFootprints ?></div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a href="index.php?wishlist=true" title="View parks in wish list">
                                    <div><span class="activities__wishlist"><?php echo $iNbWishlistItems ?></span></div>
                                    <div><?php echo $lblWishlist ?></div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right column -->
                <div class="col-sm-9">
                    <div class="container__tab-content">

                        <!-- Profile & Account navigation -->
                        <nav class="settings-nav">
                            <h2 class="hidden">User settings</h2>
                            <ul class="nav nav-pills">
                                <li <?php if(isset($tabProfile)) { echo 'class="active"'; } ?> >
                                    <a data-toggle="tab" href="#tabProfile">
                                        <span class="glyphicon glyphicon-user ai-glyphicon"></span>Profile
                                    </a>
                                </li>
                                <li <?php if(isset($tabAccount)) { echo 'class="active"'; } ?> >
                                    <a data-toggle="tab" href="#tabAccount">
                                        <span class="glyphicon glyphicon-cog ai-glyphicon"></span>Account
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <div class="tab-content clearfix">
                            <!-- Tab: Profile -->
                            <div id="tabProfile" class="tab-pane fade <?php if(isset($tabProfile)) { echo 'in active'; } ?> ">

                                <!-- User's Personal Details -->
                                <div class="row display-group">
                                    <div class="col col-md-12">
                                        <h3>About Me</h3>
                                        <form name="frmUserDetails" action="settings.php" method="post">
                                            <!-- Golobal error message if update fails -->
                                            <div class="form-group row">
                                                <div class=" col-sm-12 <?php echo ($iRowUpdated == 0)? 'text-danger' : 'text-success' ?>">
                                                    <?php if(isset($UpdateReport)) { echo $UpdateReport; } ?>
                                                </div>
                                            </div>
                                            <!-- First Name -->
                                            <div class="form-group row">
                                                <label for="inputFirstName" class="col-sm-3 col-form-label">First Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputFirstName"
                                                           name="txtFirstName" placeholder="Enter your first name"
                                                           value="<?php echo $objUserDetails->getFirstName(); ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger">
                                                    <?php if(isset($errFirstName)) { echo $errFirstName; } ?>
                                                </div>
                                            </div>
                                            <!-- Last Name -->
                                            <div class="form-group row">
                                                <label for="inputLastName" class="col-sm-3 col-form-label">Last Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputLastName"
                                                           name="txtLastName" placeholder="Enter your last name"
                                                           value="<?php echo $objUserDetails->getLastName(); ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger"><?php if(isset($errLastName)) { echo $errLastName; } ?></div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Gender</label>
                                                <div class="col-sm-5 gender">
                                                    <fieldset>
                                                        <input type="radio" id="radioMale" name="gender"
                                                               value="M" <?php if($objUserDetails->getGender() == 'M') { echo 'checked'; } ?> />
                                                        <label for="radioMale">Male</label>
                                                        <input type="radio" id="radioFemale" name="gender"
                                                               value="F" <?php if($objUserDetails->getGender() == 'F') { echo 'checked'; } ?> />
                                                        <label for="radioFemale">Female</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <!-- Date of Birth -->
                                            <div class="form-group row">
                                                <label for="inputDOB" class="col-sm-3 col-form-label">Date of Birth</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputDOB"
                                                           name="dDOB" placeholder="Select date of birth"
                                                           value="<?php echo $objUserDetails->getDateOfBirth(); ?>" />
                                                </div>
                                            </div>
                                            <!-- Address -->
                                            <div class="form-group row">
                                                <label for="day" class="col-sm-3 col-form-label">Street Address</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputCity"
                                                           name="txtAddress" placeholder="Street Address"
                                                           value="<?php
                                                                    echo ($objUserDetails->getAddress() !== UserDetails::sADDRESS_NOT_AVAILABLE)?
                                                                          $objUserDetails->getAddress() :
                                                                          '';
                                                                  ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger">
                                                    <?php if(isset($errAddress)) { echo $errAddress; } ?>
                                                </div>
                                            </div>
                                            <!-- City -->
                                            <div class="form-group row">
                                                <label for="day" class="col-sm-3 col-form-label">City</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputCity"
                                                           name="txtCity" placeholder="Which city do you live?"
                                                           value="<?php echo $objUserDetails->getCity(); ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger">
                                                    <?php if(isset($errCity)) { echo $errCity; } ?>
                                                </div>
                                            </div>
                                            <!-- Province -->
                                            <div class="form-group row">
                                                <label for="inputProv" class="col-sm-3 col-form-label">Province</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputProv"
                                                           name="txtProvince" placeholder="Which province do you live?"
                                                           value="<?php echo $objUserDetails->getProvince(); ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger">
                                                    <?php if(isset($errProvince)) { echo $errProvince; } ?>
                                                </div>
                                            </div>
                                            <!-- Nationality -->
                                            <div class="form-group row">
                                                <label for="inputNationality" class="col-sm-3 col-form-label">Nationality</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputNationality"
                                                           name="txtNationality" placeholder="Where are you from?"
                                                           value="<?php echo $objUserDetails->getNationality(); ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger">
                                                    <?php if(isset($errNationality)) { echo $errNationality; } ?>
                                                </div>
                                            </div>
                                            <!-- Phone Number -->
                                            <div class="form-group row">
                                                <label for="inputPhone" class="col-sm-3 col-form-label">Phone Number</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control input-medium bfh-phone" id="inputPhone"
                                                           name="txtPhoneNumber" data-format="+1 (ddd) ddd-dddd" placeholder="Enter phone number"
                                                           value="<?php echo $objUserDetails->getPhoneNumber(); ?>" />
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-3 text-danger">
                                                    <?php if(isset($errPhoneNumber)) { echo $errPhoneNumber; } ?>
                                                </div>
                                            </div>
                                            <!-- Last Trip -->
                                            <div class="form-group row">
                                                <label for="inputLastTrip" class="col-sm-3 col-form-label">Last Trip</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputLastTrip"
                                                           name="txtLastTrip" placeholder="Where did you last travel to?"
                                                           value="<?php echo $objUserDetails->getLastTrip(); ?>" />
                                                </div>
                                            </div>
                                            <!-- Next Trip -->
                                            <div class="form-group row">
                                                <label for="inputNextTrip" class="col-sm-3 col-form-label">Next Trip</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputNextTrip"
                                                           name="txtNextTrip" placeholder="Where are you travelling to next?"
                                                           value="<?php echo $objUserDetails->getNextTrip(); ?>" />
                                                </div>
                                            </div>
                                            <!-- Favourite Places -->
                                            <div class="form-group row">
                                                <label for="inputFavourite" class="col-sm-3 col-form-label">Favourite Places</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="5" id="inputFavourite"
                                                              name="txtFavPlaces" placeholder="What are your favourite parks and activities?"
                                                    ><?php echo $objUserDetails->getFavouritePlaces(); ?></textarea>
                                                </div>
                                            </div>
                                            <!-- CANCEL & SUBMIT Buttons -->
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary" name="resetForm" title="Cancel">Cancel</button>
                                                    <button type="submit" class="btn btn-primary" name="submitDetails" title="Click to save your new changes">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Email Subscriber -->
                                <!-- Author: Duc      -->
                                <div class="row display-group">
                                    <div class="col col-md-12">
                                        <h3>Email Subscriber</h3>
                                        <p>
                                            Select "Subscribed" will help user to receive emails about the update information from website.
                                        </p>
                                        <p>
                                            User is also available to get emails relates to the parks in user's wishlist.
                                        </p>
                                        <?php
                                        $user = AdminUser::checkEmailSubscribe($db, $_SESSION['user_id']);
                                        $checked = ($user->email_subscribed == 1) ? "checked" : ""
                                        ?>
                                            <input id="subscribe-email" type="checkbox" data-toggle="toggle" data-on="Subscribed" data-off="Unsubscribed" <?php echo $checked; ?>>
                                    </div>
                                </div>

                                <script>
                                    $('#subscribe-email').change(function() {
                                        $.post('../admin/admin-email-subscribed.php', { userId : <?php echo $_SESSION['user_id']; ?>}, function(data){
                                        });
                                    })
                                </script>
                            </div>

                            <!-- Tab: Account-->
                            <div id="tabAccount" class="tab-pane fade <?php if(isset($tabAccount)) { echo 'in active'; } ?> ">
                                <div class="account">

                                    <!-- Change Password -->
                                    <div class="row display-group">
                                        <div class="col col-md-12">
                                            <h3>Change password</h3>
                                            <form action="settings.php" method="post" name="frmUpdatePassword">
                                                <!-- Golobal error message if update fails -->
                                                <div class="form-group row">
                                                    <div class=" col-sm-12 <?php echo (isset($updatePasswordSuccess))? 'text-success' : 'text-danger' ?>">
                                                        <?php
                                                            if(isset($updatePasswordSuccess)) {
                                                                echo $updatePasswordSuccess;
                                                            } elseif (isset($updatePasswordError)) {
                                                                echo $updatePasswordError;
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- Enter Old/Current Password -->
                                                <div class="form-group row">
                                                    <label for="inputOldPass" class="col-sm-3 col-form-label">Old Password</label>
                                                    <div class="col-sm-5">
                                                        <input type="password" class="form-control" id="inputOldPass" name="oldPassword"
                                                               placeholder="Enter your current password"
                                                               value="<?php if(isset($oldPassword) && !isset($updatePasswordSuccess)) { echo $oldPassword; } ?>">
                                                    </div>
                                                    <div id="errOldPass" class="col-sm-9 col-sm-offset-3 text-danger">
                                                        <?php if(isset($errOldPassword)) { echo $errOldPassword; } ?>
                                                    </div>
                                                </div>
                                                <!-- Enter New Password -->
                                                <div class="form-group row">
                                                    <label for="inputNewPass1" class="col-sm-3 col-form-label">New password</label>
                                                    <div class="col-sm-5">
                                                        <input type="password" class="form-control" id="inputNewPass1" name="newPassword"
                                                               placeholder="New Password"
                                                               value="<?php if(isset($newPassword) && !isset($updatePasswordSuccess)) { echo $newPassword; } ?>">
                                                    </div>
                                                    <div id="errNewPass" class="col-sm-9 col-sm-offset-3 text-danger">
                                                        <?php if(isset($errNewPassword)) { echo $errNewPassword; } ?>
                                                    </div>
                                                </div>
                                                <!-- Enter New Password Again -->
                                                <div class="form-group row">
                                                    <label for="inputNewPass2" class="col-sm-3 col-form-label">Confirm new password</label>
                                                    <div class="col-sm-5">
                                                        <input type="password" class="form-control" id="inputNewPass2" name="confirmNewPassword"
                                                               placeholder="Confirm New Password"
                                                               value="<?php if(isset($confirmNewPassword) && !isset($updatePasswordSuccess)) { echo $confirmNewPassword; } ?>">
                                                    </div>
                                                    <div id="errConfirmNewPass" class="col-sm-9 col-sm-offset-3 text-danger">
                                                        <?php if(isset($errConfirmPassword)) { echo $errConfirmPassword; } ?>
                                                    </div>
                                                </div>
                                                <!-- Button: Update Password -->
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-primary"
                                                                id="btnUpdatePassword" name="updatePassword"
                                                                title="Click to update your old password">Update Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Update Email -->
                                    <div class="row display-group">
                                        <div class="col col-md-12">
                                            <h3>Update Email Address</h3>
                                            <form action="settings.php" method="post" name="frmUpdateEmail">
                                                <!-- Golobal error message if update fails -->
                                                <div class="form-group row">
                                                    <div class=" col-sm-12 <?php echo (isset($updateEmailSuccess))? 'text-success' : 'text-danger' ?>">
                                                        <?php
                                                        if(isset($updateEmailSuccess)) {
                                                            echo $updateEmailSuccess;
                                                        } elseif (isset($updateEmailError)) {
                                                            echo $updateEmailError;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- Enter New Email -->
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-3 col-form-label">New Email</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="inputEmail" name="newEmail"
                                                               value="<?php
                                                                        if(isset($newEmail)) {
                                                                            echo $newEmail;
                                                                        } else {
                                                                            echo $objUserAccount->getEmail();
                                                                        }
                                                                      ?>">
                                                    </div>
                                                    <div id="errEmail" class="col-sm-9 col-sm-offset-3 text-danger">
                                                        <?php if(isset($errNewEmail)) { echo $errNewEmail; } ?>
                                                    </div>
                                                </div>
                                                <!-- Enter Password -->
                                                <div class="form-group row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                                                    <div class="col-sm-5">
                                                        <input type="password" class="form-control" id="inputPassword" name="password"
                                                               placeholder="Enter Password"
                                                               value="<?php if(isset($password) && !isset($updateEmailSuccess)) { echo $password; } ?>">
                                                    </div>
                                                    <div id="errPassword" class="col-sm-9 col-sm-offset-3 text-danger">
                                                        <?php if(isset($errPassword)) { echo $errPassword; } ?>
                                                    </div>
                                                </div>
                                                <!-- Button: Update Email Address -->
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-primary" name="updateEmail"
                                                                title="Click to update email address">Update Email</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete account -->
                                    <div class="row display-group">
                                        <div class="col col-md-12">
                                            <h3>Delete account</h3>
                                            <p>Once you delete your account, there is no going back. Please be certain.</p>
                                            <div>
                                                <form action="settings.php" method="post">
                                                    <button type="submit" class="btn btn-danger" name="deleteAccount"
                                                            title="Click to delete your account"
                                                            onclick="return confirm('Are you sure you want to delete your account?\nThis action is irreversible and you will lose all your footprints and wishlist items.');">Delete Account</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>  <!-- end of right column div -->

            </div>
        </main>

        <!-- Modal window to change profile picture -->
        <div id="profile_pic_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Change Profile Picture</h3>
                    </div>
                    <div class="modal-body">
                        <form id="cropimage" method="post" enctype="multipart/form-data" action="change_pic.php">
                            <strong>Upload Image:</strong>
                            <input type="file" name="profile-pic" id="profile-pic" />
                            <input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="<?php echo $_SESSION['user_id']; ?>" />
                            <input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
                            <input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
                            <input type="hidden" name="hdn-x2-axis" id="hdn-x2-axis" value="" />
                            <input type="hidden" name="hdn-y2-axis" id="hdn-y2-axis" value="" />
                            <input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
                            <input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
                            <input type="hidden" name="action" id="action" value="" />
                            <input type="hidden" name="image_name" id="image_name" value="" />

                            <div id='preview-profile-pic'></div>
                            <div id="thumbs" style="padding:5px; width:600px"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel_change" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Footer -->
        <?php include_once "../templates/footer.php" ?>
    </div>
    <script type="text/javascript" src="../static/js/profileSettings.js"></script>
</body>
</html>
