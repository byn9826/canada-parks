<?php

/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 2/14/2017
 * Time: 5:55 PM
 */
class Database
{
    private static $dsn = "mysql:host=sql9.freemysqlhosting.net;dbname=sql9156605";
    private static $username = "sql9156605";
    private static $password = "FadNqjljSt";
    private static $db;

    private function __construct()
    {
    }

    public static function getDB() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
            }
        }
        return self::$db;
    }
}