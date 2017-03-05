<?php

class UserAccount
{
    // Private Declarations
    // --------------------
    private $_objConnection;
    private $_userId;
    private $_username;
    private $_password;
    private $_email;


    // Constructor
    // -----------
    public function __construct($objConnection, $userId)
    {
        $this->_objConnection = $objConnection;
        $this->_userId = $userId;
        // Read user's account information
        $this->pReadUserInfo();
    }


    // Public Properties
    // -----------------
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }


    // Public Functions Declaration
    // ----------------------------
    public function Update() {
        $iRowUpdated = 0;

        try {
            // Query to Update user info
            $sQueryUpdate = "
                            UPDATE user
                               SET user_password = :password
                                 , user_email = :email
                             WHERE user_id = :userId
                            ";
            $objPDOStmt = $this->_objConnection->prepare($sQueryUpdate);
            $objPDOStmt->bindValue(':password', $this->_password, PDO::PARAM_STR);
            $objPDOStmt->bindValue(':email', $this->_email, PDO::PARAM_STR);
            $objPDOStmt->bindValue(':userId', $this->_userId);
            $iRowUpdated = $objPDOStmt->execute();
        } catch (PDOException $e) {
            // Unable to update
        }
        return $iRowUpdated;
    }

    public function DeleteAccount() {
        // TODO: Delete User Account Permanently

        # 1. Delete Wishlist of User
        # 2. Delete Footprints images file
        # 3. Delete Footprints images from DB table
        # 4. Delete Footprints from DB table
        # 5. Delete user details
        # 6. Delete user loggin credentials

    }

    // Private Functions Declaration
    // -----------------------------
    private function pReadUserInfo() {

        // Query to fetch user info
        $sQueryUserInfo = "SELECT * FROM user WHERE user_id = :userId;";
        $objPDOStmt = $this->_objConnection->prepare($sQueryUserInfo);
        $objPDOStmt->bindValue(':userId', $this->_userId);
        $objPDOStmt->execute();

        // Fetch result and fill property values
        $objAccountInfo = $objPDOStmt->fetch(PDO::FETCH_OBJ);

        $this->_username = $objAccountInfo->user_name;
        $this->_email = $objAccountInfo->user_email;
        $this->_password = $objAccountInfo->user_password;

    }

}