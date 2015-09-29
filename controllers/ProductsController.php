<?php

namespace Controllers;

use BindingModels\AddToCartBindingModel;

include_once "CategoriesController.php";

class ProductsController extends MasterController{

    public function __construct(){
        parent::__construct(get_class(), 'product', '\\views\\product\\');
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

        if($productCategory == "all"){
            $this->products = $this->model->find(array('where' => "LOWER(Name) like '%" . $searchTerm . "%'"));
        } else {
            $category = $controller->getCategoryByName($productCategory);
            $categoryId = intval($category[0]['id']);
            $this->products = $this->model->find(array('where' => "CategoryId=" . $categoryId . " and LOWER(Name) like '%" . $searchTerm . "%'"));
        }

        $this->renderView('products.php', true);
    }

    public function view($productName){
        $this->authorizeUser();

        $productName = urldecode($productName);
        $product = $this->getProductByName($productName);
        $controller = new CategoriesController();
        $category = $controller->getCategoryById($product[0]['CategoryId']);
        $this->product = $product[0];
        $this->category = $category[0];

        if(parent::isPost()){
            $model = $this->bind(new AddToCartBindingModel());
            $response = $this->model->addToCart($model);
            if(is_bool($response) && $response == true){
                var_dump($product);
                $this->addInfoMessage($product[0]['Name'] . " added to cart");
                $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))));
            } else {
                $this->addErrorMessage($response);
                $this->redirect("products", "index", array(htmlentities(urlencode(strtolower($category[0]['Name'])))));
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
            var_dump($_SESSION['cart']);
            $this->addInfoMessage($productName . " successfully removed from cart");
            $this->redirect("users", "cart");
        } else {
            $this->addErrorMessage("No instance of cart product with index: " . $index);
            $this->redirect("users", "cart");
        }
    }

    public function getProductByName($productName){
        return $this->model->getProductByName($productName);
    }
}