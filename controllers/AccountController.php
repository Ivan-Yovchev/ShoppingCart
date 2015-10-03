<?php

namespace Controllers;
use BindingModels\LoginBindingModel;
use BindingModels\RegisterBindingModel;

class AccountController extends MasterController{
    public function __construct(){
        parent::__construct(get_class(), 'account', '\\views\\account\\');
    }

    public function register(){
        if($this->hasLoggedUser()){
            $this->logout(true);
            $this->redirect("account", "register");
        }

        if(!isset($_POST['token'])){
            $_SESSION['token'] = hash('sha256', microtime());
        }

        if(parent::isPost() == true){

            if($_POST['token'] != $_SESSION['token']){
                exit;
            }

            $registerModelBind = $this->bind(new RegisterBindingModel());

            $registerResponse = $this->model->register($registerModelBind);
            if(is_bool($registerResponse) && $registerResponse == true){
                $this->model->login($registerModelBind);
                $this->addInfoMessage($registerModelBind->username . ", successfully registered");
                if($_SESSION['user'][0]['role'] == 'Admin'){
                    $this->redirect("users", "view", array($_SESSION['user'][0]['username']), 'admin');
                } else if($_SESSION['user'][0]['role'] == 'Editor'){
                    $this->redirect("users", "view", array($_SESSION['user'][0]['username']), 'editor');
                } else {
                    $this->redirect("users", "view", array($_SESSION['user'][0]['username']));
                }
            } else {
                $this->addErrorMessage($registerResponse);
                $this->redirect("account", "register");
            }
        }

        $this->renderView('register.php');
    }

    public function login(){
        if($this->hasLoggedUser()){
            $this->logout(true);
            $this->redirect("account", "login");
        }

        if(!isset($_POST['token'])){
            $_SESSION['token'] = hash('sha256', microtime());
        }

        if(parent::isPost() == true){
            if($_POST['token'] != $_SESSION['token']){
                exit;
            }

            $loginModelBind = $this->bind(new LoginBindingModel());

            $loggingResponse = $this->model->login($loginModelBind);

            if(is_bool($loggingResponse) && $loggingResponse == true){
                $this->addInfoMessage($loginModelBind->username . " successfully logged in");
                if($_SESSION['user'][0]['role'] == 'Admin'){
                    $this->redirect("users", "view", array($_SESSION['user'][0]['username']), 'admin');
                } else if($_SESSION['user'][0]['role'] == 'Editor'){
                    $this->redirect("users", "view", array($_SESSION['user'][0]['username']), 'editor');
                } else {
                    $this->redirect("users", "view", array($_SESSION['user'][0]['username']));
                }
            } else {
                $this->addErrorMessage($loggingResponse);
                $this->redirect("account", "login");
            }
        }

        $this->renderView('login.php');
    }

    public function logout($rederect = false){
        $this->authorizeUser();
        $this->model->logout();
        $this->auth->clean_auth();

        if($rederect == false) {
            $this->redirect("master", "index");
        }
    }
}