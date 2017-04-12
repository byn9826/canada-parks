<?php
//author: Bao

//class for login, logout, sign up, google login, forget password
class Account {
    private $db;

    //Get db string
    public function __construct($db) {
        $this->db = $db;
    }

    //search all account related to one email address
    public function searchEmails($email) {
        //search all accounts with same email
        $query = 'SELECT * FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //change email valid field to valid for valid email page
    public function validEmail($email, $name) {
        $uQuery = 'Update user SET email_valid = 1 WHERE user_name = :username AND user_email = :email';
        try {
            $uPdostmt = $this->db->prepare($uQuery);
            $uPdostmt->bindValue(':username', $name, PDO::PARAM_STR);
            $uPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->db->beginTransaction();
            $uPdostmt->execute();
            $this->db->commit();
            return '1';
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return '0';
        }
    }

    //create a record for success signup before email valid
    public function createRecord($name, $password, $email, $reg, $encrypted, $google) {
        //create new row into user
        $upQuery = 'INSERT INTO user (user_name, user_password, user_email, user_reg, accept_term, email_valid, google_id)
                    VALUES (:name, :password, :email, :reg, 1, :valid, :google)';
        try {
            $upPdostmt = $this->db->prepare($upQuery);
            $upPdostmt->bindValue(':name', $name, PDO::PARAM_STR);
            $upPdostmt->bindValue(':password', $password, PDO::PARAM_STR);
            $upPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
            $upPdostmt->bindValue(':reg', $reg);
            $upPdostmt->bindValue(':valid', $encrypted, PDO::PARAM_STR);
            $upPdostmt->bindValue(':google', $google);
            $this->db->beginTransaction();
            $upPdostmt->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            return $id;
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return '0';
        }
    }

    //delete all related record for one email address
    public function deleteRecord($email) {
        $delQuery = 'DELETE FROM user WHERE user_email = :email';
        try {
            $delPdostmt = $this->db->prepare($delQuery);
            $delPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->db->beginTransaction();
            $delPdostmt->execute();
            $this->db->commit();
            return '1';
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return '0';
        }
    }

    //insert into user detail for valid account
    public function createDetail($id, $name, $reg, $image) {
        $sQuery = 'INSERT INTO user_details (user_id, first_name, joined_on, image_src)
                              VALUES (:user_id, :first_name, :joined_on, :image_src)';
        try {
            $PDOStmt2 = $this->db->prepare($sQuery);
            $PDOStmt2->bindValue(':user_id', $id, PDO::PARAM_INT);
            $PDOStmt2->bindValue(':first_name', $name, PDO::PARAM_STR);
            $PDOStmt2->bindValue(':joined_on', $reg);
            $PDOStmt2->bindValue(':image_src', $image, PDO::PARAM_STR);
            $this->db->beginTransaction();
            $PDOStmt2->execute();
            $this->db->commit();
            return '1';
        } catch(PDOExecption $e) {
            $this->db->rollback();
            return '0';
        }
    }

    //link google id with current account
    public function linkGoogle($id, $email) {
        $query1 = 'UPDATE user SET google_id = :google WHERE user_email = :email AND email_valid = 1';
        try {
            $pdostmt1 = $this->db->prepare($query1);
            $pdostmt1->bindValue(':google', $id, PDO::PARAM_INT);
            $pdostmt1->bindValue(':email', $email, PDO::PARAM_STR);
            $this->db->beginTransaction();
            $pdostmt1->execute();
            $this->db->commit();
        } catch(PDOExecption $e) {
            $this->db->rollback();
        }
    }

    //active cookie if user want and login success
    public function activeCookie($email, $string) {
        $query = 'UPDATE user SET cookie_token = :token WHERE user_email = :email';
        try {
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostmt->bindValue(':token', $string, PDO::PARAM_STR);
            $this->db->beginTransaction();
            $pdostmt->execute();
            $this->db->commit();
            if ($pdostmt->rowCount() == 1) {
                $expire = new DateTime('+1 month');
                setcookie('token', $string, $expire->getTimestamp(), '/', 'localhost', false, true);
            }
        } catch(PDOExecption $e) {
            $this->db->rollback();
        }
    }

    //use cookie to login user
    public function checkCookie($token) {
        $query = 'SELECT user_id, user_name FROM user WHERE cookie_token = :token';
        try {
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':token', $token, PDO::PARAM_STR);
            $pdostmt->execute();
            $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
            //when record exist, return result
            if ($pdostmt->rowCount() == 1) {
                return $result[0];
            } else {
                return false;
            }
        } catch(PDOExecption $e) {
            return false;
        }
    }

}
