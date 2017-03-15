<?php
require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";

if(isset($_SESSION["admin_fullname"]) || $_SESSION["admin_fullname"] != null)
{
    header("Location: admin-list.php");
}
else
{
    $email = $password = "";
    if(isset($_POST["submit"]))
    {
        $email = $_POST["email"];
        $password = $_POST["pwd"];

        $currentUser = AdminUser::findAdminByEmail($email);
        if (is_null($currentUser) || !isset($currentUser) || $currentUser == false)
        {
            echo "No username found!";
        }
        elseif ($currentUser->email == $email && $currentUser->password == $password)
        {
            $_SESSION["admin_fullname"] = $currentUser->first_name . " " . $currentUser->last_name;
            header("Location: admin-list.php");
        }
        else
        {
            echo "Invalid password for the username!";
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
            include_once "header.php";
        ?>
    </head>
    <body>
        <div class="container">
            <h2>Login Form</h2>
            <form class="form-horizontal" method="post" action="index.php">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
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
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
