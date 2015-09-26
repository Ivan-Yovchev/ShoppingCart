<?php

namespace Models;

class UserModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'users'));
    }
}