<?php

namespace Models;

include_once "user.php";

class AccountModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'users'));
    }

    public function register($model){
        if($model->password != $model->confirm){
            return "Passwords don't match";
        }

        $users =  $this->find(array('columns' => 'COUNT(Id) as count', 'where' => "username='" . $model->username . "'"));
        if($users[0]['count'] != 0){
            return "Username taken";
        }

        var_dump($model);

        $hash_pass = password_hash($model->password, PASSWORD_BCRYPT);
        $money = '2000';
        $userRole = 'User';
        $isBanned = 0;
        $registerStatement =
            $this->db->prepare("INSERT INTO Users (username, password, role, money, banned) VALUES (?, ?, ?, ?, ?)");
        $registerStatement->bind_param("ssssi", $model->username, $hash_pass, $userRole, $money, $isBanned);
        $registerStatement->execute();
        return true;
    }

    public function login($model){
        $loginStatement = $this->find(array('where' => "username='" . $model->username . "'"));
        if(empty($loginStatement)){
            return "No user with username " . $model->username;
        }

        $userToLogin = $loginStatement[0];
        if(!password_verify($model->password, $userToLogin['password'])){
            return "Wrong password";
        }

        $usersModel = new UserModel();
        $user = $usersModel->getUserById(intval($userToLogin['id']));
        //var_dump($user); die();
        if($user[0]['banned'] == 1){
            return 'banned';
        }

        $_SESSION['user'] = $user;

        return true;
    }

    public function logout() {
        unset($_SESSION['user']);
    }

}