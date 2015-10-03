<?php

namespace Models;

class PromotionModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'promotions'));
    }

    public function create($model){
        if($model->from == $model->to){
            return "Promotions must continue at least a day";
        }

        $pairs = array(
            'discount' => $model->discount,
            'promotion_start' => $model->from,
            'promotion_end' => $model->to
        );
        return $this->add($pairs);
    }

    public function getAllPromotions($searchTerm){
        if($searchTerm == ""){
            return $this->find();
        }

        return $this->find(array('where' => "discount like '%" . $searchTerm . "%'"));
    }

    public function getPromotionById($id){
        return $this->find(array('where' => "id=" . intval($id)))[0];
    }

    public function allPromotions(){
        return $this->find();
    }


}