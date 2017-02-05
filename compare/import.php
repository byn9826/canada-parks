<?php

$parks = array();
$apiKey = 'AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k';
$searchAPi = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=canada+national+park&key=' . $apiKey;
$detailAPI = 'https://maps.googleapis.com/maps/api/place/details/json';
$result = json_decode(file_get_contents($searchAPi), true);
foreach ($result['results'] as $park) {
    $place_id = $park['place_id'];
    $park = json_decode(file_get_contents($detailAPI . '?placeid=' . $place_id . '&key=' . $apiKey), true);
    $parks[] = $park['result'];
    //var_dump($park['result']);
}

// while (!empty($result['next_page_token'])) {
//     var_dump($result['next_page_token']);
//     $result = json_decode((file_get_contents($searchAPi . '&pagetoken=' . $result['next_page_token'] )), true);
//     foreach ($result['results'] as $park) {
//         $parks[] = $park;
//     }
// }
//die;

$dbhost = 'sql9.freemysqlhosting.net';
$dbuser = 'sql9156605';
$dbpass = 'FadNqjljSt';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

if(! $conn ) {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db('sql9156605');

foreach ($parks as $park) {
    $id = $park['place_id'];
    $name = $park['name'];
    $banner = '';
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
    
    $sql = "INSERT INTO park (google_place_id, name, banner, address, province, province_code, latitude, longitude)" . 
    "VALUES ( '$id', '$name', '$banner', '$address', '$province', '$province_code', '$latitdue', '$longitude')";
    // echo $sql;
    // die;
    $retval = mysql_query( $sql, $conn );   
}


mysql_close($conn);
die;