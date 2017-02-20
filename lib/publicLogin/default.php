<?php
#Paul
class PublicLogin {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    #check if user submit true name and password
    public function checkLogin($username, $password) {
        $query = 'SELECT * FROM user WHERE user_name = :name AND user_password = :password';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':name', $username, PDO::PARAM_STR);
        $pdostmt->bindValue(':password', $password, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result);
    }
}
