<?php

require '../DatabaseAccess.php';
require '../ParkRepository.php';

$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
if ($_GET['action'] == 'getlist') {
    $province = isset($_GET['province']) ? $_GET['province'] : '';
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $parks = $parkRepository->getParks('all', $name, $province);
    
    echo json_encode($parks);
}

if ($_GET['action'] == 'delete') {
    $id = $_POST['id'];
    $result = $parkRepository->deletePark($id);
    echo json_encode($result);
}