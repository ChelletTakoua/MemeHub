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
    /**
     * Create a new instance of User
     * @param int $id
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $reg_dat
     * @param string $role
     * @param string $is_verified
     * @param string $profile_pic
     */
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
    /**
     * get the profile picture of the user
     * @return string
     */

    public function getProfilePic() {
        return $this->profile_pic;
    }
    /**
     * get the verification status of the user
     * @return string
     */
    public function getIsVerified() {
        return $this->is_verified;
    }

    /**
     * get the role of the user
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * get the username of the user
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * get the password of the user
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }


    /**
     * get the email of the user
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }


    /**
     * get the registration date of the user
     * @return string
     */
    public function getRegistrationDate() {
        return $this->reg_dat;
    }


    /**
     * encode the User instance as json
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => parent::getId(),
            'username' => $this->username,
            'email' => $this->email,
            'reg_dat' => $this->reg_dat,
            'role' => $this->role,
            'is_verified' => $this->is_verified,
            'profile_pic' => $this->profile_pic
        ];
    }
}