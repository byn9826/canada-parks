<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    require_once "../lib/validation/fanta_valid.php";

    $id = "";
    $email = "";
    $pwd = "";

    $id = $_SESSION["user_id"];
    $admin = AdminUser::findUserByID($id);
    $email = $admin->user_email;
    $pwd = $admin->user_password;
    //var_dump($pwd);

    if (isset($_POST['update'])){
        $ok = true;

        if(Fanta_Valid::isNullOrEmpty($_POST['oldpwd'])) {
            $oldpwdError = "Please enter your old password";
            $ok = false;
        } elseif (sha1($_POST['oldpwd']) != $pwd){
            $oldpwdError = "Your password is incorrect";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($_POST['newwpwd'])) {
            $newpwdError = "Please enter your new password";
            $ok = false;
        }

        if(Fanta_Valid::isNullOrEmpty($_POST['confirmpwd'])) {
            $confirmpwdError = "Please confirm your password";
            $ok = false;
        } elseif ($_POST['confirmpwd'] != $_POST['newwpwd']) {
            $confirmpwdError = "Your password does not match";
            $ok = false;
        }

        if ($ok){
            $row = AdminUser::updatePassword($id, $email, sha1($_POST['newwpwd']));

            if($row == 1){
                header("Location: admin-success.php");
            } else {
                echo "Something went wrong! Please try again!";
            }
        }
    }

?>

<h1>Change User Password</h1>
<form class="form-horizontal" method="post" action="admin-changepassword.php?id=<?php echo $id ?>">
    <fieldset>
        <legend>Update your password</legend>
        <div class="form-group">
            <label class="control-label col-sm-2" for="id">ID:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="oldpwd">Old Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="oldpwd" placeholder="Enter old password" name="oldpwd" value="" />
                <br/><span><?php if (isset($oldpwdError)) echo "$oldpwdError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="newwpwd">New Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="newwpwd" placeholder="Enter new password" name="newwpwd" value="" />
                <br/><span><?php if (isset($newpwdError)) echo "$newpwdError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="confirmpwd">Confirm New Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="confirmpwd" placeholder="Confirm new password" name="confirmpwd" value="" />
                <br/><span><?php if (isset($confirmpwdError)) echo "$confirmpwdError"; ?></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" name="update">Update</button>
                <a class="btn btn-default" href="admin-list.php">Cancel</a>
            </div>
        </div>
    </fieldset>
</form>

<?php
require_once "footer.php";
?>