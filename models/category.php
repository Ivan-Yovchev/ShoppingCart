<?php

namespace Models;

class CategoryModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'categories'));
    }
}