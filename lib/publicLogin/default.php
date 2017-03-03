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
        $iRowAffected = 0;
        $default_image = 'default.png'; // default avatar name when user sign up
        $currentDate = date('Y-m-d H:i:s'); // get the current date user sign's up

        // Queries to Insert into the user and user_details table
        $query = 'INSERT INTO user (user_name, user_password, user_email, user_reg) VALUES (:name, :password, :email, :reg)';
        $sQueryUserDetails = 'INSERT INTO user_details (user_id, first_name, joined_on, image_src)
                              VALUES (:user_id, :first_name, :joined_on, :image_src)';

        // Create the user loggin credentials
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':name', $username, PDO::PARAM_STR);
        $pdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->bindValue(':reg', $currentDate);

        try {
            $this->db->beginTransaction();

            $pdostmt->execute();
            $new_id = $this->db->lastInsertId();    // Capture the new inserted id

            $PDOStmt2 = $this->db->prepare($sQueryUserDetails);
            $PDOStmt2->bindValue(':user_id', $new_id, PDO::PARAM_INT);
            $PDOStmt2->bindValue(':first_name', $username, PDO::PARAM_STR);
            $PDOStmt2->bindValue(':joined_on', $currentDate);
            $PDOStmt2->bindValue(':image_src', $default_image, PDO::PARAM_STR);
            $PDOStmt2->execute();

            $this->db->commit();
            $iRowAffected = 1;  // Return 1 if queries executed successfully

        } catch(PDOExecption $e) {
            $this->db->rollback();
        }
        return $iRowAffected;
    }
}
