<?php

namespace Editor\Controllers;

use BindingModels\AddCategoryBindingModel;
use BindingModels\DeleteCategoryBindingModel;

include_once DX_ROOT_DIR . "controllers/CategoriesController.php";
include_once DX_ROOT_DIR . "models/product.php";

class CategoriesController extends \Controllers\CategoriesController {
    public function __construct(
        $class_name = '\Controllers\Editor\CategoriesController',
        $model = 'category',
        $views_dir = 'views\\editor\\categories\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index(){
        $this->authorizeEditor();
        $this->categories = $this->getCategories();
        $this->renderView('index.php');
    }

    public function remove($categoryName){
        $this->authorizeEditor();

        $productsModel = new \Models\ProductModel();
        $categoryName = urldecode($categoryName);
        $this->category = $this->getCategoryByName($categoryName)[0];
        $this->category['count'] = count($productsModel->getCategoryProducts($this->category['id']));
        if(parent::isPost()){
            $model = $this->bind(new DeleteCategoryBindingModel());
            $response = $this->model->deleteCategory($model);
            if($response == 1){
                $this->addInfoMessage("Successfully deleted category");
            } else {
                $this->addErrorMessage("An error occurred please try again");
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("categories", "index", array(), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("categories", "index", array(), "admin");
            }
        }

        $this->renderView('deleteCategory.php');
    }

    public function add(){
        $this->authorizeEditor();

        if(parent::isPost()){
            $model = $this->bind(new AddCategoryBindingModel());
            $response = $this->model->addCategory($model);
            if($response == 1){
                $this->addInfoMessage($model->categoryName . " category created");
            } else {
                $this->addErrorMessage("And error occurred please try again");
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("categories", "index", array(), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("categories", "index", array(), "admin");
            }
        }

        $this->renderView("addCategory.php");
    }
}