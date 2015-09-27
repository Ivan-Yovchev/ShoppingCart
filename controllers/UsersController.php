<?php

namespace Controllers;


class UsersController extends MasterController{
    public function __construct(){
        parent::__construct(get_class(), 'user', '\\views\\user\\');
    }

    public function index(){
        $this->authorizeUser();
        $this->users = $this->model->find();
        $this->renderView('index.php');
    }

    public function view($username){
        $this->authorizeUser();

        $currentUserUsername = $_SESSION['username'];

        if(empty($username)){
            $username = $currentUserUsername;
        } else if($username != $currentUserUsername){
            $this->redirect("users", "view", array($currentUserUsername));
        }

        $this->users = $this->model->get($username);
        $this->renderView('index.php');
    }
}