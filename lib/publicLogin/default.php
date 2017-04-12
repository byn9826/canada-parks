<?php
//author: Bao

//class for login, logout, sign up, google login, forget password
class PublicLogin {
    private $db;

    //Get db string
    public function __construct($db) {
        $this->db = $db;
    }

    //valid email when there are multple record there
    public function conflictValid($name, $email, $password, $token) {
        //double check if it is the right time to use this function
        $query = 'SELECT * FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        //preven ajax call for fake valid process
        $prev = 0;
        if ($pdostmt->rowCount() > 1) {
            foreach ($result as $r) {
                if ($r['email_valid'] == $token) {
                    $prev = 1;
                }
            }
            if ($prev == 1) {
                $delQuery = 'DELETE FROM user WHERE user_email = :email';
                $inQuery = 'INSERT INTO user (user_name, user_password, user_email, user_reg, accept_term, email_valid)
                            VALUES (:name, :password, :email, :reg, 1, 1)';
                $deQuery = 'INSERT INTO user_details (user_id, first_name, joined_on, image_src)
                                                  VALUES (:user_id, :first_name, :joined_on, :image_src)';
                try {
                    $delPdostmt = $this->db->prepare($delQuery);
                    $delPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $this->db->beginTransaction();
                    $delPdostmt->execute();
                    $inPdostmt = $this->db->prepare($inQuery);
                    $inPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $inPdostmt->bindValue(':name', $name, PDO::PARAM_STR);
                    $inPdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
                    $currentDate = date('Y-m-d H:i:s');
                    $inPdostmt->bindValue(':reg', $currentDate);
                    $inPdostmt->execute();
                    $dePdostmt = $this->db->prepare($deQuery);
                    $new_id = $this->db->lastInsertId();
                    $dePdostmt->bindValue(':user_id', $new_id, PDO::PARAM_INT);
                    $dePdostmt->bindValue(':first_name', $name, PDO::PARAM_STR);
                    $currentDate = date('Y-m-d H:i:s');
                    $dePdostmt->bindValue(':joined_on', $currentDate);
                    $image = 'default.png';
                    $dePdostmt->bindValue(':image_src', $image, PDO::PARAM_STR);
                    $dePdostmt->execute();
                    $this->db->commit();
                    return [$name, $new_id];
                }   catch(PDOExecption $e) {
                    $this->db->rollback();
                }
                return 0;
            } else {
                return false;
            }
        }
        //not allow to use this function for any other situation
        else {
            return false;
        }
    }

    //send email for forget password
    public function forgetPass($email) {
        //get all related account by email
        $query = 'SELECT * FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        //return 2 for email not verified
        if ($pdostmt->rowCount() > 1) {
            return 2;
        }
        //return 0 for email not exist
        else if ($pdostmt->rowCount() == 0) {
            return 0;
        } else {
            //If email is valid, send email for change password
            if ($result[0]['email_valid'] == 1) {
                $date = new DateTime();
                $random = $date->getTimestamp();
                $combine = 'dc*yqw@dcasg' . $random . 'ibndw$528t*';
                $string = sha1(md5($combine));
                //set forget_token
                $query1 = 'UPDATE user SET forget_token = :string WHERE user_email = :email';
                $result_code = 3;
                try {
                    $pdostmt1 = $this->db->prepare($query1);
                    $pdostmt1->bindValue(':string', $string, PDO::PARAM_STR);
                    $pdostmt1->bindValue(':email', $email, PDO::PARAM_STR);
                    $this->db->beginTransaction();
                    $result_code = $string;
                    $pdostmt1->execute();
                    $this->db->commit();
                } catch(PDOExecption $e) {
                    $this->db->rollback();
                }
                return $result_code;
            }
            //return 2 for email not valid
            else {
                return 2;
            }
        }
    }

    public function retrievePass($email, $password, $token) {
        //update password as new password
        $query = 'UPDATE user SET user_password = :password, forget_token = NULL WHERE user_email = :email AND forget_token = :token';
        try {
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
            $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostmt->bindValue(':token', $token, PDO::PARAM_STR);
            $this->db->beginTransaction();
            $pdostmt->execute();
            $this->db->commit();
            if ($pdostmt->rowCount() == 1) {
                $query1 = 'SELECT * FROM user WHERE user_email = :email';
                $pdostmt1 = $this->db->prepare($query1);
                $pdostmt1->bindValue(':email', $email, PDO::PARAM_STR);
                $pdostmt1->execute();
                $result = $pdostmt1->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return false;
            }

        } catch(PDOExecption $e) {
            $this->db->rollback();
        }
        return false;
    }
}
