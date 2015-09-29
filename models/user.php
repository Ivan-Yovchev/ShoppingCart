<?php

namespace Models;

include_once "userproducts.php";

class UserModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'users'));
    }

    public function getUserById($id) {
        return $this->find(array('where' => 'id=' . $id, 'columns' => "id, username, money, role"));
    }

    public function checkout($id, $balance, $price){
        $response = $this->subtractMoney($id, $balance, $price);
        if($response == 1){
            $model = new UserproductsModel();

            foreach($_SESSION['cart'] as $product){
                $pairs = array(
                    'UserId' => $id,
                    'ProductId' => $product['product']['id']);
                $response = $model->giveUserProducts($pairs);
                if($response == 0){
                    return 0;
                }
            }
        }

        return 1;
    }

    private function subtractMoney($id, $balance, $price){
        $model = array('id' => $id, 'money' => $balance - $price);
        return $this->update($model);
    }
}