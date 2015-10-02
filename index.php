<?php

define( 'DX_ROOT_DIR', dirname(__FILE__) . '\\');
define( 'DX_ROOT_PATH', basename(dirname(__FILE__)) . '/');

$request = $_SERVER['REQUEST_URI'];
$request_home = '/' . DX_ROOT_PATH;

$controller = "master";
$method = "index";
$admin_routing = false;
$editor_routing = false;
$param = array();

include_once 'config/config.php';
include_once 'lib/auth.php';
include_once 'lib/database.php';
include_once 'controllers/MasterController.php';
include_once 'models/master.php';
include_once 'models/bindingModels/LoginBindingModel.php';
include_once 'models/bindingModels/RegisterBindingModel.php';
include_once 'models/bindingModels/AddToCartBindingModel.php';
include_once 'models/bindingModels/SellProductBindingModel.php';
include_once 'models/bindingModels/AddProductBindingModel.php';

if(!empty($request)){
    if(0 === strpos($request, $request_home)) {
        $request = substr($request, strlen($request_home));

        if(0 === strpos($request, 'admin/')){
            $admin_routing = true;
            include_once "controllers/admin/AdminController.php";
            $request = substr($request, strlen('admin/'));
        } else if(0 === strpos($request, 'editor/')){
            $editor_routing = true;
            include_once "controllers/editor/EditorController.php";
            $request = substr($request, strlen('editor/'));
        }

        $components = explode('/', $request, 3);
        if(1 < count($components)){
            list($controller, $method) = $components;

            if(isset($components[2])){
                $param = explode('/', $components[2]);
            }

            if($admin_routing){
                $admin_folder = "admin/";
                include_once 'controllers/' . $admin_folder . ucfirst($controller) . "Controller.php";
            } else if($editor_routing){
                $editor_folder = "editor/";
                include_once 'controllers/' . $editor_folder . ucfirst($controller) . "Controller.php";
            } else {
                include_once 'controllers/' . ucfirst($controller) . "Controller.php";
            }
        }
    }
}

$controller_class = '\Controllers\\' . ucfirst($controller) . "Controller";
if($admin_routing) {
    $admin_namespace = "\Admin";
    $controller_class = $admin_namespace . $controller_class;
} else if($editor_routing) {
    $editor_namespace = "\Editor";
    $controller_class = $editor_namespace . $controller_class;
}
$instance = new $controller_class();

if(method_exists($instance, $method)){
    call_user_func_array(array($instance, $method), $param);
}

$db_object = \Lib\Database::get_Instance();

