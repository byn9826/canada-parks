<?php
#author BAO
if (isset($_POST['email'])) {
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $db = DatabaseAccess::getConnection();
    $retrieveUsername = new PublicLogin($db);
    if (isset($retrieveUsername)) {
        echo json_encode($retrieveUsername->getUsername($_POST['email']));
    } else {
        echo 'no';
    }

}
