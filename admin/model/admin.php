<?php

/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 2/11/2017
 * Time: 6:13 PM
 */
class AdminUser
{
    private $user_id;
    private $user_name;
    private $user_password;
    private $user_email;
    private $user_reg;
    private $google_id;
    private $accept_term;
    private $role_id;
    private $user_status;

    public function setUserID($value){
        $this->user_id = $value ;
    }

    public function getUserID(){
        return $this->user_id;
    }

    public function setUserName($value){
        $this->user_name = $value;
    }

    public function getUserName(){
        return $this->user_name;
    }

    public function setUserPassword($value){
        $this->user_password = $value;
    }

    public function getUserPassword(){
        return $this->user_password;
    }

    public function setUserEmail($value){
        $this->user_email = $value;
    }

    public function getUserEmail(){
        return $this->user_email;
    }

    public function setUserRegDate($value){
        $this->user_reg = $value;
    }

    public function getUserRegDate(){
        return $this->user_reg;
    }

    public function setGoogleId($value){
        $this->google_id = $value;
    }

    public function getGoogleId(){
        return $this->google_id;
    }

    public function setAcceptTerm($value){
        $this->accept_term = $value;
    }

    public function getAcceptTerm(){
        return $this->accept_term;
    }

    public function setRoleId($value){
        $this->role_id = $value;
    }

    public function getRoleId(){
        return $this->role_id;
    }

    public function setUserStatus($value){
        $this->user_status = $value;
    }

    public function getUserStatus(){
        return $this->user_status;
    }

    public function __construct($myName, $myPassword, $myEmail, $myAcceptTerm = 0, $myRoleId = 0, $myUser_Status = 0)
    {
        $this->setUserName($myName);
        $this->setUserEmail($myEmail);
        $this->setUserRegDate(date("Y-m-d"));
        $this->setUserPassword(sha1($myPassword));
    }

