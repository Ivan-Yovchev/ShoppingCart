<?php

namespace Controllers;

class MasterController {

    protected $layout;
    protected $views_dir;
    protected $auth;

    public function __construct($class_name = '\Controllers\MasterController',
            $model = 'master',
            $views_dir = 'views\\master\\'){
        $this->views_dir = $views_dir;
        $this->class_name = $class_name;

        include_once DX_ROOT_DIR . "models\\{$model}.php";
        $model_class = "\Models\\" . ucfirst($model) . "Model";

        $this->model = new $model_class(array( 'table' => 'none'));

        $this->auth = \Lib\Auth::get_instance();
        $logged_user = $this->auth->get_logged_user();
        $this->logged_user = $logged_user;

        $this->layout = DX_ROOT_DIR . 'views\\layouts\\default.php';
    }

    public function index(){
        $this->renderView('index.php');
    }

    protected function renderView($fileName, $isPartialView = false){
        $template_name = $this->getCurrentLocation() . $fileName;
        $isPartial = $isPartialView;

        include_once $this->layout;
    }

    protected function getCurrentLocation(){
        return DX_ROOT_DIR . $this->views_dir;
    }

    protected function redirectToUrl($url) {
        header("Location: $url");
        die;
    }

    protected function redirect($controller = null, $action = null, $params = []) {
        if ($controller == null) {
            $controller = "master";
        }
        $url = "/cart/$controller/$action";
        $paramsUrlEncoded = array_map('urlencode', $params);
        $paramsJoined = implode('/', $paramsUrlEncoded);
        if ($paramsJoined != '') {
            $url .= '/' . $paramsJoined;
        }
        $this->redirectToUrl($url);
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function has_logged_user(){
        return $this->auth->is_logged_in();
    }

    protected function get_logged_user(){
        return $this->auth->get_logged_user();
    }
}