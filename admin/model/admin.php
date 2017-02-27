<?php

/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 2/11/2017
 * Time: 6:13 PM
 */
class AdminUser
{
    private $id;
    private $firstName;
    private $lastName;
    private $gender;
    private $email;
    private $password;

    public function setID($value){
        $this->id = $value ;
    }

    public function getID(){
        return $this->id;
    }

    public function setFirstName($value){
        $this->firstName = $value;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function setLastName($value){
        $this->lastName = $value;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function setGender($value){
        $this->gender = $value;
    }

    public function getGender(){
        return $this->gender;
    }

    public function setEmail($value){
        $this->email = $value;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPassword($value){
        $this->password = $value;
    }

    public function getPassword(){
        return $this->password;
    }

    public function __construct($fName, $lName, $gender, $email, $pass)
    {
        $this->setFirstName($fName);
        $this->setLastName($lName);
        $this->setGender($gender);
        $this->setEmail($email);
        $this->setPassword($pass);
    }

    public static function getAllAdminUser(){
        $db = Database::getDB();
        try {
            $query = "SELECT * FROM admin";
            $pdostament = $db->prepare($query);
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

    public function addNewAdmin($fname, $lname, $email, $password, $gender){
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
    }

    public static function updateAdmin($id, $fname, $lname, $gender){
        $db = Database::getDB();
        try {
            $query = "UPDATE admin SET first_name = :first_name, last_name = :last_name, gender = :gender WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':first_name', $fname, PDO::PARAM_STR);
            $pdostament->bindValue(':last_name', $lname, PDO::PARAM_STR);
            $pdostament->bindValue(':gender', $gender, PDO::PARAM_STR);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function updatePassword($id, $email, $password){
        $db = Database::getDB();
        try {
            $query = "UPDATE admin SET password = :password WHERE user_id = :id AND email = :email";
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

    public static function findAdminByEmail($email){
        $db = Database::getDB();
        try {
            $query = "SELECT * FROM admin WHERE email = :email";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostament->execute();
            $admin = $pdostament->fetch(PDO::FETCH_OBJ);
            return $admin;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function findAdminByID($id){
        $db = Database::getDB();
        try {
            $query = "SELECT * FROM admin WHERE user_id = :id";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':id', $id, PDO::PARAM_INT);
            $pdostament->execute();
            $admin = $pdostament->fetch(PDO::FETCH_OBJ);
            return $admin;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function checkEmailExisted($email){
        $db = Database::getDB();
        try {
            $query = "SELECT 1 FROM admin WHERE email = :email LIMIT 1";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $pdostament->execute();
            $row = $pdostament->fetch(PDO::FETCH_OBJ);
            $existed = ($row == 1) ? true : false;
            return $existed;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function deleteAdminByEmail($email){
        $db = Database::getDB();
        try {
            $query = "DELETE FROM admin WHERE email = :email";
            $pdostament = $db->prepare($query);
            $pdostament->bindValue(':email', $email, PDO::PARAM_STR);
            $row = $pdostament->execute();
            return $row;
        } catch (PDOException $e) {
            echo "There is an error: ".$e->getMessage();
        } finally {
            $pdostament->closeCursor();
        }
    }

    public static function deleteAdminByID($id){
        $db = Database::getDB();
        try {
            $query = "DELETE FROM admin WHERE user_id = :id";
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
}