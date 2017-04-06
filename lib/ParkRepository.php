<?php

include "Upload.php";
//Author: Sam

class ParkRepository {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getParks($name = "", $province = "") {
        $sql = "SELECT id, name, banner, province, latitude, longitude FROM park";
        $pdostmt = $this->db->prepare($sql);

        if (!empty($name)) {
            $sql = $sql . " WHERE name LIKE :name";
        }

        if (!empty($province)) {
            $sql = $sql . " WHERE province_code = :province";
        }

        if (!empty($name) && !empty($province)) {
            $sql = $sql . " WHERE name LIKE :name AND province_code = :province";
        }

        $pdostmt = $this->db->prepare($sql);
        if (!empty($name)) {
            $name = "%" . $name . "%";
            $pdostmt->bindValue(":name", $name, PDO::PARAM_STR);
        }

        if (!empty($province)) {
            $pdostmt->bindValue(":province", $province, PDO::PARAM_STR);
        }
        $pdostmt->execute();
        return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProvinces() {
        $sql = "SELECT DISTINCT(province), province_code FROM park";
        $pdostmt = $this->db->prepare($sql);
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

        $sql = "INSERT INTO park (google_place_id, name, banner, description, address, province, province_code, country, country_code, postal_code, latitude, longitude, phone_number, rating, website)" .
        "VALUES ( :google_place_id, :name, :banner, :description, :address, :province, :province_code, :country, :country_code, :postal_code, :latitude, :longitude, :phone_number, 0.0, :website)";

        return $this->parkOperation($park, $upload, $sql);

    }

    public function updatePark($park, $upload) {

        $sql = "UPDATE park SET
            google_place_id = :google_place_id,
            name = :name,
            banner = :banner,
            address = :address,
            description = :description,
            province = :province,
            province_code = :province_code,
            country = :country,
            country_code = :country_code,
            postal_code = :postal_code,
            latitude = :latitude,
            longitude = :longitude,
            phone_number = :phone_number,
            website = :website
        WHERE id = :id ";

        return $this->parkOperation($park, $upload, $sql);

    }

    public function parkOperation($park, $upload, $sql) {
        if (isset($park["id"])) {
            $id = $park["id"];
        }
        $name = $park["name"];
        $google_place_id = $park["google_place_id"];
        $banner = $park["banner"];
        $description = $park["description"];
        $address = $park["address"];
        $province = $park["province"];
        $province_code = $park["province_code"];
        $country = $park["country"];
        $country_code = $park["country_code"];
        $postal_code = $park["postal_code"];
        $latitude = $park["latitude"];
        $longitude = $park["longitude"];
        $phone_number = $park["phone_number"];
        $website = $park["website"];

        if (isset($upload["name"]) && !empty($upload["name"])) {
            $u = new Upload();
            $banner = $u->toServer($upload);
        }

        $pdostmt = $this->db->prepare($sql);

        if (isset($id)) {
            $pdostmt->bindValue(":id", $id, PDO::PARAM_STR);
        }
        $pdostmt->bindValue(":google_place_id", $google_place_id, PDO::PARAM_STR);
        $pdostmt->bindValue(":name", $name, PDO::PARAM_STR);
        $pdostmt->bindValue(":banner", $banner, PDO::PARAM_STR);
        $pdostmt->bindValue(":address", $address, PDO::PARAM_STR);
        $pdostmt->bindValue(":description", $description, PDO::PARAM_STR);
        $pdostmt->bindValue(":province", $province, PDO::PARAM_STR);
        $pdostmt->bindValue(":province_code", $province_code, PDO::PARAM_STR);
        $pdostmt->bindValue(":country", $country, PDO::PARAM_STR);
        $pdostmt->bindValue(":country_code", $country_code, PDO::PARAM_STR);
        $pdostmt->bindValue(":postal_code", $postal_code, PDO::PARAM_STR);
        $pdostmt->bindValue(":latitude", $latitude, PDO::PARAM_STR);
        $pdostmt->bindValue(":longitude", $longitude, PDO::PARAM_STR);
        $pdostmt->bindValue(":phone_number", $phone_number, PDO::PARAM_STR);
        $pdostmt->bindValue(":website", $website, PDO::PARAM_STR);
        try {
            $pdostmt->execute();
            // print_r($pdostmt->errorInfo());
            // die;
            return array("code" => 200, "msg" => "success");
        } catch (PDOException $e) {
            return array("code" => 500, "msg" => "fail");
        }
    }

    public function getNumParksWithProvince() {
        $sql = "SELECT COUNT(*) as y, province FROM park GROUP BY province";
        $pdostmt = $this->db->prepare($sql);
        $pdostmt->execute();
        $datas = $pdostmt->fetchAll();
        $result = array();
        foreach ($datas as $data) {
            $result[] = array(
                "province" => $data["province"],
                "y" => intval($data["y"])
            );
        }
        return $result;
    }

    public function getFootprintStatic() {
        $sql = "SELECT COUNT(user_id) as num_user, park.name FROM footprints JOIN park WHERE park.id = footprints.park_id GROUP BY footprints.park_id";
        $pdostmt = $this->db->prepare($sql);
        $pdostmt->execute();
        $datas = $pdostmt->fetchAll();
        $result = array();
        foreach ($datas as $data) {
            $result[] = array(
                "parkName" => $data["name"],
                "y" => intval($data["num_user"])
            );
        }
        return $result;

    }

    public static function getParksForDropDown($objConnection) {
        // Query to select all parks
        $sQuery = "SELECT * FROM park ORDER BY name";
        $objPDOStatement = $objConnection->prepare($sQuery);
        $objPDOStatement->execute();
        $lstParks = $objPDOStatement->fetchAll(PDO::FETCH_OBJ);

        // Construct options mark-up for the dropdown
        $result = '';
        foreach ($lstParks as $objPark) {
            $result .= '<option value="' . $objPark->id . '"';
            $result .= ' >' . $objPark->name . '</option>';
        }
        return $result;
    }
}
