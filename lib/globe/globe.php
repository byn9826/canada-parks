<?php
#author: Bao
class Globe {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    #get public header navi links
    public function getHeader() {
        $query = 'SELECT * FROM nav_header';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
