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
                $quantity = intval($product['quantity']);
                for($i = 0; $i < $quantity; $i++) {
                    $pairs = array(
                        'UserId' => $id,
                        'ProductId' => $product['product']['id']);
                    $response = $model->giveUserProducts($pairs);
                    if($response == 0){
                        return 0;
                    }
                }
            }
        }

        return 1;
    }

    private function subtractMoney($id, $balance, $price){
        $model = array('id' => $id, 'money' => $balance - $price);
        return $this->update($model);
    }

    public function sellItem($bindingModel){
        $model = new UserproductsModel();

        $quantity = intval($model->getUserProduct($bindingModel->userId, $bindingModel->productId)[0]['Quantity']);
        if($quantity < intval($bindingModel->quantity) || intval($bindingModel->quantity) < 1){
            return "Invalid Quantity";
        }

        for($i = 0; $i < intval($bindingModel->quantity); $i++){
            $response = $model->deleteItem($bindingModel->userId, $bindingModel->productId);
            if($response == 1){
                $user = $this->getUserById($bindingModel->userId);
                $money = floatval($user[0]['money']);
                $moneyResponse = $this->giveMoney($bindingModel->userId, $money + floatval($bindingModel->price));
                if($moneyResponse == 0){
                    return 0;
                }
            }
        }

        return 1;
    }

    private function giveMoney($userId, $amount){
        $model = array(
            'id' => $userId,
            'money' => $amount
        );
        return $this->update($model);
    }
}