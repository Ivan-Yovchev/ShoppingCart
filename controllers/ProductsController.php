<?php

namespace Controllers;

use BindingModels\AddToCartBindingModel;

include_once "CategoriesController.php";
include_once DX_ROOT_DIR . "models/promotionproducts.php";

class ProductsController extends MasterController{

    public function __construct(
        $class_name = '\Controllers\ProductsController',
        $model = 'product',
        $views_dir = 'views\\product\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index($category){
        $this->authorizeUser();
        if($category != null) {
            $this->selected = $category;
        }

        $controller = new CategoriesController();
        $this->categories = $controller->getCategories();

        $this->renderView('index.php');
    }

    public function show($productCategory, $searchTerm = ""){
        $this->authorizeUser();

        $controller = new CategoriesController();
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

        if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"){
            $this->renderView('products.php', true);
        }
    }

    public function view($productName){
        $this->authorizeUser();

        $productName = urldecode($productName);
        $product = $this->getProductByName($productName);
        $controller = new CategoriesController();
        $category = $controller->getCategoryById($product[0]['CategoryId']);
        $this->product = $product[0];
        $this->category = $category[0];

        $productPromotionsModel = new \Models\PromotionproductsModel();
        $this->promotion = $productPromotionsModel->getBiggestPromotion($product[0]['id']);

        if(parent::isPost()){
            $model = $this->bind(new AddToCartBindingModel());
            $response = $this->model->addToCart($model);
            if(is_bool($response) && $response == true){
                $this->addInfoMessage($product[0]['Name'] . " added to cart");
                if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"){
                    $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))));
                } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"){
                    $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))), "editor");
                } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Admin"){
                    $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))), "admin");
                }
            } else {
                $this->addErrorMessage($response);
                if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"){
                    $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))));
                } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"){
                    $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))), "editor");
                } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Admin"){
                    $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))), "admin");
                }
            }
        }

        $this->renderView('product.php');
    }

    public function removeFromCart($index){
        $this->authorizeUser();
        if(empty($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        if(isset($_SESSION['cart'][$index])){
            $productName = $_SESSION['cart'][$index]['product']['Name'];
            array_splice($_SESSION['cart'], $index, 1);
            $this->addInfoMessage($productName . " successfully removed from cart");
            if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"){
                $this->redirect("users", "cart");
            } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"){
                $this->redirect("users", "cart", array(), "editor");
            } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Admin"){
                $this->redirect("users", "cart", array(), "admin");
            }

        } else {
            $this->addErrorMessage("No instance of cart product with index: " . $index);
            $this->redirect("users", "cart");
        }
    }

    public function getProductByName($productName){
        return $this->model->getProductByName($productName);
    }
}