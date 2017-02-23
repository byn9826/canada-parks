<?php

include "Upload.php";
//Author: Sam

class ParkRepository {
    private $host = "sql9.freemysqlhosting.net";
    private $dbname = "sql9156605";
    private $username = "sql9156605";
    private $password = "FadNqjljSt";
    private $db;
    
    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $this->db = new PDO($dsn, $this->username, $this->password);
        $this->db->setAttribute(PDO::FETCH_ASSOC, PDO::ERRMODE_EXCEPTION);
    }

    
    public function getParks($name = "", $province = "") {
        $sql = "SELECT * FROM park";
        $pdostmt = $this->db->prepare($sql);
        
        if (!empty($name)) {
            $sql = "SELECT * FROM park WHERE name LIKE %:name%";
            $pdostmt = $this->db->prepare($sql);
            $pdostmt->bindValue(":name", $name, PDO::PARAM_STR);
        }
        
        if (!empty($province)) {
            $sql = "SELECT * FROM park WHERE province_code = :province";
            $pdostmt = $this->db->prepare($sql);
            $pdostmt->bindValue(":province", $province, PDO::PARAM_STR);
        }
        
        if (!empty($name) && !empty($province)) {
            $sql = "SELECT * FROM park WHERE name LIKE %:name% AND province_code = :province";
            $pdostmt = $this->db->prepare($sql);
            $pdostmt->bindValue(":name", $name, PDO::PARAM_STR);
            $pdostmt->bindValue(":province", $province, PDO::PARAM_STR);
        }

        $pdostmt->execute();
        return $pdostmt->fetchAll();
    }
    
    public function getPark($id) {
        $sql = "SELECT * FROM park WHERE id = :id";
        $pdostmt = $this->db->prepare($sql);
        $pdostmt->bindValue(":id", $id, PDO::PARAM_STR);
        $pdostmt->execute();
        return $pdostmt->fetch();
    }
    
    public function addPark($park, $upload) {
        $name = $park["name"];
        $banner = $park["banner"];
        $address = $park["address"];
        $province = $park["province"];
        $latitude = $park["latitude"];
        $longitude = $park["longitude"];
        $phone_number = $park["phone_number"];
        
        $sql = "INSERT INTO park (google_place_id, name, banner, photo_reference, address, province, province_code, latitude, longitude, phone_number, rating)" . 
        "VALUES ( '', :name, :banner, '', :address, :province, '', :latitude, :longitude, :phone_number, '')";
        $pdostmt = $this->db->prepare($sql);
        $pdostmt->bindValue(':name', $park["name"], PDO::PARAM_STR);
        $pdostmt->bindValue(':banner', $park["banner"], PDO::PARAM_STR);
        $pdostmt->bindValue(':address', $park["address"], PDO::PARAM_STR);
        $pdostmt->bindValue(':province', $park["province"], PDO::PARAM_STR);
        $pdostmt->bindValue(':latitude', $park["latitude"], PDO::PARAM_STR);
        $pdostmt->bindValue(':longitude', $park["longitude"], PDO::PARAM_STR);
        $pdostmt->bindValue(':phone_number', $park["phone_number"], PDO::PARAM_STR);
        return $pdostmt->execute();
    }
    
    public function updatePark($park, $upload) {
        
        $id = $park["id"];
        $name = $park["name"];
        $banner = $park["banner"];
        $address = $park["address"];
        $province = $park["province"];
        $latitude = $park["latitude"];
        $longitude = $park["longitude"];
        $phone_number = $park["phone_number"];
        
        if (isset($upload["name"])) {
            $u = new Upload();
            $banner = $u->toServer($upload);
        }

        $sql = "UPDATE park SET name = :name, banner = :banner, address = :address, province = :province, latitude = :latitude, longitude = :longitude, phone_number = :phone_number WHERE id = :id ";
        $pdostmt = $this->db->prepare($sql);
 
        $pdostmt->bindValue(":id", $id, PDO::PARAM_STR);
        $pdostmt->bindValue(":name", $name, PDO::PARAM_STR);
        $pdostmt->bindValue(":banner", $banner, PDO::PARAM_STR);
        $pdostmt->bindValue(":address", $address, PDO::PARAM_STR);
        $pdostmt->bindValue(":province", $province, PDO::PARAM_STR);
        $pdostmt->bindValue(":latitude", $latitude, PDO::PARAM_STR);
        $pdostmt->bindValue(":longitude", $longitude, PDO::PARAM_STR);
        $pdostmt->bindValue(":phone_number", $phone_number, PDO::PARAM_STR);
        $pdostmt->execute();
    }
    
}