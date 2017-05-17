<?php

/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 2/14/2017
 * Time: 5:55 PM
 */
class Database
{
    private static $dsn = "mysql:host=my02.winhost.com;dbname=mysql_108076_lenoir";
    private static $username = "lenoir";
    private static $password = "123qweasdzxc";
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