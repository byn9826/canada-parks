<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 3/29/2017
 * Time: 2:58 PM
 */

require_once "model/database.php";
require_once "model/admin.php";

$db = Database::getDB();
$userId = $_POST["userId"];
var_dump($_POST["userId"]);
$user = AdminUser::checkEmailSubscribe($db, $userId);
AdminUser::updateEmailSubscribe($db, $userId, $user->email_subscribed);
