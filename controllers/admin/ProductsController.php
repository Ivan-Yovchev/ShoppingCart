<?php

namespace Admin\Controllers;

include_once DX_ROOT_DIR . "controllers/editor/ProductsController.php";
include_once DX_ROOT_DIR . "controllers/ProductsController.php";
include_once DX_ROOT_DIR . "controllers/CategoriesController.php";
include_once DX_ROOT_DIR . "models/promotionproducts.php";

class ProductsController extends \Editor\Controllers\ProductsController {
    public function __construct(
        $class_name = '\Controllers\Admin\ProductsController',
        $model = 'product',
        $views_dir = 'views\\admin\\product\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index($category){
        $this->authorizeAdmin();
        parent::index($category);
    }

    public function show($productCategory, $searchTerm = ""){
        $this->authorizeAdmin();
        parent::show($productCategory, $searchTerm);
    }

    public function remove($productName){
        $this->authorizeAdmin();
        parent::remove($productName);
    }

    public function view($productName){
        $this->authorizeEditor();
        parent::view($productName);
    }

    public function add(){
        $this->authorizeAdmin();
        parent::add();
    }

    public function move($productName){
        $this->authorizeAdmin();
        parent::move($productName);
    }

    public function change($productName){
        $this->authorizeAdmin();
        parent::change($productName);
    }
}