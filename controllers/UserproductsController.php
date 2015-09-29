<?php

namespace Controllers;


class UserproductsController extends MasterController{
    public function __construct(){
        parent::__construct(get_class(), 'userproducts', '\\views\\userproducts\\');
    }

    public function index(){
        $this->authorizeUser();

        $this->renderView('index.php');
    }


}