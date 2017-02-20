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
    #update user table for user sign up
    public function signUp($username, $password, $email) {
        $query = 'INSERT INTO user (user_id, user_name, user_password, user_email, user_reg) VALUES (:id, :name, :password, :email, :reg)';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':id', 1, PDO::PARAM_INT);
        $pdostmt->bindValue(':name', $username, PDO::PARAM_STR);
        $pdostmt->bindValue(':password', $password, PDO::PARAM_STR);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->bindValue(':reg', strtotime(date('Y-m-d')), PDO::PARAM_STR);
        $pdostmt->execute();
        return $pdostmt->rowCount();
    }
}
