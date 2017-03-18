<?php

/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 15-Mar-17
 * Time: 9:33 AM
 */
class Footprints
{
    // -- Variable Declarations
    // -- ---------------------
    private $_objConnection;
    private $_footprintId;
    private $_userId;
    private $_parkId;
    private $_dateVisited;
    private $_userStory;
    private $_isPublic;
    private $_createdOn;
    public static $lstImageExtensions = array("png","PNG","jpg","JPG","jpeg","JPEG","gif","GIF","bmp","BMP");


    // -- Public Constructor Function
    public function __construct($objConnection, $userId)
    {
        $this->_objConnection = $objConnection;
        $this->_userId = $userId;
    }


    // -- PUBLIC PROPERTIES
    // -- -----------------
    /**
     * @return mixed
     */
    public function getFootprintId()
    {
        return $this->_footprintId;
    }

    /**
     * @param mixed $parkId
     */
    public function setParkId($parkId)
    {
        $this->_parkId = $parkId;
    }

    /**
     * @return mixed
     */
    public function getParkId()
    {
        return $this->_parkId;
    }

    /**
     * @param mixed $dateVisited
     */
    public function setDateVisited($dateVisited)
    {
        $this->_dateVisited = date("Y-m-d",strtotime($dateVisited));
    }

    /**
     * @return mixed
     */
    public function getDateVisited()
    {
        return $this->_dateVisited;
    }

    /**
     * @param mixed $userStory
     */
    public function setUserStory($userStory)
    {
        $this->_userStory = $userStory;
    }

    /**
     * @return mixed
     */
    public function getUserStory()
    {
        return $this->_userStory;
    }

    /**
     * @param mixed $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->_isPublic = $isPublic;
    }

    /**
     * @return mixed
     */
    public function getIsPublic()
    {
        return $this->_isPublic;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->_createdOn;
    }


    // -- PUBLIC FUNCTIONS DECLARATION
    // -- ----------------------------
    // -- Function to add a new footprint
    public function AddNewFootprint() {
        // Variables Declaration
        $fRecordAdded = false;
        $this->_createdOn = date('Y-m-d H:i:s'); // get the current date/time

        // Query to add new footprint
        $sQueryAddFootprint = "
                                INSERT INTO footprints (user_id, park_id, date_visited, user_story, is_public, created_on)
                                VALUES (:userId, :parkId, :dateVisited, :userStory, :isPublic, :createdOn);
                              ";
        $objPDOStatement = $this->_objConnection->prepare($sQueryAddFootprint);
        $objPDOStatement->bindValue(':userId', $this->_userId, PDO::PARAM_INT);
        $objPDOStatement->bindValue(':parkId', $this->_parkId, PDO::PARAM_INT);
        $objPDOStatement->bindValue(':dateVisited', $this->_dateVisited);
        $objPDOStatement->bindValue(':userStory', $this->_userStory, PDO::PARAM_STR);
        $objPDOStatement->bindValue(':isPublic', $this->_isPublic, PDO::PARAM_STR);
        $objPDOStatement->bindValue(':createdOn', $this->_createdOn);
        $fRecordAdded = $objPDOStatement->execute();
        $this->_footprintId = $this->_objConnection->lastInsertId();
        return $fRecordAdded;
    }

    // -- Function taking an array of images as input and storing them in the database
    public function SaveFootprintImages($lstImages) {
        // Query to store footprint's image name in DB
        $sQuery = "INSERT INTO footprint_images (footprint_id, image_src) VALUES (:footprintId, :imageName);";
        $objPDOStatement = $this->_objConnection->prepare($sQuery);
        $objPDOStatement->bindValue(':footprintId', $this->_footprintId);

        foreach ($lstImages as $anImage) {
           $objPDOStatement->bindValue(':imageName', $anImage);
           $objPDOStatement->execute();
        }
    }

