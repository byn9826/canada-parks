<?php
//authro bao
//this file is modified directly from Irfaan's function

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
    public function __construct($objConnection)
    {
        $this->_objConnection = $objConnection;
    }


    // -- PUBLIC PROPERTIES
    // -- -----------------
    /**
     * @param mixed $footprintId
     */
    public function setFootprintId($footprintId)
    {
        $this->_footprintId = $footprintId;
    }

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

    /**
     * @param mixed $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->_createdOn = $createdOn;
    }


    // -- Function to retrieve details to display a footprint
    public function GetFootprintsDetails($iFootprintId = 0) {
        // Query to select footprints details
        $sQueryFootprints = "
                                    SELECT fp.footprint_id
                                          ,DATE_FORMAT(fp.date_visited, '%M %d, %Y') as date_visited
                                          ,DATE_FORMAT(fp.created_on,'%b %d, %Y %h:%i %p') as created_on
                                          ,fp.is_public
                                          ,IF(fp.user_story = 'NULL','', fp.user_story) as user_story
                                          ,ud.user_id
                                          ,ud.image_src
                                          ,RTRIM(concat(IFNULL(ud.first_name,''), ' ', IFNULL(ud.last_name,''))) AS full_name
                                          ,p.id as parkId
                                          ,p.name
                                      FROM footprints fp
                                INNER JOIN user_details ud
                                        ON ud.user_id = fp.user_id
                                INNER JOIN park p
                                        ON p.id = fp.park_id

                            ";
        if($iFootprintId != 0) {
            $sQueryFootprints .= "   AND fp.footprint_id = :footprintId ";
        }
        $sQueryFootprints .= "    ORDER BY fp.created_on DESC LIMIT 0, 10; ";
        // Prepare and execute query
        $objPDOStatement = $this->_objConnection->prepare($sQueryFootprints);
        if($iFootprintId != 0) {
            $objPDOStatement->bindValue(':footprintId', $iFootprintId);
        }
        $objPDOStatement->execute();
        $lstFootprints = $objPDOStatement->fetchAll(PDO::FETCH_OBJ);
        return $lstFootprints;
    }

    // -- PUBLIC STATIC FUNCTIONS DECLARATION
    // -- -----------------------------------
    // -- Function taking a list of park details and return constructed HTML
    public static function ConstructFootprintItems($lstFootprints, $fEditMode, $fFetchAsync) {
        // Loop and build a wishlist item
        $sResult = "";
        foreach ($lstFootprints as $objFootprint) {
            $sResult .= "<div id=\"f{$objFootprint->footprint_id}\" data-footprintId=\"{$objFootprint->footprint_id}\" class=\"footprint display-group\">";
            $sResult .= "    <div class=\"row\">";
            //$sResult .= "        <div class=\"col col-xs-2 col-sm-2 small-profile-pic\"><img src=\"../static/img/profile/users/{$objFootprint->image_src}\" /></div>";
            $sResult .= "        <div class=\"col col-xs-2 col-sm-2 small-profile-pic\"><img src=\"" . self::getProfilePictureURL($objFootprint->image_src) . "\" /></div>";
            $sResult .= "        <div class=\"col col-xs-9 col-sm-9\">";
            $sResult .= "            <div>";
            $sResult .= "                <span class=\"footprint__user\">{$objFootprint->full_name}</span> has been to <span class=\"glyphicon glyphicon-tree-deciduous ai-glyphicon\"></span> <a href=\"park/?id={$objFootprint->parkId}\" alt='View park details' title='Click to view park details'><span class=\"footprint__park\">{$objFootprint->name}</span></a> <span title=\"{$objFootprint->date_visited}\">recently.</span>";
            $sResult .= "            </div>";
            $sResult .= "            <div class=\"footprint__date\">{$objFootprint->created_on}</div>";
            $sResult .= "        </div>";


            $sResult .= "    </div>";
            $sResult .= "    <p class=\"footprint__caption\">{$objFootprint->user_story}</p>";
            $sResult .= "    <div class=\"row footprint__gallery\">";
            // -- Construct a list of pictures for the footprint
            // -- ----------------------------------------------
            // Target directory containing footprint images
            $sFolderPath = 'static/img/profile/footprints/' . $objFootprint->user_id . '_' . $objFootprint->footprint_id . '/';


            // -- Get all image files form the folder
            $iNbFiles = glob($sFolderPath . "*.{JPG,jpg,jpeg,JPEG,gif,GIF,png,PNG,bmp,BMP}", GLOB_BRACE);   // Number of images in folder

            if (is_dir($sFolderPath)) {    // Only if directory exists
                $sCurrentDirectory = opendir($sFolderPath); // Open folder to read
                if($iNbFiles > 0) {
                    $sResult .= "        <div class=\"owl-carousel owl-theme\">";
                    while(false !== ($file = readdir($sCurrentDirectory)))
                    {
                        // Handle different source path
                        if(!$fFetchAsync) {
                            $file_path = $sFolderPath.$file;
                        } else {
                            $file_path = $sImagePath.$file;
                        }

                        $extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
                        if(in_array($extension, Footprints::$lstImageExtensions))
                        {
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


    // -- Function to retrieve footprints for a park
    public static function GetFootprintsForPark($objConnection, $iParkId, $iLoadFromRow, $iNumRowsToLoad) {

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
                                          ,p.id as parkId
                                          ,p.name
                                      FROM footprints fp
                                INNER JOIN user_details ud
                                        ON ud.user_id = fp.user_id
                                INNER JOIN park p
                                        ON p.id = fp.park_id
                                     WHERE fp.park_id = :parkId
                                  ORDER BY fp.created_on DESC
                                     LIMIT
                            ";
        $sQueryFootprints .= $iLoadFromRow;
        $sQueryFootprints .= ", ";
        $sQueryFootprints .= $iNumRowsToLoad;

        // Prepare and execute query
        $objPDOStatement = $objConnection->prepare($sQueryFootprints);
        $objPDOStatement->bindValue(':parkId', $iParkId, PDO::PARAM_INT);
        $objPDOStatement->execute();
        $lstFootprints = $objPDOStatement->fetchAll(PDO::FETCH_OBJ);

        return $lstFootprints;
    }


    public static function getProfilePictureURL($sImageSource) {
        //if img src is from google+
        if (substr($sImageSource, 0, 4) == 'http') {
            return $sImageSource;
        }
        //if img is from local folder
        else {
            return "static/img/profile/users/" . $sImageSource;
        }
    }

}
