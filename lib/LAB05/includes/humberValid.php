<?php
class HumberValid {
    private $email;
    private $gender;
    private $phone;
    public function setEmail($email) {
        $this->email = $email;
    }
    public function validEmail() {
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    public function setGender($gender) {
        $this->gender = $gender;
    }
    public function validGender() {
        if(strcasecmp($this->gender, "male") == 0 || strcasecmp($this->gender, "female") == 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function setPhone($phone) {
        $this->phone = $phone;
    }
    
    public function validPhone() {
        if (preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $this->phone)) {
            return true;
        } else {
            return false;
        }
    }
}
