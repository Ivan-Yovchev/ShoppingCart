<?php

namespace Controllers;

use BindingModels\SellProductBindingModel;

include_once "UserproductsController.php";
include_once "ProductsController.php";
include_once "CategoriesController.php";

class UsersController extends MasterController{
    public function __construct(
        $class_name = '\Controllers\UsersController',
        $model = 'user',
        $views_dir = 'views\\user\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function index(){
        $this->authorizeUser();
        $this->users = $this->model->find();
        $this->renderView('index.php');
    }

    public function view($username){
        $this->authorizeUser();

        if(parent::isPost()){
            $sellProductModel = $this->bind(new SellProductBindingModel());
            $response = $this->model->sellItem($sellProductModel);

            if($response == 1){
                $this->addInfoMessage("Successfully sold");
            } else if($response == 0){
                $this->addErrorMessage("An error has occurred. Please try again");
            } else {
                $this->addErrorMessage($response);
            }
        }

        $currentUserUsername = $this->getLoggedUser()['username'];
        $currentUserId = $this->getLoggedUser()['id'];

        $userProductsController = new UserproductsController();
        $userProducts = $userProductsController->model->getUserProducts($currentUserId);

        $productsController = new ProductsController();
        $categoriesController = new CategoriesController();

        for($i = 0; $i < count($userProducts); $i++){
            $productId = $userProducts[$i]['ProductId'];
            $userProduct = $productsController->model->getUserProduct($productId)[0];
            $userProducts[$i]["product"] = $userProduct;

            $categoryId = $userProduct["CategoryId"];
            $category = $categoriesController->model->getCategoryById($categoryId)[0];
            $userProducts[$i]['category'] = $category;
        }

//        foreach($userProducts as $product){
//            var_dump($product);
//        }

        if(empty($username)){
            $username = $currentUserUsername;
        } else if($username != $currentUserUsername){
            $this->redirect("users", "view", array($currentUserUsername));
        }

        $this->user = $this->model->getUserById($currentUserId)[0];
        $this->products = $userProducts;
        $this->renderView('index.php');
    }

    public function checkout(){
        $totalPrice = 0;
        if(empty($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }

        foreach($_SESSION['cart'] as $product){
            $quantity = $product['quantity'];
            $price = floatval($product['product']['Price']);
            $totalPrice += $quantity * $price;
        }

        $userId = intval($this->getLoggedUser()['id']);
        $user = $this->model->getUserById($userId);
        $userBalance = floatval($user[0]['money']);

        if($totalPrice > $userBalance){
            $this->addErrorMessage("Not enough money. Consider removing some items from the cart");
            $this->redirect("users", "cart");
        }

        $response = $this->model->checkout($userId, $userBalance, $totalPrice);
        if($response == 1){
            $_SESSION['cart'] = array();
            $this->addInfoMessage("Cart checked out successfully");
            if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"){
                $this->redirect("users", "view", array($user[0]['username']));
            } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"){
                $this->redirect("users", "view", array($user[0]['username']), "editor");
            }
        } else {
            $this->addErrorMessage("An error occurred please try again");
            if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "User"){
                $this->redirect("users", "cart");
            } else if($this->hasLoggedUser() && $this->getLoggedUser()['role'] == "Editor"){
                $this->redirect("users", "cart", array(), "editor");
            }
        }
    }

    public function cart(){
        $this->authorizeUser();

        if(empty($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }
        $this->productsInCart = $_SESSION['cart'];

        $this->renderView('cart.php');
    }
}