    public static function getAllUsers($db, $id){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM user WHERE user_id != :user_id ORDER BY role_id DESC";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':user_id', $id, PDO::PARAM_INT);
            $pdostament->execute();
            $userArr = $pdostament->fetchAll(PDO::FETCH_OBJ);
            //var_dump($userArr);
            return $userArr;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function getAllRoles($db){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM role";
            $pdostament = $db->prepare($query);
            $pdostament->execute();
            $roleArr = $pdostament->fetchAll(PDO::FETCH_OBJ);
            //var_dump($userArr);
            return $roleArr;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    /*public function addNewAdmin($fname, $lname, $email, $password, $gender){
        $db = Database::getDB();
        try {
            $query = "INSERT INTO admin(first_name, last_name, gender, email, password) VALUES(:first_name, :last_name, :gender, :email, :password)";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':first_name', $fname, PDO::PARAM_STR);
            $pdostament->bindValue(':last_name', $lname, PDO::PARAM_STR);
            $pdostament->bindValue(':gender', $gender, PDO::PARAM_STR);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostament->bindValue(':password', $password, PDO::PARAM_STR);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }*/

    public static function updateUserRole($db, $id, $roleId){
        //$db = Database::getDB();
        try {
            $query = "UPDATE user SET role_id = :role_id WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':role_id', $roleId, PDO::PARAM_INT);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }


    public static function updateUserStatus($db, $user){
        //$db = Database::getDB();
        try {
            $query = "UPDATE user SET user_status = :status WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            //var_dump($user);
            $newStatus = ($user->user_status == 0) ? 1 : 0;
            //var_dump($newStatus);
            $pdostament->bindValue(':status', $newStatus, PDO::PARAM_INT);
            $pdostament->bindValue(':id', $user->user_id, PDO::PARAM_INT);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function updatePassword($db, $id, $email, $password){
        //$db = Database::getDB();
        try {
            $query = "UPDATE user SET user_password = :password WHERE user_id = :id AND user_email = :email";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':password', $password, PDO::PARAM_STR);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function searchUsersByEmailOrUsername($db, $term){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM user WHERE user_email LIKE :term OR user_name LIKE :term ORDER BY role_id DESC";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
            $pdostament->execute();
            $userArr = $pdostament->fetchAll(PDO::FETCH_OBJ);
            return $userArr;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function findUserByID($db, $id){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM user WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->execute();
            $user = $pdostament->fetch(PDO::FETCH_OBJ);
            return $user;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function findUserByUsername($db, $username){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM user WHERE user_name = :username";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':username', $username, PDO::PARAM_STR);
            $pdostament->execute();
            $user = $pdostament->fetch(PDO::FETCH_OBJ);
            return $user;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function findUserByEmail($db, $email){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM user WHERE user_email = :email";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostament->execute();
            $user = $pdostament->fetch(PDO::FETCH_OBJ);
            return $user;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function findRoleNameByRoleID($db, $roleId){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM role WHERE role_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':id', $roleId, PDO::PARAM_INT);
            $pdostament->execute();
            $role = $pdostament->fetch(PDO::FETCH_OBJ);
            return $role;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function checkEmailExisted($db, $id, $email){
        //$db = Database::getDB();
        try {
            $query = "SELECT 1 FROM user WHERE user_email = :email AND user_id != :id LIMIT 1";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->execute();
            $existed = $pdostament->fetch(PDO::FETCH_OBJ);
            return $existed;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function checkEmailExistedInDB($db, $email){
        //$db = Database::getDB();
        try {
            $query = "SELECT 1 FROM user WHERE user_email = :email LIMIT 1";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostament->execute();
            $existed = $pdostament->fetch(PDO::FETCH_OBJ);
            return $existed;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function checkUsernameExisted($db, $id, $username){
        //$db = Database::getDB();
        try {
            $query = "SELECT 1 FROM user WHERE user_name = :username AND user_id != :id LIMIT 1";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':username', $username, PDO::PARAM_STR);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->execute();
            $existed = $pdostament->fetch(PDO::FETCH_OBJ);
            return $existed;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function updateUsernameAndEmailForUser($db, $id, $username, $email){
        //$db = Database::getDB();
        try {
            $query = "UPDATE user SET user_email = :email, user_name = :username WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':username', $username, PDO::PARAM_STR);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function deleteUserByID($db, $id){
        //$db = Database::getDB();
        try {
            $query = "DELETE FROM user WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function updateActivation($db, $id, $code = null, $date = null){
        //$db = Database::getDB();
        try {
            $query = "UPDATE user SET activation_code = :code, activation_date = :date WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':code', $code, PDO::PARAM_STR);
            $pdostament->bindValue(':date', $date, PDO::PARAM_STR);
            $pdostament->bindValue(':id', $id, PDO::PARAM_STR);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function updateEmailSubscribe($db, $id, $currentStatus){
        //$db = Database::getDB();
        try {
            $query = "UPDATE user SET email_subscribed = :switch WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $changed = ($currentStatus == 1) ? 0 : 1;
            $pdostament->bindValue(':switch', $changed, PDO::PARAM_INT);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function checkEmailSubscribe($db, $id){
        //$db = Database::getDB();
        try {
            $query = "SELECT email_subscribed FROM user WHERE user_id = :id LIMIT 1";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->execute();
            $existed = $pdostament->fetch(PDO::FETCH_OBJ);
            return $existed;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function findGeneralSubscribers($db){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM user WHERE email_subscribed = 1";
            $pdostament = $db->prepare($query);
            $pdostament->execute();
            $user = $pdostament->fetchAll(PDO::FETCH_OBJ);
            return $user;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function getAllParks($db){
        //$db = Database::getDB();
        try {
            $query = "SELECT * FROM park";
            $pdostament = $db->prepare($query);
            $pdostament->execute();
            $parks = $pdostament->fetchAll(PDO::FETCH_OBJ);
            return $parks;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function getUsersByWishlistAboutParks($db, $listPark){
        //$db = Database::getDB();
        try {
            $query = "SELECT DISTINCT u.* FROM user u JOIN wishlist w ON w.user_id = u.user_id WHERE w.park_id IN ($listPark)";
            $pdostament = $db->prepare($query);
            //$pdostament->bindValue(':listPark', $listPark, PDO::PARAM_STR);
            $pdostament->execute();
            $parks = $pdostament->fetchAll(PDO::FETCH_OBJ);
            return $parks;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function getUsersByListOfUserId($db, $listId){
        //$db = Database::getDB();
        try {
            $query = "SELECT DISTINCT u.* FROM user u JOIN wishlist w ON w.user_id = u.user_id WHERE w.park_id IN ($listPark)";
            $pdostament = $db->prepare($query);
            //$pdostament->bindValue(':listPark', $listPark, PDO::PARAM_STR);
            $pdostament->execute();
            $parks = $pdostament->fetchAll(PDO::FETCH_OBJ);
            return $parks;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }
}
