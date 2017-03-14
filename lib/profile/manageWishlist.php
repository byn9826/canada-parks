<?php
/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 12-Mar-17
 * Time: 12:03 PM
 */

session_start();

// -- If user clicked 'Add to wishlist' button
// -- ----------------------------------------
if(isset($_POST["addToWishlist"])) {
    // -- Include libraries
    require_once '../DatabaseAccess.php';
    require_once 'Wishlist.php';

    // -- Declare variables to store parameters
    $userId = $_SESSION["user_id"];
    $parkId = $_POST["park_id"];
    $objConnection = DatabaseAccess::getConnection();

    // -- Create new object to add park to wishlist
    $objWishlist = new Wishlist($objConnection, $userId);
    $RowAdded = $objWishlist->AddNewPark($parkId);

    // -- Return 'Added' or 'Error' to calling method
    if($RowAdded) {
        echo "Added";
    } else {
        echo "Error";
    }
}

/*
 * When parks page laods,
 *  - check if park in wish list and display already in wishlist - Done
 *  - else show button to add to wishlist - Done
 *  - Build wishlist dynamically
 *  - code delete from wishlist using ajax
 */