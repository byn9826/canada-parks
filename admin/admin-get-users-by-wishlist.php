<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 4/4/2017
 * Time: 7:39 PM
 */
//require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";
$db = Database::getDB();

$users = AdminUser::getUsersByWishlistAboutParks($db, $_POST['list']);

//echo json_encode($users);
//$a = json_encode($users);
//$a = json_decode($a);
$a = "";
foreach ($users as $key => $value) {
    if ($key == 0)
        $a .= $value->user_id;
    else
        $a .= "," . $value->user_id;
}

echo $a;