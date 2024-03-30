<?php
namespace Models;
class User extends Model{
    private $username;
    private $password;
    private $email;
    private $reg_dat;
    private $role;

    public function __construct($id, $username, $password, $email, $reg_dat, $role) {
        parent::__construct($id);
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->reg_dat = $reg_dat;
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
        return $this->reg_dat;
    }

    public function setRegistrationDate($reg_dat) {
        $this->reg_dat = $reg_dat;
    }


    public function jsonSerialize()
    {
        return [
            'id' => parent::getId(),
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'reg_dat' => $this->reg_dat,
            'role' => $this->role
        ];
    }
}