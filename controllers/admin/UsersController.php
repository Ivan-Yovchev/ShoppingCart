<?php

namespace Admin\Controllers;

include_once DX_ROOT_DIR . "controllers/editor/UsersController.php";
include_once DX_ROOT_DIR . "controllers/UserproductsController.php";
include_once "ProductsController.php";
include_once "CategoriesController.php";

class UsersController extends \Editor\Controllers\UsersController {
    public function __construct(){
        parent::__construct(get_class(),
            'user',
            'views\\user\\');
    }

    public function view($username){
        $this->authorizeAdmin();
        parent::view($username);
    }

    public function cart(){
        $this->authorizeAdmin();
        parent::cart();
    }

    public function accounts(){
        $this->authorizeAdmin();

        $this->renderView('accounts.php');
    }

    public function account($username){
        $this->authorizeAdmin();
        $this->user = $this->model->find(array(
            'where' => "LOWER(username) = '" . strtolower(urldecode($username)) . "'"
        ))[0];

        if(parent::isPost()){
            $sellProductModel = $this->bind(new \BindingModels\SellProductBindingModel());
            $response = $this->model->removeUserItem($sellProductModel);

            if($response == 1){
                $this->addInfoMessage("successfully removed product");
            } else {
                $this->addErrorMessage("An error occurred please try again");
            }

            $this->redirect("users", 'account', array($username), "admin");
        }

        $userProductsController = new \Controllers\UserproductsController();
        $userProducts = $userProductsController->model->getUserProducts(intval($this->user['id']));

        $productsController = new ProductsController();
        $categoriesController = new CategoriesController();

        $promotionProductModel = new \Models\PromotionproductsModel();

        for($i = 0; $i < count($userProducts); $i++){
            $productId = $userProducts[$i]['ProductId'];
            $userProduct = $productsController->model->getUserProduct($productId)[0];
            $userProducts[$i]["product"] = $userProduct;

            $categoryId = $userProduct["CategoryId"];
            $category = $categoriesController->model->getCategoryById($categoryId)[0];
            $userProducts[$i]['category'] = $category;

            $userProducts[$i]['promotion'] = $promotionProductModel->getBiggestPromotion($productId);
        }
        $this->products = $userProducts;

        $this->renderView("user.php");
    }

    public function viewAccounts($searchTerm = ""){
        $this->authorizeAdmin();

        if($searchTerm == ""){
            $this->users = $this->model->find();
        } else {
            $this->users = $this->model->find(array(
                'where' => "username like '%" . $searchTerm . "%'"
            ));
        }

        $this->renderView("viewAccounts.php", true);
    }

    public function makeeditor($username){
        $user = $this->model->getUserByUsername($username)[0];
        $pairs = array(
            'id' => $user['id'],
            'role' => 'Editor'
        );
        $response = $this->model->update($pairs);
        if($response == 1){
            $this->addInfoMessage($username . ' successfully made editor');
        } else {
            $this->addErrorMessage("An error occurred please try again");
        }

        $this->redirect("users", "account", array($username), "admin");
    }

    public function makeadmin($username){
        $user = $this->model->getUserByUsername($username)[0];
        $pairs = array(
            'id' => $user['id'],
            'role' => 'Admin'
        );
        $response = $this->model->update($pairs);
        if($response == 1){
            $this->addInfoMessage($username . ' successfully made admin');
        } else {
            $this->addErrorMessage("An error occurred please try again");
        }

        $this->redirect("users", "account", array($username), "admin");
    }

    public function ban($username){
        $user = $this->model->getUserByUsername($username)[0];
        $pairs = array(
            'id' => $user['id'],
            'banned' => 1
        );
        $response = $this->model->update($pairs);
        if($response == 1){
            $this->addInfoMessage($username . ' banned');
        } else {
            $this->addErrorMessage("An error occurred please try again");
        }

        $this->redirect("users", "account", array($username), "admin");
    }
}