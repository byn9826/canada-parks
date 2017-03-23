<?php
//author: Bao

//class for login, logout, sign up, google login, forget password
class PublicLogin {
    private $db;

    //Get db string
    public function __construct($db) {
        $this->db = $db;
    }

    //Sign up
    public function signUp($username, $password, $email) {
        //Search if there are existing email address
        $query = 'SELECT * FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        //signup steps for no Google Login users
        if (!isset($_SESSION['google_id'])) {
            //Can't resigter if email account exist and email account already valid
            if($pdostmt->rowCount() == 1 && $result[0]['email_valid'] == 1) {
                return 'duplicate';
            }
            //create account and send verify email for situations below:
            //1. rowCount() =1, email_valid !=1
            //2. rowCount() =0
            //3. rowCount() > 1
            else {
                //create new row into user
                $upQuery = 'INSERT INTO user (user_name, user_password, user_email, user_reg, accept_term, email_valid)
                            VALUES (:name, :password, :email, :reg, 1, :valid)';
                //Init db update fail code
                try {
                    $upPdostmt = $this->db->prepare($upQuery);
                    $upPdostmt->bindValue(':name', $username, PDO::PARAM_STR);
                    $upPdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
                    $upPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $currentDate = date('Y-m-d H:i:s');
                    $upPdostmt->bindValue(':reg', $currentDate);
                    $string = $username . '-!+a4mc1uw]&' . $email;
                    $encrypted = openssl_encrypt($string, 'AES-128-ECB', 'hm!f$#abas&adsf');
                    $result_code = $string;
                    $upPdostmt->bindValue(':valid', $encrypted, PDO::PARAM_STR);
                    $this->db->beginTransaction();
                    $upPdostmt->execute();
                    $this->db->commit();
                } catch(PDOExecption $e) {
                    $this->db->rollback();
                    $result_code = '0';
                }
                return $result_code;
            }
        }
        //for google login user
        else {
            //not account exist for current gmail address, directly create account no need for validation
            if($pdostmt->rowCount() == 0) {
                //create new row into user
                $upQuery = 'INSERT INTO user (user_name, user_password, user_email, google_id, user_reg, accept_term, email_valid)
                            VALUES (:name, :password, :email, :google, :reg, 1, 1)';
            }
            //Directly overwrite name, password, if one same gmail acccount exist but not valid
            else if ($pdostmt->rowCount() == 1) {
                $upQuery = 'UPDATE user SET user_name = :name, user_password = :password, google_id = :google, user_reg = :reg, accept_term = 1, email_valid = 1
                            WHERE user_email = :email';
            }
            //If there are multi invalid email signup request. Delete all first, then insert
            else if ($pdostmt->rowCount() > 1) {
                $delQuery = 'DELETE FROM user WHERE user_email = :email';
                $upQuery = 'INSERT INTO user (user_name, user_password, user_email, google_id, user_reg, accept_term, email_valid)
                            VALUES (:name, :password, :email, :google, :reg, 1, 1)';
            }
            //update user detail tabel same time
            $sQueryUserDetails = 'INSERT INTO user_details (user_id, first_name, joined_on, image_src)
                                  VALUES (:user_id, :first_name, :joined_on, :image_src)';
            //Init db update fail code
            $rowAffected = 0;
            try {
                if ($pdostmt->rowCount() > 1) {
                    $delPdostmt = $this->db->prepare($delQuery);
                    $delPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $delPdostmt->execute();
                }
                $upPdostmt = $this->db->prepare($upQuery);
                $upPdostmt->bindValue(':name', $username, PDO::PARAM_STR);
                $upPdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
                $upPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                $upPdostmt->bindValue(':google', $_SESSION['google_id'], PDO::PARAM_INT);
                $currentDate = date('Y-m-d H:i:s');
                $upPdostmt->bindValue(':reg', $currentDate);
                $this->db->beginTransaction();
                $upPdostmt->execute();
                //insert into user detail table function wrote by Irfaan
                // Capture the new inserted id
                if($pdostmt->rowCount() == 0 || $pdostmt->rowCount() > 1) {
                    $new_id = $this->db->lastInsertId();
                } else if ($pdostmt->rowCount() == 1) {
                    $new_id = $result[0]['user_id'];
                }
                $PDOStmt2 = $this->db->prepare($sQueryUserDetails);
                $PDOStmt2->bindValue(':user_id', $new_id, PDO::PARAM_INT);
                $PDOStmt2->bindValue(':first_name', $username, PDO::PARAM_STR);
                $PDOStmt2->bindValue(':joined_on', $currentDate);
                $PDOStmt2->bindValue(':image_src', $_SESSION["google_profile"], PDO::PARAM_STR);
                $PDOStmt2->execute();
                $this->db->commit();
                if(!isset($_SESSION)){
                    session_start();
                }
                $_SESSION['user_name'] = $username;
                $_SESSION['user_id'] = $new_id;
                $rowAffected = 1;
            } catch(PDOExecption $e) {
                $this->db->rollback();
            }
            return $rowAffected;
        }
    }

