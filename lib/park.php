<?php

//Author: Sam

class Park {
    private $apiKey = '?key=AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k';
    private $photoAPI = 'https://maps.googleapis.com/maps/api/place/photo';
    
    public function renderPhoto($photoReference) {
        $photo = $this->photoAPI . $this->apiKey . '&maxwidth=400&photoreference=' . $photoReference;
        return $photo;
    }
}