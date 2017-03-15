<?php
/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 12-Mar-17
 * Time: 12:03 PM
 */
session_start();

// -- Include libraries
require_once '../DatabaseAccess.php';
require_once 'Wishlist.php';


// -- Global Variables Initialisation
$userId = $_SESSION["user_id"];
$objConnection = DatabaseAccess::getConnection();
$objWishlist = new Wishlist($objConnection, $userId);


// -- If user clicked 'Add to wishlist' button
// -- ----------------------------------------
if(isset($_POST["addToWishlist"])) {
    // -- Variable Declaration
    $parkId = $_POST["park_id"];

    // -- Add park to wishlist
    $RowAdded = $objWishlist->AddNewPark($parkId);

    // -- Return 'Added' or 'Error' to calling method
    if($RowAdded) {
        echo "Added";
    } else {
        echo "Error";
    }
}


// -- If user clicked 'Remove' link
// -- -----------------------------
if(isset($_POST['delFromWishlist'])) {
    // -- Variable Declaration
    $wishId = $_POST['wish_id'];

    // -- Remove park from wish list
    $ParkRemoved = $objWishlist->RemoveParkFromWishlist($wishId);

    // -- Return 'Deleted' or 'Error' to calling method
    if($ParkRemoved) {
        echo "Deleted";
    } else {
        echo "Error";
    }
}
