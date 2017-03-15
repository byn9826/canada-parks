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
}