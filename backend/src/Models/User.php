<?php
namespace Models;
class User extends Model{
    private $username;
    private $password;
    private $email;
    private $reg_dat;
    private $role;
    private $is_verified;
    private $profile_pic;

    public function __construct($id, $username, $password, $email, $reg_dat, $role, $is_verified, $profile_pic) {
        parent::__construct($id);
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->reg_dat = $reg_dat;
        $this->role = $role;
        $this->is_verified = $is_verified;
        $this->profile_pic = $profile_pic;
    }

    public function getProfilePic() {
        return $this->profile_pic;
    }
    public function getIsVerified() {
        return $this->is_verified;
    }

    public function getRole() {
        return $this->role;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }


    public function getEmail() {
        return $this->email;
    }


    public function getRegistrationDate() {
        return $this->reg_dat;
    }



    public function jsonSerialize()
    {
        return [
            'id' => parent::getId(),
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'reg_dat' => $this->reg_dat,
            'role' => $this->role,
            'is_verified' => $this->is_verified,
            'profile_pic' => $this->profile_pic
        ];
    }
}