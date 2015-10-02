<?php

namespace Editor\Controllers;

include_once DX_ROOT_DIR . "controllers/UsersController.php";

class UsersController extends \Controllers\UsersController {
    public function __construct(
        $class_name = '\Controllers\Editor\UsersController',
        $model = 'user',
        $views_dir = 'views\\user\\'){
        parent::__construct($class_name, $model, $views_dir);
    }

    public function view($username){
        $this->authorizeEditor();
        parent::view($username);
    }

    public function cart(){
        $this->authorizeEditor();
        parent::cart();
    }
}