<?php

/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 11-Feb-17
 * Time: 3:30 PM
 */
class DatabaseAccess
{
    // Private static variables declaration
    // ------------------------------------
    private static $_dsn = 'mysql:host=159.203.38.161;dbname=marvel';
    private static $_username = 'humberTeam';
    private static $_password = 'sQbI8cMHci2VYJjrvXlp';
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
}
