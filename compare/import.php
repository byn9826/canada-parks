<?php

class ParkImport {
    private $apiKey = '?key=AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k';
    private $searchAPi = 'https://maps.googleapis.com/maps/api/place/textsearch/json';
    private $detailAPI = 'https://maps.googleapis.com/maps/api/place/details/json';
    private $photoAPI = 'https://maps.googleapis.com/maps/api/place/photo';
    private $conn;
    
    public function connectDB() {
        $dbhost = 'sql9.freemysqlhosting.net';
        $dbuser = 'sql9156605';
        $dbpass = 'FadNqjljSt';
        $this->conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbuser);
        
        if(! $this->conn ) {
          die('Could not connect: ' . mysqli_error());
        }
    }
    
    public function disconnectDB() {
        mysqli_close($this->conn);
    }
    
    public function getParks($query) {
        $url = $this->searchAPi . $this->apiKey . '&query=' . $query;
        $res = json_decode(file_get_contents($url), true);
        $parks = $res['results'];
        foreach ($parks as $p) {
            $park = $this->getPark($p['place_id']);
            
            $this->insertPark($park);
        }
    }
    
    public function getPark($place_id) {
        $url = $this->detailAPI . $this->apiKey . '&placeid=' . $place_id;
        $res = json_decode(file_get_contents($url), true);
        return $res['result'];
    }
    
    public function insertPark($park) {
        $this->connectDB();
        
        $id = $park['place_id'];
        $name = $park['name'];
        $banner = '';
        $photo_reference = $park['photos'][0]['photo_reference'];
        
        $address = $park['formatted_address'];
        $province = '';
        $province_code = '';
        foreach ($park['address_components'] as $component) {
            if ($component['types'][0] == 'administrative_area_level_1') {
                $province = $component['long_name'];
                $province_code = $component['short_name'];
            }
        }
        $latitdue = strval($park['geometry']['location']['lat']);
        $longitude = strval($park['geometry']['location']['lng']);
        
        $sql = "INSERT INTO park (google_place_id, name, banner, photo_reference, address, province, province_code, latitude, longitude)" . 
        "VALUES ( '$id', '$name', '$banner', '$photo_reference', '$address', '$province', '$province_code', '$latitdue', '$longitude')";
        $retval = mysqli_query($this->conn, $sql);
        
        $this->disconnectDB();
    }
}

// $pi = new ParkImport();
// $pi->getParks('canada+national+park');

// while (!empty($result['next_page_token'])) {
//     var_dump($result['next_page_token']);
//     $result = json_decode((file_get_contents($searchAPi . '&pagetoken=' . $result['next_page_token'] )), true);
//     foreach ($result['results'] as $park) {
//         $parks[] = $park;
//     }
// }
//die;