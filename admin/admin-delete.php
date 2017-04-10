<?php

    require_once "model/database.php";
    require_once "model/admin.php";
if (empty($_SESSION))
{
    session_start();
}
    $db = Database::getDB();
    $id = $_POST['id'];
    $row = AdminUser::deleteUserByID($db, $id);
    if ($row == 1) {
        header("Location: admin-list.php");
    }else {
        echo "<h1>Something went wrong. Cannot delete the record!</h1>";
    }
?>



<?php
require_once "header.php";
require_once "footer.php";
?>