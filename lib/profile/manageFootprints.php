<?php
/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 14-Mar-17
 * Time: 11:30 PM
 */

// -- Include libraries
require_once 'Footprints.php';

// -- If user clicked 'Share Footprint' button
// -- ----------------------------------------
if(isset($_POST["btnShareFootprint"])) {
    // Handle user session
    session_start();
    require_once '../DatabaseAccess.php';
    require_once '../validation/fanta_valid.php';

    // -- Global Variables Initialisation
    $userId = $_SESSION["user_id"];
    $objConnection = DatabaseAccess::getConnection();
    $objFootprint = new Footprints($objConnection, $userId);
    $lstFootprintImages = array();

    // -- Capture form data
    $visitedParkId = $_POST['parkVisited'];
    $dateVisited = $_POST['dateVisited'];
    $userStory = Fanta_Valid::isNullOrEmpty($_POST['userStory']) ? "NULL" : $_POST['userStory'];
    $isPublic = isset($_POST['isPublic']) ? "Y" : "N";

    // -- Add details to footprint
    // -- ------------------------
    $objFootprint->setParkId($visitedParkId);
    $objFootprint->setDateVisited($dateVisited);
    $objFootprint->setUserStory($userStory);
    $objFootprint->setIsPublic($isPublic);
    try {
        // BEGIN Transaction
        $objConnection->beginTransaction();

        // Add footprint to footprints table
        $fFootprintAdded = $objFootprint->AddNewFootprint();
        if($fFootprintAdded) {
            // Upload any footprint images to DB
            $sFolderName = $userId . '_' . $objFootprint->getFootprintId();
            if($_FILES["files"]["error"] != 4) {    // TODO: CHECK if files uploaded is none
                if (!is_dir("../../static/img/profile/footprints/{$sFolderName}")) {
                    mkdir("../../static/img/profile/footprints/{$sFolderName}", 0775, true);    // Create folder to store images
                }
            }
            foreach ($_FILES['files']['name'] as $name => $value)
            {
                $file_name = explode(".", $_FILES['files']['name'][$name]);
                $allowed_ext = array("jpg", "jpeg", "JPG", "JPEG", "png", "PNG", "gif", "GIF");
                if(in_array($file_name[1], $allowed_ext))
                {
                    $new_name = substr(sha1(mt_rand()),0,50) . '.' . $file_name[1];
                    $sourcePath = $_FILES['files']['tmp_name'][$name];
                    $target = "../../static/img/profile/footprints/{$sFolderName}/".$new_name;  // Target folder: userId_footprintId
                    if(move_uploaded_file($sourcePath, $target))
                    {
                        $lstFootprintImages[] = $new_name;
                    }
                }
            }

            // Store images in the Database
            $objFootprint->SaveFootprintImages($lstFootprintImages);

            // COMMIT Transaction
            $objConnection->commit();
        } else {
            throw new Exception('Unable to add footprint');
        }
        header('Location: ../../profile/?fp=s');
    }catch (Exception $e) {
        // ROLLBACK transaction
        $objConnection->rollBack();
        header('Location: ../../profile/?fp=f');
    }
}


// -- If user clicked 'Delete footprint' button
// -- -----------------------------------------
if(isset($_POST['deleteFootprint'])) {
    // Handle user session
    session_start();
    require_once '../DatabaseAccess.php';

    // -- Global Variables Initialisation
    $userId = $_SESSION["user_id"];
    $objConnection = DatabaseAccess::getConnection();
    $objFootprint = new Footprints($objConnection, $userId);

    // -- Capture form data
    $iFootprintId = $_POST['footprint_id'];
    $objFootprint->setFootprintId($iFootprintId);
    $fFootprintRemoved = $objFootprint->Delete();
    if($fFootprintRemoved) {
        echo "Deleted";
    } else {
        echo "Error";
    }
}
