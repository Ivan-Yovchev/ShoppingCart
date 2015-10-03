<?php

namespace Controllers;


class CategoriesController extends MasterController{
    public function __construct(
        $class_name = '\Controllers\CategoriesController',
        $model = 'category',
        $views_dir = 'views\\categories\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index(){
        $this->authorizeUser();
        $this->categories = $this->getCategories();
        $this->renderView('index.php');
    }

    public function getCategories(){
        $this->authorizeUser();
        return $this->model->find();
    }

    public function getCategoryByName($name){
        $this->authorizeUser();
        return $this->model->getCategoryByName($name);
    }

    public function getCategoryById($id){
        $this->authorizeUser();
        $id = intval($id);
        return $this->model->getCategoryById($id);
    }
}