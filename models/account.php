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
        $registerStatement =
            $this->db->prepare("INSERT INTO Users (username, password, role, money) VALUES (?, ?, ?, ?)");
        $registerStatement->bind_param("ssss", $model->username, $hash_pass, $userRole, $money);
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
        $_SESSION['user'] = $user;
//        $_SESSION['username'] = $userToLogin['username'];
//        $_SESSION['user_id'] = $userToLogin['id'];
//        $_SESSION['money'] = $userToLogin['money'];

        return true;
    }

    public function logout() {
//        unset ($_SESSION['username']);
//        unset ($_SESSION['user_id']);
        unset($_SESSION['user']);
    }

}