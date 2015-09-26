<?php

namespace Models;

class AccountModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'users'));
    }

    public function register($username, $password, $conf_pass){
        if($password != $conf_pass){
            return false;
        }

        $users =  $this->find(array('columns' => 'COUNT(Id) as count', 'where' => "username='" . $username . "'"));
        if($users[0]['count'] != 0){
            return false;
        }

        $hash_pass = password_hash($password, PASSWORD_BCRYPT);
        $money = '2000';
        $userRole = 'User';

        $registerStatement =
            $this->db->prepare("INSERT INTO Users (username, password, role, money) VALUES (?, ?, ?, ?)");
        $registerStatement->bind_param("ssss", $username, $hash_pass, $userRole, $money);
        $registerStatement->execute();
        return true;
    }

    public function login($username, $password){
        $loginStatement = $this->find(array('where' => "username='" . $username . "'"));
        if(empty($loginStatement)){
            return false;
        }

        $userToLogin = $loginStatement[0];
        if(!password_verify($password, $userToLogin['password'])){
            return false;
        }

        $_SESSION['username'] = $userToLogin['username'];
        $_SESSION['user_id'] = $userToLogin['id'];

        return true;
    }

    public function logout() {
        unset ($_SESSION['username']);
        unset ($_SESSION['user_id']);
    }
}