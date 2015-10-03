<?php

namespace Models;

include_once "product.php";

class CategoryModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'categories'));
    }

    public function getCategoryByName($name){
        return $this->find(array("where" => "name='" . $name . "'"));
    }

    public function getCategoryById($id){
        return $this->find(array("where" => "id=" . $id));
    }

    public function deleteCategory($model){
        $productModel = new ProductModel();
        $result = $productModel->deleteProductByCategory($model->categoryId);
        if($result == 0){
            return 0;
        }

        return $this->delete($model->categoryId);
    }

    public function addCategory($model){
        $pairs = array(
            'Name' => $model->categoryName
        );
        return $this->add($pairs);
    }
}