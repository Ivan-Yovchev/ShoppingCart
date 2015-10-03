<?php

namespace Admin\Controllers;

use BindingModels\AddPromotionBindingModel;
use BindingModels\PromoteAllBindingModel;
use BindingModels\PromoteCategoryBindingModel;
use BindingModels\PromoteProductBindingModel;

include_once DX_ROOT_DIR . "controllers/editor/PromotionsController.php";

class PromotionsController extends \Editor\Controllers\PromotionsController {
    public function __construct(
        $class_name = "\\Admin\\Controllers\\PromotionsController",
        $model = 'promotion',
        $views_dir = "views\\admin\\promotions\\"){

        parent::__construct($class_name, $model, $views_dir);
    }

    public function index(){
        $this->authorizeAdmin();
        parent::index();
    }

    public function add(){
        $this->authorizeAdmin();
        parent::add();
    }

    public function show($searchTerm = ""){
        $this->authorizeAdmin();
        parent::show($searchTerm);
    }

    public function onproduct($promotionId){
        $this->authorizeAdmin();
        parent::onproduct($promotionId);
    }

    public function oncategory($promotionId){
        $this->authorizeAdmin();
        parent::oncategory($promotionId);
    }

    public function onall($promotionId){
        $this->authorizeAdmin();
        parent::onall($promotionId);
    }
}