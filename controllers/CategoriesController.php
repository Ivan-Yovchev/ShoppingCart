<?php

namespace Controllers;


class CategoriesController extends MasterController{
    public function __construct(){
        parent::__construct(get_class(), 'category', '\\views\\categories\\');
    }

    public function index(){
        $this->authorizeUser();
        $this->categories = $this->model->find();
        $this->renderView('index.php');
    }
}