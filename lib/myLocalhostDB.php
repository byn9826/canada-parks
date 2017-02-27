<?php

/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 11-Feb-17
 * Time: 3:30 PM
 */
class myLocalhostDB
{
    // Private static variables declaration
    // ------------------------------------
    private static $_dsn = 'mysql:host=localhost;dbname=animals';
    private static $_username = 'root';
    private static $_password = '';
    private static $_objConnection;


    // Private constructor
    // -------------------
    private function __construct() {}


    // Public Functions declaration
    // ----------------------------
    public static function getConnection () {
        if (!isset(self::$_objConnection)) {
            try {
                self::$_objConnection = new PDO(self::$_dsn, self::$_username, self::$_password);
                self::$_objConnection->setAttribute(PDO::FETCH_ASSOC, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }
        return self::$_objConnection;
    }

    public static function getProfilePicture($userId) {
        $objConnection = self::getConnection();
        $query = 'SELECT * FROM dinosaurs WHERE name = :userId';
        $statement = $objConnection->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $profilePicture = $statement->fetch(PDO::FETCH_ASSOC);
        if(isset($profilePicture['color'])) {
            $profilePictureURL = $profilePicture['color'];
        } else {
            $profilePictureURL = null;
        }
        return $profilePictureURL;
    }
}