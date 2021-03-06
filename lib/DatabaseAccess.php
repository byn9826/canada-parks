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
    private static $_dsn = 'mysql:host=my02.winhost.com;dbname=mysql_108076_lenoir';
    private static $_username = 'lenoir';
    private static $_password = '123qweasdzxc';
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
