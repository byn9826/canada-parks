<?php
//author: Bao

//class for login, logout, sign up, google login, forget password
class PublicLogin {
    private $db;

    //Get db string
    public function __construct($db) {
        $this->db = $db;
    }

    //check login if user submit true name and password
    public function checkLogin($email, $password) {
        $query = 'SELECT user_id, user_name, email_valid FROM user WHERE user_email = :email AND user_password = :password';
        $pdostmt = $this->db->prepare($query);
        //check email, password pair
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->bindValue(':password', $password, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetch(PDO::FETCH_OBJ);
        //check if there's name pass match in db
        if ($pdostmt->rowCount() == 1) {
            //If email not verified
            if ($result->email_valid == 0) {
    			return 'email=' . $email . '&name=' . $result->user_name;
            } else {
                //Pass back user id and user name
                return $result;
            }
        } else {
            return false;
        }
    }

    //Sign up, update user table
    //This function wrote by Bao and Irfaan together
    public function signUp($username, $password, $email) {
        //store signup result, 0 for fail
        $iRowAffected = 0;
        // default avatar name when user sign up
        $default_image = 'default.png';
        // get the current date user sign's up
        $currentDate = date('Y-m-d H:i:s');
        //Check if there are duplicated email
        $query = 'SELECT * FROM user WHERE user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetch(PDO::FETCH_OBJ);
        //If email address already exist
        if ($pdostmt->rowCount() >= 1) {
            //Can't overwrite verified email
            if ($result->email_valid == 1) {
                return 'duplicate';
            }
            //overwrite un verified email
            else {
                //for google login users
                if (isset($_SESSION['google_id'])) {
                    $upQuery = 'UPDATE user SET user_name = :name, user_password = :password, google_id = :google WHERE user_email = :email';
                }
                //for basic login user
                else {
                    $upQuery = 'UPDATE user SET user_name = :name, user_password = :password, google_id = null WHERE user_email = :email';
                }
                try {
                    $upPdostmt = $this->db->prepare($upQuery);
                    $upPdostmt->bindValue(':name', $username, PDO::PARAM_STR);
                    $upPdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
                    $upPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    if (isset($_SESSION['google_id'])) {
                        $upPdostmt->bindValue(':google', $_SESSION['google_id'], PDO::PARAM_INT);
                    }
                    $this->db->beginTransaction();
                    $upPdostmt->execute();
                    $this->db->commit();
                    $iRowAffected = 1;
                } catch(PDOExecption $e) {
                    $this->db->rollback();
                }
                return $iRowAffected;
            }
        }
        // Queries to Insert into the user and user_details table
        else {
            //Sign up for google login user
            if (isset($_SESSION['google_id'])) {
                $query = 'INSERT INTO user (user_name, user_password, user_email, user_reg, google_id, accept_term, email_valid) VALUES (:name, :password, :email, :reg, :google, :checked, 0)';
            }
            //sign up for basic login user
            else {
                $query = 'INSERT INTO user (user_name, user_password, user_email, user_reg, accept_term, email_valid) VALUES (:name, :password, :email, :reg, :checked, 0)';
            }
            //user detail table insert
            $sQueryUserDetails = 'INSERT INTO user_details (user_id, first_name, joined_on, image_src)
                                  VALUES (:user_id, :first_name, :joined_on, :image_src)';
            // Create the user loggin credentials
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':name', $username, PDO::PARAM_STR);
            $pdostmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
            $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostmt->bindValue(':checked', 1, PDO::PARAM_INT);
            //If google id exist
            if (isset($_SESSION['google_id'])) {
                $pdostmt->bindValue(':google', $_SESSION['google_id'], PDO::PARAM_INT);
            }
            $pdostmt->bindValue(':reg', $currentDate);
            try {
                $this->db->beginTransaction();
                $pdostmt->execute();
                $new_id = $this->db->lastInsertId();    // Capture the new inserted id
                $PDOStmt2 = $this->db->prepare($sQueryUserDetails);
                $PDOStmt2->bindValue(':user_id', $new_id, PDO::PARAM_INT);
                $PDOStmt2->bindValue(':first_name', $username, PDO::PARAM_STR);
                $PDOStmt2->bindValue(':joined_on', $currentDate);
                if (isset($_SESSION["google_profile"])) {
                    $PDOStmt2->bindValue(':image_src', $_SESSION["google_profile"], PDO::PARAM_STR);
                } else {
                    $PDOStmt2->bindValue(':image_src', $default_image, PDO::PARAM_STR);
                }
                $PDOStmt2->execute();
                $this->db->commit();
                //return 1 stand for success
                $iRowAffected = 1;
            } catch(PDOExecption $e) {
                $this->db->rollback();
            }
            //return signup result
            return $iRowAffected;
        }
    }
    //Google login, check if google user exist in db
    public function googleLogin($id) {
        $query = 'SELECT user_id, user_name, user_email, email_valid FROM user WHERE google_id = :id';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':id', $id, PDO::PARAM_INT);
        $pdostmt->execute();
        $result = $pdostmt->fetch(PDO::FETCH_OBJ);
        if ($pdostmt->rowCount() == 1) {
            //If email is verified
            if ($result->email_valid == 1) {
                return $result;
            }
            //If email is not verfied
            else {
    			return 'email=' . $result->user_email . '&name=' . $result->user_name;
            }
        }
        //if google id not exist
        else {
            return false;
        }
    }

    //Verify email address for new user
    public function verifyEmail($username, $email) {
        $query = 'SELECT user_id, user_name, email_valid FROM user WHERE user_name = :username AND user_email = :email';
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':username', $username, PDO::PARAM_STR);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->execute();
        $result = $pdostmt->fetch(PDO::FETCH_OBJ);
        //if account exist
        if ($pdostmt->rowCount() == 1) {
            //if email already verified
            if ($result->email_valid == 1) {
                return $result;
            }
            //update email_verify colomn
            else {
                $isupdate = 0;
                try {
                    $uQuery = 'Update user SET email_valid = 1 WHERE user_name = :username AND user_email = :email';
                    $uPdostmt = $this->db->prepare($uQuery);
                    $uPdostmt->bindValue(':username', $username, PDO::PARAM_STR);
                    $uPdostmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $this->db->beginTransaction();
                    $uPdostmt->execute();
                    $this->db->commit();
                    $isupdate = $result;
                } catch(PDOExecption $e) {
                    $this->db->rollback();
                }
                return $isupdate;
            }
        } else {
            return false;
        }
    }
}