    //regular login without google
    public function checkLogin($email, $password) {
        //search all accounts with same email
        $query = 'SELECT user_id, user_name, email_valid, user_password FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        //check email, password pair
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        //if there are more than one rows, account not valid, redirect to require activate page with same email and password
        if ($pdostmt->rowCount() > 1) {
            foreach ($result as $r) {
                if ($r['user_password'] == $password) {
                    $username = $r['user_name'];
                }
            }
            return 'email=' . $email . '&name=' . $username;
        }
        //there are one row
        else if ($pdostmt->rowCount() == 1) {
            //if email not valid
            if ($result[0]['email_valid'] != 1) {
                return 'email=' . $email . '&name=' . $username;
            }
            //if
            else {
                return $result[0];
            }
        }
        //if no account exist
        else {
            return false;
        }
    }

    //Google login
    public function googleLogin($id, $email) {
        $query = 'SELECT user_id, user_name, google_id, email_valid FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        //if email address already used to signup multi-times redirect to signup page
        //if email not exist redirect to signup page
        if ($pdostmt->rowCount() > 1 || $pdostmt->rowCount() == 0) {
            return false;
        }
        //if email has been used to signup once
        else {
            //if google id already exist
            if ($result[0]['google_id']) {
                return $result[0];
            }
            //if google id not exist and email address is not verified, redirect to signup page
            else if ($result[0]['google_id'] == NULL && ($result[0]['email_valid'] != 1)) {
                return false;
            }
            //if email valid, update row and return result
            else {
                $query1 = 'UPDATE user SET google_id = :google, email_valid = 1 WHERE user_email = :email';
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
                return $result[0];
            }
        }
    }

    //Verify email address for new user
    public function verifyEmail($username, $email, $token) {
        //search for how many account have been created by this email
        $query = 'SELECT user_id, user_name, email_valid FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        //prevent fake ajax call for email valid
        $prev = 0;
        foreach ($result as $r) {
            if ($r['email_valid'] == $token) {
                $prev = 1;
            }
        }
        if ($prev == 0) {
            return false;
        }
        //if email has been used to register more than once
        if ($pdostmt->rowCount() > 1) {
            //return code stand for force password change
            return 3;
        }
        //email be used to register only once
        else if ($pdostmt->rowCount() == 1) {
            //if email already verified
            if ($result[0]['email_valid'] == 1) {
                return 1;
            }
            //if not valid yet, valid it
            else {
                $isupdate = 0;
                try {
                    //set email valid to 1
                    $uQuery = 'Update user SET email_valid = 1 WHERE user_name = :username AND user_email = :email';
                    $uPdostmt = $this->db->prepare($uQuery);
                    $uPdostmt->bindValue(':username', $username, PDO::PARAM_STR);
                    $uPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $this->db->beginTransaction();
                    $uPdostmt->execute();
                    $this->db->commit();
                    //Insert into user detail table
                    $sQueryUserDetails = 'INSERT INTO user_details (user_id, first_name, joined_on, image_src)
                                          VALUES (:user_id, :first_name, :joined_on, :image_src)';
                    $PDOStmt2 = $this->db->prepare($sQueryUserDetails);
                    $new_id = $result[0]['user_id'];
                    $PDOStmt2->bindValue(':user_id', $new_id, PDO::PARAM_INT);
                    $PDOStmt2->bindValue(':first_name', $username, PDO::PARAM_STR);
                    $currentDate = date('Y-m-d H:i:s');
                    $PDOStmt2->bindValue(':joined_on', $currentDate);
                    $image = 'default.png';
                    $PDOStmt2->bindValue(':image_src', $image, PDO::PARAM_STR);
                    $PDOStmt2->execute();
                    $this->db->beginTransaction();
                    $this->db->commit();
                    $isupdate = $result[0];
                } catch(PDOExecption $e) {
                    $this->db->rollback();
                }
                return $isupdate;
            }
        }
        //if account not exist
        else {
            return false;
        }
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

    //SET UP COOKIE FOR user check remember me
    public function activeCookieLogin($email, $string) {
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
    public function useCookieLogin($token) {
        $query = 'SELECT user_id, user_name FROM user WHERE cookie_token = :token';
        try {
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':token', $token, PDO::PARAM_STR);
            $pdostmt->execute();
            $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
            if ($pdostmt->rowCount() == 1) {
                return $result[0];
            }
        } catch(PDOExecption $e) {
            return 0;
        }
    }


}
