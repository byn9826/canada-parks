<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once ("../lib/DatabaseAccess.php");

    // TODO: Remove after test
    require_once ("../lib/myLocalhostDB.php");
    $profilePicURL = myLocalhostDB::getProfilePicture(666);

    include_once "../templates/meta.php";
    ?>
    <meta name="author" content="Irfaan">
    <title>Profile Page | Marvel Canada</title>
    <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../static/img/profile/users/custom/jquery.imgareaselect.js"></script>
    <script src="../static/img/profile/users/custom/jquery.form.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- Page Header -->
        <?php include_once "../templates/header.php" ?>

        <!-- Page Body -->
        <main class="container-fluid">
            <div class="row">

                <!-- Left column -->
                <div class="user-details col col-md-3">
                    <!-- Profile Avatar Picture -->
                    <!-- data-src="../static/img/profile/users/custom/default.png" -->
                    <!-- src="../static/img/profile/users/custom/default.png" -->
                    <div class="avatar">
                        <img id="profile_picture"
                             data-src="<?php
                                         if(isset($profilePicURL)) {
                                             echo "../static/img/profile/users/" . $profilePicURL;
                                         } else {
                                             echo "../static/img/profile/users/custom/default.png";
                                         }
                                       ?>"
                             data-holder-rendered="true"
                             src="<?php
                                    if(isset($profilePicURL)) {
                                        echo "../static/img/profile/users/" . $profilePicURL;
                                    } else {
                                        echo "../static/img/profile/users/custom/default.png";
                                    }
                                  ?>"
                             alt="User's avatar or profile picture" />
                        <button type="button" class="btn btn-link" id="change-profile-pic">Change Profile Picture</button>
                    </div>

                    <!-- Profile Name -->
                    <h1 class="name"><span>Irfaan Auhammad</span></h1>

                    <!-- User Personal Details -->
                    <div class="user-info">
                        <div><span class="glyphicon glyphicon-map-marker"></span>205 Humber College Blvd, Etobicoke</div>
                        <div><span class="glyphicon glyphicon-envelope"></span>irfaan@humber.ca</div>
                        <div><span class="glyphicon glyphicon-time"></span>Joined on Jan 30, 2017</div>
                    </div>

                    <!-- Footprint & Wishlist -->
                    <div class="activities row">
                        <div class="col-xs-6">
                            <div><span class="activities__footprint">2</span></div>
                            <div>Footprint</div>
                        </div>
                        <div class="col-xs-6">
                            <div><span class="activities__wishlist">5</span></div>
                            <div>Wishlist</div>
                        </div>
                    </div>
                </div>

                <!-- Right column -->
                <div class="container__tab-content col col-md-9">
                    <!-- Profile & Account navigation -->
                    <nav class="settings-nav">
                        <h2 class="hidden">User settings</h2>
                        <ul class="nav nav-pills">
                            <li class="active"><a data-toggle="tab" href="#tabProfile"><span class="glyphicon glyphicon-user"></span>Profile</a></li>
                            <li><a data-toggle="tab" href="#tabAccount"><span class="glyphicon glyphicon-cog"></span>Account</a></li>
                        </ul>
                    </nav>

                    <div class="tab-content clearfix">
                        <!-- Tab: Profile -->
                        <div id="tabProfile" class="tab-pane fade in active">

                            <!-- User's Personal Details -->
                            <div class="row display-group">
                                <div class="col col-md-12">
                                    <h3>About Me</h3>
                                    <form action="" method="post"> <!-- TODO: form action to update personal details -->
                                        <div class="form-group row">
                                            <label for="inputFirstName" class="col-sm-3 col-form-label">First Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputFirstName" placeholder="Enter your first name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputLastName" class="col-sm-3 col-form-label">Last Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputLastName" placeholder="Enter your last name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Gender</label>
                                            <div class="col-sm-5 gender">
                                                <fieldset>
                                                    <input type="radio" id="radioMale" name="gender" value="M" /><label for="radioMale">Male</label>
                                                    <input type="radio" id="radioFemale" name="gender" value="F" /><label for="radioFemale">Female</label>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDOB" class="col-sm-3 col-form-label">Date of Birth</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputDOB" placeholder="Select date of birth" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="day" class="col-sm-3 col-form-label">City</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputCity" placeholder="Which city do you live?" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputProv" class="col-sm-3 col-form-label">Province</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputProv" placeholder="Which province do you live?" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputNationality" class="col-sm-3 col-form-label">Nationality</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputNationality" placeholder="Where are you from?" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPhone" class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control input-medium bfh-phone" id="inputPhone" data-format="+1 (ddd) ddd-dddd" placeholder="Enter phone number" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputLastTrip" class="col-sm-3 col-form-label">Last Trip</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputLastTrip" placeholder="Where did you last travel to?" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputNextTrip" class="col-sm-3 col-form-label">Next Trip</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputNextTrip" placeholder="Where are you travelling to next?" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputFavourite" class="col-sm-3 col-form-label">Favourite Places</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="5" id="inputFavourite" placeholder="What are your favourite parks and activities?"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="button" class="btn btn-primary" title="Cancel">Cancel</button>
                                                <button type="submit" class="btn btn-primary" title="Click to save your new changes">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <!-- Tab: Account-->
                        <div id="tabAccount" class="tab-pane fade">
                            <div class="account">

                                <!-- Change Password -->
                                <div class="row display-group">
                                    <div class="col col-md-12">
                                        <h3>Change password</h3>
                                        <form action="" method="post"> <!-- TODO: form action to update password -->
                                            <div class="form-group row">
                                                <label for="inputOldPass" class="col-sm-3 col-form-label">Old Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="inputOldPass" placeholder="Enter your current password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputNewPass1" class="col-sm-3 col-form-label">New password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="inputNewPass1" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputNewPass2" class="col-sm-3 col-form-label">Confirm new password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="inputNewPass2" placeholder="Confirm New Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary" title="Click to update your old password">Update Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Update Email -->
                                <div class="row display-group">
                                    <div class="col col-md-12">
                                        <h3>Update Email Address</h3>
                                        <form>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputEmail" value="irfaan1213@gmail.com"> <!-- TODO: Value of current email -->
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary" title="Click to update email address">Update Email</button> <!-- TODO: PHP file to update email -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete account -->
                                <div class="row display-group">
                                    <div class="col col-md-12"> <!-- TODO: Use form to delete user's account -->
                                        <h3>Delete account</h3>
                                        <p>Once you delete your account, there is no going back. Please be certain.</p>
                                        <div><button type="button" class="btn btn-danger" title="Click to delete your account">Delete Account</button></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>  <!-- end of right column div -->

            </div>
        </main>


        <!-- Modal Windows -->
        <!-- ------------- -->
        <!-- Modal to add a new footprint -->
        <div class="modal fade bs-example-modal-lg" id="myNewFootprint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Share a New Footprint Event</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Travelled Today
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                Form collecting data about new footprint ...
                            </div>
                            <div class="col-md-6">
                                Section to allow for images upload ...
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Share</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal window to change profile picture -->
        <div id="profile_pic_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Change Profile Picture</h3>
                    </div>
                    <div class="modal-body">
                        <form id="cropimage" method="post" enctype="multipart/form-data" action="change_pic.php">
                            <strong>Upload Image:</strong> <br><br>
                            <input type="file" name="profile-pic" id="profile-pic" />
                            <input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="666" />
                            <input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
                            <input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
                            <input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
                            <input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
                            <input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
                            <input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
                            <input type="hidden" name="action" value="" id="action" />
                            <input type="hidden" name="image_name" value="" id="image_name" />

                            <div id='preview-profile-pic'></div>
                            <div id="thumbs" style="padding:5px; width:600px"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Footer -->
        <?php include_once "../templates/footer.php" ?>
    </div>
    <script type="text/javascript" src="../static/js/profile.js"></script>
</body>
</html>
