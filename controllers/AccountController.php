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

        if(parent::isPost() == true){
            $registerModelBind = $this->bind(new RegisterBindingModel());

            $registerResponse = $this->model->register($registerModelBind);

            if(is_bool($registerResponse) && $registerResponse == true){
                $this->model->login($registerModelBind);
                $this->addInfoMessage($registerModelBind->username . ", successfully registered");
                $this->redirect("users", "view", array($_SESSION['user_id']));
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

        if(parent::isPost() == true){
            $loginModelBind = $this->bind(new LoginBindingModel());

            $loggingResponse = $this->model->login($loginModelBind);

            if(is_bool($loggingResponse) && $loggingResponse == true){
                $this->addInfoMessage($loginModelBind->username . " successfully logged in");
                $this->redirect("users", "view", array($_SESSION['user_id']));
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