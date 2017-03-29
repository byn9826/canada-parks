<?php
require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";
$db = Database::getDB();
?>

<div class="container" id="forgot-form">
    <h2>Please enter your email here:</h2>
    <form class="form-horizontal" method="post" action="admin-forgotpassword.php">
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="submit" class="btn btn-default">Submit</button>
                <a class="btn btn-default" href="index.php">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php
if (isset($_POST['submit']))
{
    if (AdminUser::checkEmailExistedInDB($db, $_POST['email']))
    {
        $_SESSION['user-need-new-password'] = AdminUser::findUserByEmail($db, $_POST['email']);
        header("Location: admin-sendnewpassword.php");
    }
    else
    {
        echo "<div class=\"alert alert-danger\"> Your email is not found!</div>";
    }
}
?>