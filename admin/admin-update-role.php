<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 3/15/2017
 * Time: 3:44 PM
 */
require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";
$id = "";
$username = $email = $date = "";
$roleArr = AdminUser::getAllRoles();
//var_dump($roleArr);
if (isset($_POST['id'])){
    $id = $_POST['id'];
    $user = AdminUser::findUserByID($id);
    //var_dump($user);
    $currentRole = $user->role_id;
    $username = $user->user_name;
    $email = $user->user_email;
    $date = $user->user_reg;
}

if (isset($_POST["change"]))
{
    $row = AdminUser::updateUserRole($id, $_POST["role"]);
    if($row == 1){
        header("Location: admin-list.php");
    } else {
        echo "Something went wrong! Please try again!";
    }
}
?>


<form class="form-horizontal" method="post" action="admin-update-role.php">
    <fieldset>
    <h2>Please update the privilege for this user</h2>
    <input type='hidden' name='id' value='<?php echo $id; ?>'/>
    <div class="form-group">
        <label class="control-label col-sm-2" for="firstname">User Name:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $username ?>" disabled/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">User Email:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $email ?>" disabled/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">User Registered Date:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $date ?>" disabled/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="role">Role :</label>
        <div class="col-sm-10">
            <select id="role" name="role" class="form-control">
                <?php
                foreach($roleArr as $role){
                    $selectedLevel = ($role->role_id == $currentRole) ? "selected" : "";
                    echo '<option value="'.$role->role_id.'"'.$selectedLevel.'>'.$role->role_name.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="change">Change</button>
            <a class="btn btn-default" href="admin-list.php">Cancel</a>
        </div>
    </div>
    </fieldset>
</form>


