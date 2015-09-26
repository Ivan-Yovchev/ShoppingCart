<?php

namespace Controllers;


class UsersController extends MasterController{
    public function __construct(){
        parent::__construct(get_class(), 'user', '\\views\\user\\');
    }

    public function index(){
        $this->users = $this->model->find();
        $this->renderView('index.php');
    }

    public function view($id){
        $this->users = $this->model->get($id);
        $this->renderView('index.php');
    }
}