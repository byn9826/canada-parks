<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    require_once "../lib/validation/fanta_valid.php";

    $id = "";
    $fname = "";
    $lname = "";
    $gender = "";

    if (isset($_POST['id'])){
        $id = $_POST['id'];
        $admin = AdminUser::findAdminByID($id);

        $fname = $admin->first_name;
        $lname = $admin->last_name;
        $gender = ($admin->gender == 'm')? 'male' : 'female';
    }

    if (isset($_POST['update'])){
        $ok = true;

        if(Fanta_Valid::isNullOrEmpty($_POST['firstname'])) {
            $fnameError = "Please enter your first name";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($_POST['lastname'])) {
            $lnameError = "Please enter your last name";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($_POST['gender'])) {
            $genderError = "Please indicate your gender";
            $ok = false;
        } elseif (!Fanta_Valid::isGenderValid($_POST['gender'])) {
            $genderError = "Invalid gender";
            $ok = false;
        }

        if ($ok){
            $row = AdminUser::updateAdmin($_POST['id'], $_POST['firstname'], $_POST['lastname'], $_POST['gender']);
            if($row == 1){
                header("Location: admin-success.php");
            } else {
                echo "Something went wrong! Please try again!";
            }
        }
    }
?>

<h1>New Admin</h1>
<form class="form-horizontal" method="post" action="admin-edit.php">
    <fieldset>
        <legend>Edit user</legend>
        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>" />
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
                <button type="submit" class="btn btn-default" name="update">Update</button>
                <a class="btn btn-default" href="admin-list.php">Cancel</a>
                <a class="btn btn-link" href="admin-changepassword.php?id=<?php echo $id ?>" >Change Password</a>
            </div>
        </div>
    </fieldset>
</form>

