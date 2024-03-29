<?php
namespace Models;
class User extends Model{
    private $username;
    private $password;
    private $email;
    private $registrationDate;
    private $role;

    public function __construct($id, $username, $password, $email, $registrationDate, $role) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->registrationDate = $registrationDate;
        $this->role = $role;
    }
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
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


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'registrationDate' => $this->registrationDate,
            'role' => $this->role
        ];
    }
}