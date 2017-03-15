<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 3/15/2017
 * Time: 1:50 PM
 */
require_once "model/database.php";
require_once "model/admin.php";

session_start();

AdminUser::updateUserStatus(AdminUser::findUserByUsername($_SESSION["user_name"]));
var_dump($_SESSION);
if (!empty($_SESSION)){
    session_destroy();
    session_unset();

    //var_dump($_SESSION);
}

header("Location: index.php");
