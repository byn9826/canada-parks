<?php
require_once "../templates/meta.php";
require_once "model/database.php";
require_once "model/admin.php";

$email = $_GET['email'];
$pass = $_GET['pass'];

$user = AdminUser::findUserByEmail($email);
//var_dump($user);
//var_dump(sha1($pass));
//var_dump(sha1(date("Y-m-d")));
if ($user->activation_code == sha1($pass) && $user->activation_date == date("Y-m-d"))
{
    AdminUser::updatePassword($user->user_id, $email, sha1($pass));
    AdminUser::updateActivation($user->user_id);
    echo "<div class=\"alert alert-success\"> Your new password is validated.</div>";
    echo "<a class='btn btn-default' href='index.php'>Back to Login page</a>";
}
else
{
    AdminUser::updateActivation($user->user_id);
    echo "<div class=\"alert alert-danger\"> Validation failed. Please try again!</div>";
}



