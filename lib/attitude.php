<?php
#author: BAO
#Class used for rating parks
class Attitude{

    #Init class with db string
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    #search all attitude for current park
    public function getAttitude($parkId) {
        $rateQuery = 'SELECT * FROM attitude WHERE park_id = :park';
        $rateStmt = $this->db->prepare($rateQuery);
        $rateStmt->bindValue(':park', $parkId, PDO::PARAM_INT);
        $rateStmt->execute();
        return $rateStmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
