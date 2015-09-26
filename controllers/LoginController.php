<?php

namespace Controllers;

class LoginController extends MasterController {
    public function __construct(){
        parent::__construct(get_class(), 'master', '\\views\\login\\');
    }

    public function index(){

        $auth = \Lib\Auth::get_instance();

        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $is_logged_in = $auth->login($username, $password);

            var_dump($is_logged_in);
        }

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }

    public function logout(){

    }
}