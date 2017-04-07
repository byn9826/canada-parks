<?php
//require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";
/*
 * username:
 *      lenoir - superadmin
 *      andy - admin
 *      duc - user
 * pass: 123123123
 * */
if (empty($_SESSION))
{
    session_start();
}
//var_dump($_SESSION);
    $db = Database::getDB();
    if (isset($_SESSION["user_name"])){
        $_SESSION["role_id"] = (AdminUser::findUserByUsername($db, $_SESSION["user_name"]))->role_id;
        $_SESSION["user_id"] = (AdminUser::findUserByUsername($db, $_SESSION["user_name"]))->user_id;
        header("Location: admin-list.php");
    }
    else
    {
        $username = $password = "";
        if(isset($_POST["submit"]))
        {
            $username = $_POST["username"];
            $password = $_POST["pwd"];

            $currentUser = AdminUser::findUserByUsername($db, $username);
            if (is_null($currentUser) || !isset($currentUser) || $currentUser == false)
            {
                echo "<div class=\"alert alert-danger\"> No username found!</div>";
            }
            elseif ($currentUser->user_name == $username && $currentUser->user_password == sha1($password) &&
                $currentUser->user_status == 0 && $currentUser->role_id > 0)
            {
                $_SESSION["user_id"] = $currentUser->user_id;
                $_SESSION["user_name"] = $currentUser->user_name;
                $_SESSION["role_id"] = $currentUser->role_id;
                //AdminUser::updateUserStatus($currentUser);
                //var_dump($_SESSION["user_name"]);
                header("Location: admin-list.php");
            }
            elseif ($currentUser->role_id == 0)
            {
                echo "<div style='position:relative;top:5em;' class=\"alert alert-danger\"> This account does not have privilege to access admin page. Please contact admin for further information.</div>";
            }
            elseif ($currentUser->user_status == 1)
            {
                echo "<div style='position:relative;top:5em;' class=\"alert alert-danger\"> The username is already logged in our website!</div>";
            }
            else
            {
                echo "<div style='position:relative;top:5em;' class=\"alert alert-danger\"> Invalid password for the username!</div>";
            }

        }
    }


?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="description" content="Admin page for have CRUD actions on Users and Parks"/>
        <meta name="author" content="Duc Nguyen"/>
        <title>Admin page</title>
        <?php
            require_once "header.php";
        ?>
    </head>
    <body>
        <div class="container" id="login-form">
            <h2>Login Form</h2>
            <form class="form-horizontal" method="post" action="index.php">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="username">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" class="btn btn-default">Login</button>
                        <a class="btn btn-link" href="admin-forgotpassword.php?">Forgot my Password</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

<?php
require_once "footer.php";
?>