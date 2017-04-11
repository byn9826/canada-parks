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
