<?php
//Author: Sam
require_once "ParkRepository.php";


class ParkImport {
    private $apiKey = "?key=AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k";
    private $searchAPi = "https://maps.googleapis.com/maps/api/place/textsearch/json";
    private $detailAPI = "https://maps.googleapis.com/maps/api/place/details/json";
    private $photoAPI = "https://maps.googleapis.com/maps/api/place/photo";
    private $parkrepository;
    
    public function __construct() {
        $this->parkrepository = new ParkRepository();
    }
    
    public function getParks($query) {
        $url = $this->searchAPi . $this->apiKey . "&query=" . $query;
        $res = json_decode(file_get_contents($url), true);
        
        $parks = $res["results"];
        foreach ($parks as $p) {
            $park = $this->getPark($p["place_id"]);
            $this->insertPark($park);
        }
        
        sleep(2);
        while (!empty($res["next_page_token"])) {
            $nextUrl = $url . "&pagetoken=" . $res["next_page_token"];
            $res = json_decode(file_get_contents($nextUrl), true);
            $parks = $res["results"];
            foreach ($parks as $p) {
                $park = $this->getPark($p["place_id"]);
                $this->insertPark($park);
            }
        }
    }
    
    public function getPark($place_id) {
        $url = $this->detailAPI . $this->apiKey . "&placeid=" . $place_id;
        $res = json_decode(file_get_contents($url), true);
        return $res["result"];
    }
    
    public function insertPark($park) {
        
        $google_place_id = $park["place_id"];
        $name = $park["name"];
        $banner = "";
        
        if ($park["photos"]) {
            foreach ($park["photos"] as $photo) {
                if (isset($photo["photo_reference"])) {
                    $photoUrl = $this->photoAPI . $this->apiKey . "&maxwidth=1200&photoreference=" . $photo["photo_reference"];
                    break;
                }
            }
        }
        
        $ch = curl_init($photoUrl);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
        curl_exec($ch);
        $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        
        if ($target) {
            $banner = $target;
        }
        
        $address = $park["formatted_address"];
        $province = "";
        $province_code = "";
        $country = "";
        $country_code = "";
        $postal_code = "";
        
        foreach ($park["address_components"] as $component) {
            if ($component["types"][0] == "administrative_area_level_1") {
                $province = $component["long_name"];
                $province_code = $component["short_name"];
            }
            
            if ($component["types"][0] == "country") {
                $country_code = $component["short_name"];
                $country = $component["long_name"];
            }
            
            if ($component["types"][0] == "postal_code" || $component["types"][0] == "postal_code_prefix") {
                $postal_code = $component["long_name"];
            }
        }

        $latitude = strval($park["geometry"]["location"]["lat"]);
        $longitude = strval($park["geometry"]["location"]["lng"]);
        
        $phone_number = $park["international_phone_number"];
        $rating = $park["rating"];
        $website = $park["website"];
        
        $newPark = array(
            "name" => $name,
            "google_place_id" => $google_place_id,
            "banner" => $banner,
            "description" => $description,
            "address" => $address,
            "province" => $province,
            "province_code" => $province_code,
            "country" => $country,
            "country_code" => $country_code,
            "postal_code" => $postal_code,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "phone_number" => $phone_number,
            "website" => $website,
        );
        
        $this->parkrepository->addPark($newPark, array());
    }
}

$pi = new ParkImport();
$pi->getParks("canada+national+park");