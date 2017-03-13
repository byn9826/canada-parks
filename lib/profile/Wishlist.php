<?php

/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 12-Mar-17
 * Time: 11:04 AM
 */
class Wishlist
{
    private $_objConnection;
    private $_wishId;
    private $_userId;
    private $_parkId;
    private $_addedOn;

    public function __construct($objConnection, $userId)
    {
        $this->_objConnection = $objConnection;
        $this->_userId = $userId;
    }

    public function AddNewPark($parkId)
    {
        $iNbRows = 0;
        $currentDate = date('Y-m-d H:i:s'); // get the current date/time

        $sQueryAddRequest = "
                              INSERT INTO wishlist (user_id, park_id, added_on) 
                                   VALUES (:userId, :parkid, :dateAdded)
                            ";
        $objPDOStatement = $this->_objConnection->prepare($sQueryAddRequest);
        $objPDOStatement->bindValue(':userId', $this->_userId, PDO::PARAM_INT);
        $objPDOStatement->bindValue(':parkid', $parkId, PDO::PARAM_INT);
        $objPDOStatement->bindValue(':dateAdded', $currentDate);
        $iNbRows = $objPDOStatement->execute();

        return $iNbRows;

    }

}