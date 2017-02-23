<?php

class Test {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listComment() {
        $query = "SELECT * FROM del";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();
        return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComment($id) {
        $query2 = "SELECT * FROM del WHERE comment_id = :id";
        $pdostmt2 = $this->db->prepare($query2);
        $pdostmt2->bindValue(':id',$id,PDO::PARAM_INT);
        $pdostmt2->execute();
        return $pdostmt2->fetch(PDO::FETCH_OBJ);
    }

}
