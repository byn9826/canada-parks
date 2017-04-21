<?php

class UserDetails
{
    // Constant Declaration
    // --------------------
    const sADDRESS_NOT_AVAILABLE = "Address not available";


    // Private Declarations
    // --------------------
    private $_objConnection;
    private $_userId;
    private $_firstName;
    private $_lastName;
    private $_gender;
    private $_dateOfBirth;
    private $_address;
    private $_city;
    private $_province;
    private $_nationality;
    private $_phoneNumber;
    private $_lastTrip;
    private $_nextTrip;
    private $_favouritePlaces;
    private $_joinedOn;
    private $_imageSrc;


    // Constructor
    // -----------
    public function __construct($objConnection, $userId)
    {
        $this->_objConnection = $objConnection;
        $this->_userId = $userId;
    }


    // Public Properties
    // -----------------
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        if(Fanta_Valid::isNullOrEmpty($firstName)) {
            $this->_firstName = null;
        } else {
            $this->_firstName = $firstName;
        }
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        if(Fanta_Valid::isNullOrEmpty($lastName)) {
            $this->_lastName = null;
        } else {
            $this->_lastName = $lastName;
        }
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        if(Fanta_Valid::isNullOrEmpty($gender)) {
            $this->_gender = null;
        } else {
            $this->_gender = $gender;
        }
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->_dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        if(Fanta_Valid::isNullOrEmpty($dateOfBirth)) {
            $this->_dateOfBirth = null;
        } else {
            $this->_dateOfBirth = $dateOfBirth;
        }
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        if(Fanta_Valid::isNullOrEmpty($this->_address)) {
            return self::sADDRESS_NOT_AVAILABLE;
        } else {
            return $this->_address;
        }
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        if(Fanta_Valid::isNullOrEmpty($address)) {
            $this->_address = null;
        } else {
            $this->_address = $address;
        }
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        if(Fanta_Valid::isNullOrEmpty($city)) {
            $this->_city = null;
        } else {
            $this->_city = $city;
        }
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->_province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province)
    {
        if(Fanta_Valid::isNullOrEmpty($province)) {
            $this->_province = null;
        } else {
            $this->_province = $province;
        }
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->_nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        if(Fanta_Valid::isNullOrEmpty($nationality)) {
            $this->_nationality = null;
        } else {
            $this->_nationality = $nationality;
        }
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        if(Fanta_Valid::isNullOrEmpty($phoneNumber)) {
            $this->_phoneNumber = null;
        } else {
            $this->_phoneNumber = $phoneNumber;
        }
    }

    /**
     * @return mixed
     */
    public function getLastTrip()
    {
        return $this->_lastTrip;
    }

    /**
     * @param mixed $lastTrip
     */
    public function setLastTrip($lastTrip)
    {
        if(Fanta_Valid::isNullOrEmpty($lastTrip)) {
            $this->_lastTrip = null;
        } else {
            $this->_lastTrip = $lastTrip;
        }
    }

    /**
     * @return mixed
     */
    public function getNextTrip()
    {
        return $this->_nextTrip;
    }

    /**
     * @param mixed $nextTrip
     */
    public function setNextTrip($nextTrip)
    {
        if(Fanta_Valid::isNullOrEmpty($nextTrip)) {
            $this->_nextTrip = null;
        } else {
            $this->_nextTrip = $nextTrip;
        }
    }

    /**
     * @return mixed
     */
    public function getFavouritePlaces()
    {
        return $this->_favouritePlaces;
    }

    /**
     * @param mixed $favouritePlaces
     */
    public function setFavouritePlaces($favouritePlaces)
    {
        if(Fanta_Valid::isNullOrEmpty($favouritePlaces)) {
            $this->_favouritePlaces = null;
        } else {
            $this->_favouritePlaces = $favouritePlaces;
        }
    }

    /**
     * @return mixed
     */
    public function getJoinedOn()
    {
        $dJoinedDate = strtotime($this->_joinedOn);
        return 'Joined on ' . date('M d, Y', $dJoinedDate);
    }

    /**
     * @return mixed
     */
    public function getImageSrc()
    {
        return $this->_imageSrc;
    }

    /**
     * @param mixed $imageSrc
     */
    public function setImageSrc($imageSrc)
    {
        $this->_imageSrc = $imageSrc;
    }


    // Public Functions Declaration
    // ----------------------------
    /**
     * Function to read a user's profile details and fill object's property values
     *
     * @return int
     *
     * author: Irfaan
     */
    public function Read() {
        $iRowRetrieved = 0;

        try {
            // Query database to fetch user's details
            $sQueryReadDetails = "
                                        SELECT user_details.*
                                          FROM user_details
                                         WHERE user_details.user_id = :user_id;
                                 ";
            $objPDOStmt = $this->_objConnection->prepare($sQueryReadDetails);
            $objPDOStmt->bindValue(':user_id', $this->_userId);
            $iRowRetrieved = $objPDOStmt->execute();
            $userDetails = $objPDOStmt->fetch(PDO::FETCH_OBJ);

            // Fill in the property values
            $this->_firstName = $userDetails->first_name;
            $this->_lastName = $userDetails->last_name;
            $this->_gender = $userDetails->gender;
            $this->_dateOfBirth = $userDetails->date_of_birth;
            $this->_address = $userDetails->address;
            $this->_city = $userDetails->city;
            $this->_province = $userDetails->province;
            $this->_nationality = $userDetails->nationality;
            $this->_phoneNumber = $userDetails->phone_number;
            $this->_lastTrip = $userDetails->last_trip;
            $this->_nextTrip = $userDetails->next_trip;
            $this->_favouritePlaces = $userDetails->favourite_places;
            $this->_joinedOn = $userDetails->joined_on;
            $this->_imageSrc = $userDetails->image_src;

        } catch(Exception $e) {
            // Unable to fetch user details
        }

        return $iRowRetrieved;
    }

    /**
     * Function to update a user's profile details
     *
     * @return int
     *
     * author: Irfaan
     */
    public function Update() {
        $iRowUpdated = 0;
        $dateArray = null;
        $sqlDate = null;

        try {
            // Format date to SQL format
            $dateArray = explode('/', $this->_dateOfBirth);
            if(count($dateArray) === 3) {
                $sqlDate = $dateArray[2].'-'.$dateArray[0].'-'.$dateArray[1];
            } else {
                $sqlDate = $this->_dateOfBirth;
            }

            $sQueryUpdateDetails = "
                                        UPDATE user_details
                                           SET first_name       = :fname
                                             , last_name        = :lname
                                             , gender           = :gender
                                             , date_of_birth    = :dob
                                             , address          = :address
                                             , city             = :city
                                             , province         = :province
                                             , nationality      = :nationality
                                             , phone_number     = :phonenum
                                             , last_trip        = :ltrip
                                             , next_trip        = :ntrip
                                             , favourite_places = :favplaces
                                         WHERE user_id          = :userid
                                   ";
            $objPDOStmt = $this->_objConnection->prepare($sQueryUpdateDetails);
            $objPDOStmt->bindValue(':fname', $this->_firstName);
            $objPDOStmt->bindValue(':lname', $this->_lastName);
            $objPDOStmt->bindValue(':gender', $this->_gender);
            $objPDOStmt->bindValue(':dob', $sqlDate);
            $objPDOStmt->bindValue(':address', ($this->_address == self::sADDRESS_NOT_AVAILABLE)? null : $this->_address);
            $objPDOStmt->bindValue(':city', $this->_city);
            $objPDOStmt->bindValue(':province', $this->_province);
            $objPDOStmt->bindValue(':nationality', $this->_nationality);
            $objPDOStmt->bindValue(':phonenum', $this->_phoneNumber);
            $objPDOStmt->bindValue(':ltrip', $this->_lastTrip);
            $objPDOStmt->bindValue(':ntrip', $this->_nextTrip);
            $objPDOStmt->bindValue(':favplaces', $this->_favouritePlaces);
            $objPDOStmt->bindValue(':userid', $this->_userId);

            $iRowUpdated = $objPDOStmt->execute();

        } catch(Exception $e) {
            // Unable to update details
        }

        return $iRowUpdated;
    }

    /**
     * Function that returns the correct profile picture URL
     *
     * @return string
     *
     * author: Irfaan
     */
    public function getProfilePictureURL() {
        //if img src is from google+
        if (substr($this->_imageSrc, 0, 4) == 'http') {
            return $this->_imageSrc;
        }
        //if img is from local folder
        else {
            return "../static/img/profile/users/" . $this->_imageSrc;
        }
    }

    /**
     * Function that returns the full name of the user
     *
     * @return string
     *
     * author: Irfaan
     */
    public function getFullName() {
        return ucwords($this->getFirstName() . ' ' . $this->getLastName());
    }

    /**
     * Function that deletes the user's account details
     *
     * author: Irfaan
     */
    public function deleteUserAccount() {
        $sDeleteQuery = "DELETE FROM user_details WHERE user_id = :userId";
        $objPDOStmt = $this->_objConnection->prepare($sDeleteQuery);
        $objPDOStmt->bindValue(':userId', $this->_userId, PDO::PARAM_INT);
        $objPDOStmt->execute();
    }

}
