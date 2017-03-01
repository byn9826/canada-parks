<?php
#author: Bao
class PublicLogin {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    #check if user submit true name and password
    public function checkLogin($username, $password) {
        $query = 'SELECT user_id, user_name FROM user WHERE user_name = :name AND user_password = :password';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':name', $username, PDO::PARAM_STR);
        $pdostmt->bindValue(':password', $password, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetch(PDO::FETCH_OBJ);
        #check if there's name pass match in db
        if ($pdostmt->rowCount() === 1) {
            return $result;
        } else {
            return false;
        }
    }
    #update user table for user sign up
    public function signUp($username, $password, $email) {
        echo $username . $password . $email;
        $query = 'INSERT INTO user (user_name, user_password, user_email, user_reg) VALUES (:name, :password, :email, :reg)';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':name', $username, PDO::PARAM_STR);
        $pdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->bindValue(':reg', '2017-01-01', PDO::PARAM_STR);
        $pdostmt->execute();
        return $pdostmt->rowCount();
    }
}
