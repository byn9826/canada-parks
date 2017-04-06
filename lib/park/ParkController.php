<?php

require '../DatabaseAccess.php';
require '../ParkRepository.php';

$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
$province = isset($_GET['province']) ? $_GET['province'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$parks = $parkRepository->getParks($name, $province);

echo json_encode($parks);