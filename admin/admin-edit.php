<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    require_once "../lib/validation/fanta_valid.php";

    $id = $_SESSION["user_id"];
    $admin = AdminUser::findUserByID($id);
    $username = $admin->user_name;
    $email = $admin->user_email;

    if (isset($_POST['update'])){
        $ok = true;
        $usernameExisted = AdminUser::checkUsernameExisted($_POST['id'], $_POST['username']);
        $emailExisted = AdminUser::checkEmailExisted($_POST['id'], $_POST['email']);

        if(Fanta_Valid::isNullOrEmpty($_POST['username'])) {
            $usernameError = "Username can not be empty";
            $ok = false;
        } elseif ($usernameExisted) {
            $usernameError = "This username is already used. Please select another";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($_POST['email'])) {
            $emailError = "Email can not be empty";
            $ok = false;
        }else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $emailError = "Please enter valid email format";
            $ok = false;
        }elseif ($emailExisted) {
            $emailError = "This email is already used. Please select another";
            $ok = false;
        }

        if ($ok){
            //var_dump($_POST['gender']);
            $row = AdminUser::updateUsernameAndEmailForUser($_POST['id'], $_POST['username'], $_POST['email']);
            if($row == 1){
                header("Location: admin-success.php");
            } else {
                echo "Something went wrong! Please try again!";
            }
        }
    }
?>

<h1>Update your profile</h1>
<form class="form-horizontal" method="post" action="admin-edit.php">
    <fieldset>
        <legend>Please edit fields below:</legend>
        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>" />
        <div class="form-group">
            <label class="control-label col-sm-2" for="username">User Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php echo $username ?>" />
                <br/><span><?php if (isset($usernameError)) echo "$usernameError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email ?>" />
                <br/><span><?php if (isset($emailError)) echo "$emailError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" name="update">Update</button>
                <a class="btn btn-default" href="admin-list.php">Cancel</a>
                <a class="btn btn-link" href="admin-changepassword.php?">Change Password</a>
            </div>
        </div>
    </fieldset>
</form>

<?php
require_once "footer.php";
?>
