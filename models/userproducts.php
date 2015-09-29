<?php

namespace Models;

class UserproductsModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'userproducts'));
    }

    public function giveUserProducts($pair){
        return $this->add($pair);
    }
}