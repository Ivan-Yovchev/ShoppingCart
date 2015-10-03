<?php

namespace Editor\Controllers;

use BindingModels\AddProductBindingModel;
use BindingModels\ChangeQuantityBindingModel;
use BindingModels\DeleteProductBindingModel;
use BindingModels\MoveProductBindingModel;

include_once DX_ROOT_DIR . "controllers/ProductsController.php";
include_once DX_ROOT_DIR . "controllers/CategoriesController.php";
include_once DX_ROOT_DIR . "models/promotionproducts.php";

class ProductsController extends \Controllers\ProductsController {
    public function __construct(
        $class_name = '\Controllers\Editor\ProductsController',
        $model = 'product',
        $views_dir = 'views\\editor\\product\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index($category){$this->authorizeEditor();
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

        $promotionProductsModel = new \Models\PromotionproductsModel();

        if($productCategory == "all"){
            $this->products = $this->model->find(array('where' => "LOWER(Name) like '%" . $searchTerm . "%' AND Quantity > 0"));
        } else {
            $category = $controller->getCategoryByName($productCategory);
            $categoryId = intval($category[0]['id']);
            $this->products = $this->model->find(array('where' => "CategoryId=" . $categoryId . " and LOWER(Name) like '%" . $searchTerm . "%'  AND Quantity > 0"));
        }

        for($i = 0; $i < count($this->products); $i++){
            $promotions = $promotionProductsModel->checkForPromotions($this->products[$i]['id']);
            $isPromoted = false;
            foreach($promotions as $promotion){
                if($promotionProductsModel->verifyPromotion($promotion['Promotions_id']) == 1){
                    $isPromoted = true;
                    break;
                }
            }
            $this->products[$i]['promoted'] = $isPromoted;
        }

        if($this->hasLoggedUser() && ($this->getLoggedUser()['role'] == "Editor" || $this->getLoggedUser()['role'] == "Admin")){
            $this->renderView('products.php', true);
        }
    }

    public function remove($productName){
        $this->authorizeEditor();

        $productName = urldecode($productName);

        $productController = new \Controllers\ProductsController();
        $categoryController = new \Controllers\CategoriesController();
        $this->product = $productController->getProductByName($productName)[0];
        $this->category = $categoryController->getCategoryById($this->product['CategoryId'])[0];

        if(parent::isPost()){
            $model = $this->bind(new DeleteProductBindingModel());
            $result = $this->model->removeProductById($model);
            if($result == 1){
                $this->addInfoMessage('Successfully removed product');

                if($this->getLoggedUser()['role'] == 'Editor'){
                    $this->redirect("products", "index", array('all'), "editor");
                } else if($this->getLoggedUser()['role'] == 'Admin'){
                    $this->redirect("products", "index", array('all'), "admin");
                }

            } else {
                $this->addErrorMessage("An error occurred please try again");

                if($this->getLoggedUser()['role'] == 'Editor'){
                    $this->redirect("products", "index", array('all'), "editor");
                } else if($this->getLoggedUser()['role'] == 'Admin'){
                    $this->redirect("products", "index", array('all'), "admin");
                }

            }
        }
        $this->renderView('removeProduct.php');
    }

    public function view($productName){
        $this->authorizeEditor();
        parent::view($productName);
    }

    public function add(){
        $this->authorizeEditor();

        if(parent::isPost()){
            $bindModel = $this->bind(new AddProductBindingModel());
            $response = $this->model->addProduct($bindModel);
            if($response == 1){
                $this->addInfoMessage($bindModel->productName . " successfully added");
            } else {
                $this->addErrorMessage($response);
            }
//            var_dump($response); die();

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("products", "index", array('all'), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("products", "index", array('all'), "admin");
            }

        }

        $controller = new \Controllers\CategoriesController();
        $this->categories = $controller->getCategories();

        $this->renderView('newProduct.php');
    }

    public function move($productName){
        $this->authorizeEditor();

        $productName = urldecode($productName);

        $categoriesController = new \Controllers\CategoriesController();

        $this->product = $this->getProductByName($productName)[0];
        $this->category = $categoriesController->getCategoryById($this->product['CategoryId'])[0];
        $this->categories = $categoriesController->getCategories();

        if(parent::isPost()){
            $model = $this->bind(new MoveProductBindingModel());
            $response = $this->model->move($model);
            if($response == 1){
                $this->addInfoMessage("Successfully moved product");
            } else if(is_bool($response)) {
                $this->addErrorMessage("An error occurred please try again");
            } else {
                $this->addErrorMessage($response);
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("products", "index", array('all'), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("products", "index", array('all'), "admin");
            }

        }

        $this->renderView("moveProduct.php");
    }

    public function change($productName){
        $productName = urldecode($productName);
        $this->product = $this->getProductByName($productName)[0];

        if(parent::isPost()){
            $model = $this->bind(new ChangeQuantityBindingModel());
            $response = $this->model->changeQuantity($model);
            if($response == 1){
                $this->addInfoMessage("Successfully changed quantity");
            } else {
                $this->addErrorMessage("An error occurred please try again");
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("products", "index", array('all'), 'editor');
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("products", "index", array('all'), 'admin');
            }

        }

        $this->renderView("changeQuantity.php");
    }
}