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
        return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    }

    #get three parks with higest rate
    public function getRecommend() {
        $query = 'SELECT park_id, avg(attitude_rate) AS total FROM attitude GROUP BY park_id ORDER BY total DESC LIMIT 0, 3';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        $query1 = 'SELECT id, name, banner FROM park WHERE id = :id1 OR id = :id2 OR id = :id3';
        $pdostmt1 = $this->db->prepare($query1);
        $pdostmt1->bindValue(':id1', $result[0]['park_id'], PDO::PARAM_INT);
        $pdostmt1->bindValue(':id2', $result[1]['park_id'], PDO::PARAM_INT);
        $pdostmt1->bindValue(':id3', $result[2]['park_id'], PDO::PARAM_INT);
        $pdostmt1->execute();
        //combine park info with rate
        $result1 = $pdostmt1->fetchAll(PDO::FETCH_ASSOC);
        $result1[0]['total'] = $result[0]['total'];
        $result1[1]['total'] = $result[1]['total'];
        $result1[2]['total'] = $result[2]['total'];
        return $result1;
    }
}
