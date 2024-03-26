<?php
class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $registrationDate;
    private $isAdmin;

    public function __construct($id, $username, $password, $email, $registrationDate, $isAdmin) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->registrationDate = $registrationDate;
        $this->isAdmin = $isAdmin;
    }
    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
    public function getId() {
        return $this->id;
    }

    public function setUserId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getRegistrationDate() {
        return $this->registrationDate;
    }

    public function setRegistrationDate($registrationDate) {
        $this->registrationDate = $registrationDate;
    }
}