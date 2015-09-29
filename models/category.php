<?php

namespace Models;

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
}