<?php
#author: Bao
#deal with attitude

#read init data for attitude component
if (isset($_POST['parkId'])) {
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $db = DatabaseAccess::getConnection();
    $Attitude = new Attitude($db);
    $parkId = intval($_POST['parkId']);
    #get all related attitude info
    $all = $Attitude->getAttitude($parkId);
    #get current user id
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user = $_SESSION['user_id'];
    } else {
        $user = 0;
    }
    echo json_encode([$all, $user]);
}

#update rate for attitude
if (isset($_POST['newRate'])) {
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $db = DatabaseAccess::getConnection();
    $Attitude = new Attitude($db);
    $newRate = $_POST['newRate'];
    $parkId = $_POST['parkId1'];
    session_start();
    $userId = $_SESSION['user_id'];
    echo $Attitude->updateRate($parkId, $userId, $newRate);
}

#update worth for attitude
if (isset($_POST['newWorth'])) {
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $db = DatabaseAccess::getConnection();
    $Attitude = new Attitude($db);
    $newWorth = $_POST['newWorth'];
    $parkId = $_POST['parkId2'];
    session_start();
    $userId = $_SESSION['user_id'];
    echo $Attitude->updateWorth($parkId, $userId, $newWorth);
}

#update back for attitude
if (isset($_POST['newBack'])) {
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $db = DatabaseAccess::getConnection();
    $Attitude = new Attitude($db);
    $newBack = $_POST['newBack'];
    $parkId = $_POST['parkId3'];
    session_start();
    $userId = $_SESSION['user_id'];
    echo $Attitude->updateBack($parkId, $userId, $newBack);
}
