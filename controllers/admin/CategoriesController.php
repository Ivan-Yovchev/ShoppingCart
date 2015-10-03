<?php

namespace Admin\Controllers;

include_once DX_ROOT_DIR . "controllers/editor/CategoriesController.php";
include_once DX_ROOT_DIR . "controllers/CategoriesController.php";
include_once DX_ROOT_DIR . "models/product.php";

class CategoriesController extends \Editor\Controllers\CategoriesController {
    public function __construct(
        $class_name = '\Controllers\Admin\CategoriesController',
        $model = 'category',
        $views_dir = 'views\\admin\\categories\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index(){
        $this->authorizeAdmin();
        parent::index();
    }

    public function remove($categoryName){
        $this->authorizeAdmin();
        parent::remove($categoryName);
    }

    public function add(){
        $this->authorizeAdmin();
        parent::add();
    }
}