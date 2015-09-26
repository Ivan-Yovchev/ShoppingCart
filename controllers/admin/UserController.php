<?php

namespace Admin\Controllers;


class UserController extends AdminController {
    public function __construct(){
        var_dump("is admin user");
        parent::__construct(get_class(),
            'user',
            'views\\admin\\user\\');
    }

    public function index(){
        $users = $this->model->find();

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }

    public function view($id){
        $users = $this->model->get($id);

        var_dump($users);

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }
}