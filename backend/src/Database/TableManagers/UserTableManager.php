<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use http\Params;
use Models\User;

class UserTableManager extends TableManager
{

    //--------get methods----------------
    // general get method
    /**
     * Get users from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return User[]
     */
    static public function getUser(array $params=[]): array
    {

        $queryObjects = DatabaseQuery::executeQuery("select","users",[],$params);
        $users = [];
        foreach ($queryObjects as $queryObject ) {
            $users[] = new User($queryObject['id'],
                                $queryObject['username'],
                                $queryObject['password'],
                                $queryObject['email'],
                                $queryObject['reg_date'],
                                $queryObject['role']);
        }
        return $users;

    }


    // specific get methods

    /**
     * Get user from database based on id
     * @param int $id
     * @return User|null
     */
    static public function getUserById(int $id): ?User
    {
        $users = self::getUser(["id" => $id]);
        if(!empty($users)){
            return $users[0];
        }
        return null;
    }

    /**
     * Get user from database based on username given as parameter
     * @param string $email
     * @return User|null
     */
    static public function getUserByEmail(string $email): ?User
    {
        $users = self::getUser(["email" => $email]);
        if(!empty($users)){
            return $users[0];
        }

        return null;

    }

    /**
     * Get user from database based on username given as parameter
     * @param string $username
     * @return User|null
     */
    static public function getUserByUsername(string $username): ?User
    {
        $users = self::getUser(["username" => $username]);
        if(!empty($users)){
            return $users[0];
        }

        return null;

    }

    /**
     * Get users from database based on role given as parameter
     * @param string $role
     * @return User[]
     */
    static public function getUserByRole(string $role): array
    {
        $users = self::getUser(["role" => $role]);
        if(!empty($users)){
            return $users;
        }
        return [];
    }

    /**
     * Get users from database based on registration date given as parameter in the format 'YYYY-MM-DD HH:MM:SS'
     * @param string $reg_date
     * @return User[]
     */
    static public function getUserByRegDate(string $reg_date): array
    {
        $users = self::getUser(["reg_date" => $reg_date]);
        if(!empty($users)){
            return $users;
        }
        return [];
    }


    //--------verify existence methods----------------

    /**
     * Verify if user exists in database based on username given as parameter
     * @param string $username
     * @return bool
     */
    static public function verifyExistenceByUserName(string $username): bool
    {
        return ( !empty(self::getUserByUsername($username)) );
    }

    /**
     * Verify if user exists in database based on email given as parameter
     * @param string $email
     * @return bool
     */
    static public function verifyExistenceByEmail(string $email): bool
    {
        return ( !empty(self::getUserByEmail($email)) );
    }

    /**
     * Verify if user exists in database based on id given as parameter
     * @param int $id
     * @return bool
     */
    static public function verifyExistenceById(int $id): bool
    {
        return ( !empty(self::getUserById($id)) );
    }

    //--------add method----------------
    /**
     * Add user to database based on username, email and password given as parameters and return the user object
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User|null
     */
    static public function AddUser(string $username, string $email,string $password): ?User //to database
    {
        if( self::verifyExistenceByUserName($username) || self::verifyExistenceByEmail($email) ){
            return null;
        }
        DatabaseQuery::executeQuery("insert","users",["username"=>$username,"email"=>$email,"password"=>$password,"role"=>"user"]);
        $user = DatabaseQuery::executeQuery("select","users",[],
                                            ["username"=>$username,"email"=>$email,"password"=>$password]);
        $id = $user[0]["id"];
        $reg_date = $user[0]["reg_date"];
        $role = $user[0]["role"];
        return new User($id,$username,$password,$email,$reg_date,$role);

    }


    //--------update methods----------------
    // general update method
    /**
     * Update user in database based on parameters given in $params and conditions given in $conditions
     * @param array $params
     * @param array $conditions
     */
    static public function updateUser(array $params=[], array $conditions=[]){
        if(! empty($params) && ! empty($conditions) )
            DatabaseQuery::executeQuery("update","users",$params,$conditions);
    }

    // specific update methods
    static public function updateRole($id,$role){
        self::updateUser(["role" => $role], ["id" => $id]);
    }

    static public function updatePassword($id,$password){
        self::updateUser(["password" => $password], ["id" => $id]);
    }

    static public function updateUsername($id,$username){
        self::updateUser(["username" => $username], ["id" => $id]);
    }

    static public function updateEmail($id,$email){
        self::updateUser(["email" => $email], ["id" => $id]);
    }


    //--------delete methods----------------
    // general delete method
    /**
     * Delete user from database based on parameters given in $params
     * @param array $params
     */
    static public function deleteUser(array $params=[]){
        if (!empty($params))
            DatabaseQuery::executeQuery("delete","users",[],$params);
    }

    // specific delete methods
    static public function deleteUserById($id){
        self::deleteUser(["id"=>$id]);
    }

    static public function deleteUserByUsername($username){
        self::deleteUser(["username"=>$username]);
    }

    static public function deleteUserByEmail($email){
        self::deleteUser(["email"=>$email]);
    }

    static public function deleteUserByRole($role){
        self::deleteUser(["role"=>$role]);
    }

    static public function deleteUserByRegDate($reg_date){
        self::deleteUser(["reg_date"=>$reg_date]);
    }

    //--------save/retrieve method----------------
    public function retrieve($id): ?User
    {
        return self::getUserById($id);
    }

    public function save($model) //todo: to move if not used
    {
        echo "UserTableManager save method called";
    }

}
