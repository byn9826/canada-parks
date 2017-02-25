<?php
//Author: Sam

class ParkImport {
    public function getParks($query) {
        $url = $this->searchAPi . $this->apiKey . '&query=' . $query;
        $res = json_decode(file_get_contents($url), true);
        
        $parks = $res['results'];
        foreach ($parks as $p) {
            $park = $this->getPark($p['place_id']);
            $this->insertPark($park);
        }
        
        sleep(2);
        while (!empty($res['next_page_token'])) {
            $nextUrl = $url . '&pagetoken=' . $res['next_page_token'];
            $res = json_decode(file_get_contents($nextUrl), true);
            $parks = $res['results'];
            foreach ($parks as $p) {
                $park = $this->getPark($p['place_id']);
                $this->insertPark($park);
            }
        }

    }
    
    public function getPark($place_id) {
        $url = $this->detailAPI . $this->apiKey . '&placeid=' . $place_id;
        $res = json_decode(file_get_contents($url), true);
        return $res['result'];
    }
    
    public function insertPark($park) {
        
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
        
        $phone_number = $park['international_phone_number'];
        //$rating = $park['rating'];
    }
}

$pi = new ParkImport();
$pi->getParks('canada+national+park');

// while (!empty($result['next_page_token'])) {
//     var_dump($result['next_page_token']);
//     $result = json_decode((file_get_contents($searchAPi . '&pagetoken=' . $result['next_page_token'] )), true);
//     foreach ($result['results'] as $park) {
//         $parks[] = $park;
//     }
// }
//die;