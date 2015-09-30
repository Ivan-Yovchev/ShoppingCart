<?php

namespace Models;

class UserproductsModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'userproducts'));
    }

    public function getUserProducts($userId){
        return $this->find(array(
            'columns' => 'UserId, ProductId, COUNT(ProductId) as Quantity',
            'where' => 'UserId=' . $userId . " GROUP BY ProductId",

        ));
    }

    public function getUserProduct($userId, $productId){
        return $this->find(array(
            'columns' => 'UserId, ProductId, COUNT(ProductId) as Quantity',
            'where' => 'UserId=' . $userId . " AND ProductId=" . $productId. " GROUP BY ProductId",

        ));
    }

    public function giveUserProducts($pair){
        return $this->add($pair);
    }

    public function deleteItem( $userId, $productId ) {
        $query = "DELETE FROM {$this->table} WHERE UserId="
            . intval( $userId )
            . " AND ProductId=" . intval($productId)
            . " LIMIT 1";

        $this->db->query( $query );

        return $this->db->affected_rows;
    }
}