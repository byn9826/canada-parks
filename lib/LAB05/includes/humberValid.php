<?php
class HumberValid {
    private $email;
    private $gender;
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


}
