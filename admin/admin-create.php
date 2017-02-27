<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    require_once "../lib/validation/fanta_valid.php";

    $fname = "";
    $lname = "";
    $email = "";
    $pwd = "";
    $pwd_confirm = "";
    $gender = "";

    if (isset($_POST['submit'])){
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $pwd_confirm = $_POST['confirmpwd'];
        $gender = $_POST['gender'];

        $ok = true;

        if(Fanta_Valid::isNullOrEmpty($fname)) {
            $fnameError = "Please enter your first name";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($lname)) {
            $lnameError = "Please enter your last name";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($email)) {
            $emailError = "Please enter an email address";
            $ok = false;
        } elseif (!Fanta_Valid::isEmailValid(trim($email))) {
            $emailError = "Please enter a valid email address";
            $ok = false;
        } elseif(AdminUser::checkEmailExisted($email)) {
            $ok = false;
            $emailError = "This email is already registered";
        }

        if(Fanta_Valid::isNullOrEmpty($pwd)) {
            $pwdError = "Please enter your password";
            $ok = false;
        }

        if($pwd_confirm !== $pwd) {
            $pwd_confirmError = "Password doesn't match. Please try again";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($gender)) {
            $genderError = "Please indicate your gender";
            $ok = false;
        } elseif (!Fanta_Valid::isGenderValid($gender)) {
            $genderError = "Invalid gender";
            $ok = false;
        }

        if ($ok){
            $myAdmin = new AdminUser($fname, $lname, $gender, $email, $pwd);
            $row = $myAdmin->addNewAdmin($myAdmin->getFirstName(), $myAdmin->getLastName(), $myAdmin->getEmail(), $myAdmin->getPassword(), $myAdmin->getGender());
            var_dump($myAdmin);
            var_dump($row);
            if($row == 1){
                header("Location: admin-list.php");
            } else {
                echo "Something went wrong! Please try again!";
            }
        }
    }
?>

<h1>New Admin</h1>
<form class="form-horizontal" method="post" action="admin-create.php">
    <fieldset>
       <legend>Create new user</legend>

        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email ?>" />
                <br/><span><?php if (isset($emailError)) echo "$emailError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" value="<?php echo $pwd ?>" />
                <br/><span><?php if (isset($pwdError)) echo "$pwdError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Confirm Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="confirmpwd" placeholder="Confirm password again" name="confirmpwd" value="<?php echo $pwd_confirm ?>" />
                <br/><span><?php if (isset($pwd_confirmError)) echo "$pwd_confirmError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="firstname">First Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="firstname" placeholder="Enter first name" name="firstname" value="<?php echo $fname ?>" />
                <br/><span><?php if (isset($fnameError)) echo "$fnameError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="lastname">Last Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="lastname" placeholder="Enter last name" name="lastname" value="<?php echo $lname ?>" />
                <br/><span><?php if (isset($lnameError)) echo "$lnameError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="gender">Gender:</label>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="gender" value="male" <?php if($gender === 'male') {echo 'checked';} ?> >Male</label>
                <label class="radio-inline"><input type="radio" name="gender" value="female" <?php if($gender === 'female') {echo 'checked';} ?> >Female</label>
                <br/><span><?php if (isset($genderError)) echo "$genderError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" name="submit">Create</button>
                <a class="btn btn-default" href="admin-list.php">Cancel</a>
            </div>
        </div>
    </fieldset>
</form>
