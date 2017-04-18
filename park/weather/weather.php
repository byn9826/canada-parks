<?php

/**
 * Created by PhpStorm.
 * User: NavRoop
 * Date: 4/3/2017
 * Time: 9:04 AM
 */
class weather
{
    protected $location_ = false;
    protected $current_ = false;
    protected $future_ = false;

    /**
     * Constructor for the weather class
     */
    public function __construct($location){

        //Location must not be empty
        if($location != ""){
            $this->location_ = $location;
            $this->getWeather();
        }
    }

    /**
     * Get the weather from the location in the form
     */
    private function getWeather(){

        //If location is set
        if($this->location_){
            $xml = simplexml_load_file('http://www.google.com/ig/api?weather='.urlencode($this->location_));
            $this->current_ = $xml->xpath("/xml_api_reply/weather/current_conditions");
            $this->future_ = $xml->xpath("/xml_api_reply/weather/forecast_conditions");
        }
    }

    /**
     * Gets the current location
     */
    public function getLocation(){
        return ucwords($this->location_);
    }
}
?>