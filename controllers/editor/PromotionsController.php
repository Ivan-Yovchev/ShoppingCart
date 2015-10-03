<?php

namespace Editor\Controllers;

use BindingModels\AddPromotionBindingModel;
use BindingModels\PromoteAllBindingModel;
use BindingModels\PromoteCategoryBindingModel;
use BindingModels\PromoteProductBindingModel;

include_once DX_ROOT_DIR . "controllers/ProductsController.php";
include_once DX_ROOT_DIR . "controllers/CategoriesController.php";
include_once DX_ROOT_DIR . "models/promotionproducts.php";

class PromotionsController extends \Controllers\MasterController {
    public function __construct(
        $class_name = "\\Editor\\Controllers\\PromotionsController",
        $model = 'promotion',
        $views_dir = "views\\editor\\promotions\\"){

        parent::__construct($class_name, $model, $views_dir);
    }

    public function index(){
        $this->authorizeEditor();
        $this->renderView("index.php");
    }

    public function add(){
        $this->authorizeEditor();

        if(parent::isPost()){
            $model = $this->bind(new AddPromotionBindingModel());
            $response = $this->model->create($model);
            if($response == 1){
                $this->addInfoMessage("Successfully created promotion");
            } else if(is_bool($response)){
                $this->addErrorMessage("An error occurred please try again");
            } else {
                $this->addErrorMessage($response);
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("promotions", "index", array(), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("promotions", "index", array(), "admin");
            }
        }

        $this->renderView("addPromotion.php");
    }

    public function show($searchTerm = ""){
        $this->authorizeEditor();
        $this->promotions = $this->model->getAllPromotions($searchTerm);
        $this->renderView("promotions.php", true);
    }

    public function onproduct($promotionId){
        $this->authorizeEditor();

        $controller = new \Controllers\ProductsController();

        $this->promotion = $this->model->getPromotionById($promotionId);
        $this->products = $controller->model->find();

        if(parent::isPost()){
            $bindingModel = $this->bind(new PromoteProductBindingModel());
            $model = new \Models\PromotionproductsModel();
            $response = $model->addPromotionProduct($bindingModel);
            if($response == 1){
                $this->addInfoMessage("Successfully added promotion");
            } else {
                $this->addErrorMessage("An error occurred please try again");
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("promotions", "index", array(), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("promotions", "index", array(), "admin");
            }
        }

        $this->renderView("promotionOnProduct.php");
    }

    public function oncategory($promotionId){
        $this->authorizeEditor();

        $controller = new \Controllers\CategoriesController();

        $this->promotion = $this->model->getPromotionById($promotionId);
        $this->categories = $controller->model->find();

        if(parent::isPost()){
            $bindingModel = $this->bind(new PromoteCategoryBindingModel());
            $model = new \Models\PromotionproductsModel();
            $response = $model->addPromotionCategory($bindingModel);
            if($response == 1){
                $this->addInfoMessage("Successfully added promotion");
            } else {
                $this->addErrorMessage("An error occurred please try again");
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("promotions", "index", array(), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("promotions", "index", array(), "admin");
            }
        }

        $this->renderView("promotionOnCategory.php");
    }

    public function onall($promotionId){
        $this->authorizeEditor();

        $controller = new \Controllers\ProductsController();

        $this->promotion = $this->model->getPromotionById($promotionId);
        $this->count = count($controller->model->find());

        if(parent::isPost()){
            $bindingModel = $this->bind(new PromoteAllBindingModel());
            $model = new \Models\PromotionproductsModel();
            $response = $model->addPromotionAll($bindingModel);
            if($response == 1){
                $this->addInfoMessage("Successfully added promotion");
            } else {
                $this->addErrorMessage("An error occurred please try again");
            }

            if($this->getLoggedUser()['role'] == 'Editor'){
                $this->redirect("promotions", "index", array(), "editor");
            } else if($this->getLoggedUser()['role'] == 'Admin'){
                $this->redirect("promotions", "index", array(), "admin");
            }
        }

        $this->renderView("promotionOnAll.php");
    }
}