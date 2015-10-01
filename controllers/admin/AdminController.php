<?php

namespace Admin\Controllers;

class AdminController extends \Controllers\MasterController {
    public function __construct(
        $class_name = "\\Admin\\Controllers\\AdminController",
        $model = 'master',
        $views_dir = "views\\admin\\master\\"){

        parent::__construct($class_name, $model, $views_dir);
    }

    public function test(){
        $this->authorizeAdmin();
        var_dump("Accessed");
    }

}