<?php
class IPLocation {

    public static function getLocation() {
        $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $url = "http://freegeoip.net/json/$ip";
        $ch  = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);
        
        if ($data) {
            $location = json_decode($data);
        
            $lat = $location->latitude;
            $lng = $location->longitude;
        
            // $sun_info = date_sun_info(time(), $lat, $lon);
            // print_r($sun_info);
            return array('lat' => $lat, 'lng' => $lng);
        }
    }
}

?>