    // -- Function to retrieve details to display a footprint
    public function GetFootprintsDetails() {
        // Query to select footprints details
        $sQueryFootprints = "
                                    SELECT fp.footprint_id
                                          ,DATE_FORMAT(fp.date_visited, '%M %d, %Y') as date_visited
                                          ,DATE_FORMAT(fp.created_on,'%b %d, %Y %h:%i %p') as created_on
                                          ,fp.is_public
                                          ,fp.user_story
                                          ,ud.user_id
                                          ,ud.image_src
                                          ,RTRIM(concat(IFNULL(ud.first_name,''), ' ', IFNULL(ud.last_name,''))) AS full_name
                                          ,p.name
                                      FROM footprints fp
                                INNER JOIN user_details ud
                                        ON ud.user_id = fp.user_id
                                INNER JOIN park p
                                        ON p.id = fp.park_id
                                     WHERE fp.user_id = :userId
                                  ORDER BY fp.created_on DESC;
                            ";
        // Prepare and execute query
        $objPDOStatement = $this->_objConnection->prepare($sQueryFootprints);
        $objPDOStatement->bindValue(':userId', $this->_userId);
        $objPDOStatement->execute();
        $lstFootprints = $objPDOStatement->fetchAll(PDO::FETCH_OBJ);
        return $lstFootprints;
    }


    // -- Public Static Functions Declaration
    // -- -----------------------------------
    // -- Function taking a list of park details and return constructed HTML
    public static function ConstructFootprintItems($lstFootprints) {
        // Loop and build a wishlist item
        $sResult = "";
        foreach ($lstFootprints as $objFootprint) {
            $sResult .= "<div id=\"f{$objFootprint->footprint_id}\" data-footprintId=\"{$objFootprint->footprint_id}\" class=\"footprint display-group\">";
            $sResult .= "    <div class=\"row\">";
            $sResult .= "        <div class=\"col col-xs-2 col-sm-2 small-profile-pic\"><img src=\"../static/img/profile/users/{$objFootprint->image_src}\" /></div>";
            $sResult .= "        <div class=\"col col-xs-9 col-sm-9\">";
            $sResult .= "            <div>";
            $sResult .= "                <span class=\"footprint__user\">{$objFootprint->full_name}</span> has been to <span class=\"glyphicon glyphicon-tree-deciduous ai-glyphicon\"></span> <span class=\"footprint__park\">{$objFootprint->name}</span> <span title=\"{$objFootprint->date_visited}\">recently.</span>";
            $sResult .= "            </div>";
            $sResult .= "            <div class=\"footprint__date\">{$objFootprint->created_on}</div>";
            $sResult .= "        </div>";
            $sResult .= "    </div>";
            $sResult .= "    <p class=\"footprint__caption\">{$objFootprint->user_story}</p>";
            $sResult .= "    <div class=\"row footprint__gallery\">";
            // -- Construct a list of pictures for the footprint
            // -- ----------------------------------------------
            // Target directory containing footprint images
            $sFolderPath = '../static/img/profile/footprints/' . $objFootprint->user_id . '_' . $objFootprint->footprint_id . '/';
            $iNbFiles = glob($sFolderPath . "*.{JPG,jpg,jpeg,JPEG,gif,GIF,png,PNG,bmp,BMP}", GLOB_BRACE);   // Number of images in folder
            if (is_dir($sFolderPath)) {    // Only if directory exists
                $sCurrentDirectory = opendir($sFolderPath); // Open folder to read
                if($iNbFiles > 0) {
                    $counter = 0;
                    $sResult .= "        <div class=\"owl-carousel owl-theme\">";
                    while(false !== ($file = readdir($sCurrentDirectory)))
                    {
                        $file_path = $sFolderPath.$file;
                        $extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
                        if(in_array($extension, Footprints::$lstImageExtensions))
                        {
                            $counter += 1;
//                            $sResult .= "<li class=\"col-lg-2 col-md-2 col-sm-3 col-xs-4\">";
//                            $sResult .= "        <img src=\"{$file_path}\" />";
//                            $sResult .= "    </li>";
                            $sResult .= "        <div class=\"item\"><img src=\"$file_path\" /></div>";
                        }
                    }
                    $sResult .= "        </div>";
                }
                closedir($sCurrentDirectory);   // Close folder after read
            }
            $sResult .= "    </div>";
            $sResult .= "</div>";
        }
        return $sResult;
    }

}