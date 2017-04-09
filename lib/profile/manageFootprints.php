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
            if($_FILES['files']['error'][0] !== 4) {
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
    $fFootprintRemoved = $objFootprint->Delete(false);
    if($fFootprintRemoved) {
        echo "Deleted";
    } else {
        echo "Error";
    }
}


// -- If user requested to edit a footprint
// -- -------------------------------------
if(isset($_GET['footprintToEdit'])) {
    // Handle user session
    session_start();
    require_once '../DatabaseAccess.php';

    // -- Variables declaration
    $userId = $_SESSION['user_id'];
    $objConnection = DatabaseAccess::getConnection();

    // -- Get footprint id
    $iFootprintId = $_GET['footprint_id'];
    $objFootprint = new Footprints($objConnection, $userId);
    $objFootprint->setFootprintId($iFootprintId);

    // Get footprint details
    $objFootprintDetails = $objFootprint->GetAFootprintDetails();

    // Return result as a JSON object
    header("Content-Type: application/json");
    $jsonResult = json_encode($objFootprintDetails);
    echo $jsonResult;
}


// -- If user clicked 'Save Changes' button
// -- -------------------------------------
if(isset($_POST['btnEditFootprint'])) {
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
    $footprintId = $_POST['footprint_id'];
    $visitedParkId = $_POST['parkVisited'];
    $dateVisited = $_POST['editDateVisited'];
    $userStory = Fanta_Valid::isNullOrEmpty($_POST['userStory']) ? "NULL" : $_POST['userStory'];
    $isPublic = isset($_POST['isPublic']) ? "Y" : "N";
    $createdOn = $_POST['created_on'];

    // -- Update details in footprint object
    $objFootprint->setFootprintId($footprintId);
    $objFootprint->setParkId($visitedParkId);
    $objFootprint->setDateVisited($dateVisited);
    $objFootprint->setUserStory($userStory);
    $objFootprint->setIsPublic($isPublic);
    $objFootprint->setCreatedOn($createdOn);

    try {
        // BEGIN Transaction
        $objConnection->beginTransaction();

        // Update footprint details in the database
        $fFootprintUpdated = $objFootprint->Update();

        if($fFootprintUpdated) {
            // Upload any new images user added to footprint
            $sFolderName = $userId . '_' . $objFootprint->getFootprintId();

            // If user uploaded new images, add them to existing directory
            if($_FILES['files']['error'][0] !== 4) {
                echo "Files uploaded";
                if (!is_dir("../../static/img/profile/footprints/{$sFolderName}")) {
                    mkdir("../../static/img/profile/footprints/{$sFolderName}", 0775, true);    // Create folder to store images
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
            }
            // COMMIT Transaction
            $objConnection->commit();
        } else {
            throw new Exception('Unable to update footprint');
        }
        header('Location: ../../profile/?fp=e');
    }catch (Exception $e) {
        // ROLLBACK transaction
        $objConnection->rollBack();
        header('Location: ../../profile/?fp=f');
    }

}


// -- If user select's an image to delete from footprint
// -- --------------------------------------------------
if(isset($_POST['deleteFootImg'])) {
    // Handle user session
    session_start();
    require_once '../DatabaseAccess.php';

    // -- Variables declaration
    $fStatus = false;
    $userId = $_SESSION['user_id'];
    $footprintId = $_POST['footprint_id'];
    $imageId = $_POST['image_id'];
    $imageSrc = $_POST['image_src'];
    $objConnection = DatabaseAccess::getConnection();

    // -- Delete entry from DB and from file
    try {
        // BEGIN Transaction
        $objConnection->beginTransaction();

        // Delete image from DB
        $fStatus = Footprints::DeleteAFootprintImage($objConnection, $imageId);

        if($fStatus) {
            // Delete image file
            Footprints::DeleteFootprintImageFile($userId, $footprintId, $imageSrc);
        }

        // COMMIT Transaction
        $objConnection->commit();

        // Operations ended successfully
        echo "Deleted";
    } catch (Exception $e) {
        // ROLLBACK Transaction
        $objConnection->rollBack();
        echo "Failed";
    }
}


// -- If user clicked 'Load Footprints' from a park's page
// -- ----------------------------------------------------
if(isset($_POST['btnLoadParkFootprints'])) {
    require_once '../DatabaseAccess.php';

    // -- Variables declaration
    $objConnection = DatabaseAccess::getConnection();
    $iParkId = $_POST['park_id'];
    $iMaxRowsPerLoad = $_POST['rows_per_load'];
    $iLoadFromRow = $_POST['from_row_num'];

    // -- Fetch footprints for park
    $lstFootprints = Footprints::GetFootprintsForPark($objConnection, $iParkId, $iLoadFromRow, $iMaxRowsPerLoad);

    // -- Construct Footprints HTML Markup
    echo Footprints::ConstructFootprintItems($lstFootprints, false, true);

}
