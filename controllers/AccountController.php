<?php

namespace Controllers;


class AccountController extends MasterController{
    public function __construct(){
        parent::__construct(get_class(), 'account', '\\views\\account\\');
    }

    public function register(){
        if(parent::isPost() == true){
            $username = $_POST['username'];
            $password = $_POST['pass'];
            $confirmPassword = $_POST['pass_confirm'];

            $isRegistered = $this->model->register($username, $password, $confirmPassword);

            if($isRegistered){
                $this->model->login($username, $password);
                $this->redirect("users", "view", array($_SESSION['user_id']));
            } else {
                $this->redirect("account", "register");
            }
        }

        $this->renderView('register.php');
    }

    public function login(){
        if(parent::isPost() == true){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $isLogged = $this->model->login($username, $password);

            if($isLogged){
                $this->redirect("users", "view", array($_SESSION['user_id']));
            } else {
                $this->redirect("account", "login");
            }
        }

        $this->renderView('login.php');
    }

    public function logout(){
        $this->model->logout();
        $this->auth->clean_auth();
        $this->redirect("master", "index");
    }
}