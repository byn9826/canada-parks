<?php

/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 12-Mar-17
 * Time: 11:04 AM
 */
class Wishlist
{
    // -- Private Declarations
    // -- --------------------
    private $_objConnection;
    private $_wishId;
    private $_userId;
    private $_parkId;
    private $_addedOn;


    // -- Public Constructor Function
    // -- ---------------------------
    public function __construct($objConnection, $userId)
    {
        $this->_objConnection = $objConnection;
        $this->_userId = $userId;
    }


    // -- Public Functions Declaration
    // -- ----------------------------
    // Function to add a new park to the user's wishlist
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

    // Function returning a list of parks found in user's wishlist
    public function GetParksIdInWishlist() {
        // Query to select all park IDs
        $sQueryParksId = "SELECT wish_id
                               , concat('w', wish_id) as wish_id_alias
                               , park_id 
                            FROM wishlist 
                           WHERE user_id = :userId";
        // Execute query
        $objPDOStatement = $this->_objConnection->prepare($sQueryParksId);
        $objPDOStatement->bindValue(':userId', $this->_userId);
        $objPDOStatement->execute();
        $lstParksInWishlist = $objPDOStatement->fetchAll(PDO::FETCH_OBJ);
        // Return list of parks
        return $lstParksInWishlist;
    }

    // Function returning details of parks found in user's wishlist
    public function GetWishParkDetails() {
        // Query to select park details in user's wishlist
        $sQueryParkDetails = "
                                    SELECT w.wish_id
                                         , w.park_id
                                         , DATE_FORMAT(w.added_on,'%b %d %Y %h:%i %p') as added_on
                                         , DATE_FORMAT(w.added_on, '%M %d, %Y') as date_added
                                         , p.name
                                         , p.banner
                                         , p.address
                                         , p.province
                                      FROM wishlist w
                                INNER JOIN park p
                                        ON w.park_id = p.id
                                     WHERE user_id = :userId
                                  ORDER BY w.added_on DESC;
                             ";
        // Execute Query
        $objPDOStatement = $this->_objConnection->prepare($sQueryParkDetails);
        $objPDOStatement->bindValue(':userId', $this->_userId);
        $objPDOStatement->execute();
        $lstParkDetails = $objPDOStatement->fetchAll(PDO::FETCH_OBJ);
        // Return list of park details
        return $lstParkDetails;
    }

    // Function to remove a park found in user's wishlist
    public function RemoveParkFromWishlist($wishId) {
        $fStatus = false;
        try {
            // Query to remove item from wishlist
            $sQueryDelete = "DELETE FROM wishlist WHERE wish_id = :wishId";
            $objPDOStatement = $this->_objConnection->prepare($sQueryDelete);
            $objPDOStatement->bindValue(':wishId', $wishId);
            $objPDOStatement->execute();
            $fStatus = true;
        } catch(PDOException $e) {
            // SQL Exception occured
        }
        return $fStatus;
    }


    // -- Public Static Functions Declaration
    // -- -----------------------------------
    // Function returning an array of park IDs to use as filter
    public static function ConstructWishlistFilterArray($listOfParksInWishlist) {
        $filterArray = array();
        foreach ($listOfParksInWishlist as $objItem) {
            $filterArray[] = $objItem->park_id;
        }
        return $filterArray;
    }

    // Function taking a list of park details and return constructed HTML
    public static function ConstructWishlistItems($listOfWishParkDetails) {
        // Loop and build a wishlist item
        $sResult = "";
        foreach ($listOfWishParkDetails as $objParkDetails) {
            $sResult .= "<div id=\"w{$objParkDetails->wish_id}\" data-wishId=\"{$objParkDetails->wish_id}\" class=\"display-group\">";
            $sResult .= "    <div class=\"row\">";
            $sResult .= "        <div class=\"col col-xs-4 col-sm-4 wishlist-group__thumbnail\">";
            $sResult .= "            <img src=\"{$objParkDetails->banner}\" alt=\"Park banner picture\" />";
            $sResult .= "        </div>";
            $sResult .= "        <div class=\"col col-xs-8 col-sm-8 wishlist-group__park-details\">";
            $sResult .= "            <div>";
            $sResult .= "                <a class=\"wishlist-group__park-link\" href=\"../park/?id={$objParkDetails->park_id}\" alt=\"Link to park profile page\" title=\"Click to view park details\">{$objParkDetails->name}</a>";
            $sResult .= "            </div>";
            $sResult .= "            <div class=\"wishlist-group__more-details\">{$objParkDetails->address}</div>";
            $sResult .= "            <div class=\"wishlist-group__more-details\">{$objParkDetails->province}</div>";
            $sResult .= "        </div>";
            $sResult .= "    </div>";
            $sResult .= "    <div class=\"row wishlist-group__footer\">";
            $sResult .= "        <div class=\"col col-xs-12 col-sm-12\">";
            $sResult .= "            <span class=\"wishlist-group__more-details\" title=\"{$objParkDetails->added_on}\">Added on {$objParkDetails->date_added}</span>";
            $sResult .= "            &nbsp;|&nbsp;";
            $sResult .= "            <span ><a class=\"del-wishitem\"  href=\"\" data-wishId=\"{$objParkDetails->wish_id}\" data-wishElmt=\"w{$objParkDetails->wish_id}\" alt=\"Link to remove park from wishlist\">Remove</a></span>";
            $sResult .= "        </div>";
            $sResult .= "    </div>";
            $sResult .= "</div>";
        }
        return $sResult;
    }

}