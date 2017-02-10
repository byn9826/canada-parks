<?php
class ParkRepository {
    private $host = 'sql9.freemysqlhosting.net';
    private $dbname = 'sql9156605';
    private $username = 'sql9156605';
    private $password = 'FadNqjljSt';
    private $db;
    
    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $this->db = new PDO($dsn, $this->username, $this->password);
        $this->db->setAttribute(PDO::FETCH_ASSOC, PDO::ERRMODE_EXCEPTION);
    }

    
    public function getParks($province) {
        
        //$province = isset($_GET['province']) ? $_GET['province'] : '';
        if (isset($province)) {
            $sql = "SELECT * FROM park WHERE province_code = '$province'";
        } else {
            $sql = 'SELECT * FROM park';
        }
        $pdostmt = $this->db->prepare($sql);
        $pdostmt->setFetchMode(PDO::FETCH_ASSOC);
        $pdostmt->execute();
        return $pdostmt->fetchAll();
    }
}