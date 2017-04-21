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
    /**
     * Function to update a user's e-mail/password
     *
     * @return int
     *
     * author: Irfaan
     */
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

    /**
     * Function to delete a user's account permanently from the database
     *
     * author: Irfaam
     */
    public function deleteAccountPermanently() {
        try {
            // -- BEGIN Transaction
            $this->_objConnection->beginTransaction();

            # 1. Delete User's Attitudes
            $this->pDeleteAttitudes();

            # 2. Delete Wishlist of User
            $this->pDeleteWishItems();

            # 3. Delete Footprints (Images, Footprint Images table, and footprints)
            $this->pDeleteFootprints();

            # 4. Delete user details
            $this->pDeleteUserDetails();

            # 5. Delete user loggin credentials
            $this->pDeleteUserCredential();

            // -- COMMIT Transaction
            $this->_objConnection->commit();
        } catch (PDOException $e) {
            // -- ROLLBACK Transaction
            $this->_objConnection->rollback();
        }
    }

    // Private Functions Declaration
    // -----------------------------
    /**
     * Function to read user's credential details and set values to properties
     *
     * author: Irfaan
     */
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

    /**
     * Function to delete a user's attitudes
     *
     * author: Irfaan
     */
    private function pDeleteAttitudes() {
        $objAttitude = new Attitude($this->_objConnection);
        $objAttitude->deleteAllAttitudeOfUser($this->_userId);
    }

    /**
     * Function to delete a user's wish list
     *
     * author: Irfaan
     */
    private function pDeleteWishItems() {
        $objWishlist = new Wishlist($this->_objConnection, $this->_userId);
        $objWishlist->DeleteUserWishlist();
    }

    /**
     * Function to delete a user's footprints
     *
     * author: Irfaan
     */
    private function pDeleteFootprints() {
        #1. Select list of footprints to delete
        $objFootprint = new Footprints($this->_objConnection, $this->_userId);
        $lstUserFootprints = $objFootprint->GetFootprintsDetails();

        #2. Delete footprints
        foreach ($lstUserFootprints as $objUserFootprint) {
            $objTmpFootprint = new Footprints($this->_objConnection, $this->_userId);
            $objTmpFootprint->setFootprintId($objUserFootprint->footprint_id);
            $objTmpFootprint->Delete(true);
        }
    }

    /**
     * Function to delete a user's profile details
     *
     * author: Irfaan
     */
    private function pDeleteUserDetails() {
        $objUserDetails = new UserDetails($this->_objConnection, $this->_userId);
        $objUserDetails->deleteUserAccount();
    }

    /**
     * Function to delete a user's login credentials
     *
     * author: Irfaan
     */
    private function pDeleteUserCredential() {
        $sDeleteUser = "DELETE FROM user WHERE user_id = :userId";
        $objPDOStmt = $this->_objConnection->prepare($sDeleteUser);
        $objPDOStmt->bindValue(':userId', $this->_userId);
        $objPDOStmt->execute();
    }

}