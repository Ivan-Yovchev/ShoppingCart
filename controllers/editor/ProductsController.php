<?php

namespace Editor\Controllers;

use BindingModels\AddProductBindingModel;

include_once DX_ROOT_DIR . "controllers/ProductsController.php";
include_once DX_ROOT_DIR . "controllers/CategoriesController.php";

class ProductsController extends \Controllers\ProductsController {
    public function __construct(
        $class_name = '\Controllers\Editor\ProductsController',
        $model = 'product',
        $views_dir = 'views\\editor\\product\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index($category){
        if(parent::isPost()){
            $bindModel = $this->bind(new AddProductBindingModel());
            $response = $this->model->addProduct($bindModel);
            if($response == 1){
                $this->addInfoMessage($bindModel->productName . " successfully added");
            } else {
                $this->addErrorMessage($response);
            }
//            var_dump($response); die();
            $this->redirect("products", "index", array('all'), "editor");
        }

        $this->authorizeEditor();
        if($category != null) {
            $this->selected = $category;
        }

        $controller = new \Controllers\CategoriesController();
        $this->categories = $controller->getCategories();

        $this->renderView('index.php');
    }

    public function show($productCategory, $searchTerm = ""){
        $this->authorizeEditor();

        $controller = new \Controllers\CategoriesController();
        $productCategory = urldecode($productCategory);

        if($productCategory == "all"){
            $this->products = $this->model->find(array('where' => "LOWER(Name) like '%" . $searchTerm . "%' AND Quantity > 0"));
//            var_dump($this->products);
        } else {
            $category = $controller->getCategoryByName($productCategory);
            $categoryId = intval($category[0]['id']);
            $this->products = $this->model->find(array('where' => "CategoryId=" . $categoryId . " and LOWER(Name) like '%" . $searchTerm . "%'  AND Quantity > 0"));
        }

        if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"){
            $this->renderView('products.php', true);
        }
    }

    public function remove($productName){
        $this->authorizeEditor();
        $productName = urldecode($productName);
        $result = $this->model->removeProductByName($productName);
        if($result == 1){
            $this->addInfoMessage($productName . ' successfully removed');
            $this->redirect("products", "index", array('all'), "editor");
        } else {
            $this->addErrorMessage("An error occurred please try again");
            $this->redirect("products", "index", array('all'), "editor");
        }
    }

    public function view($productName){
        $this->authorizeEditor();
        parent::view($productName);
    }
}