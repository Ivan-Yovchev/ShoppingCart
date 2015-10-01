<?php

namespace Models;

class ProductModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'products'));
    }

    public function getProductById($id){
        return $this->find(array('where' => "id=" . $id));
    }

    public function getUserProduct($productId){
        return $this->find(array(
            'columns' => 'id, Name, Price, PromotionId, CategoryId',
            'where' => "id=" . $productId
        ));
    }

    public function getProductByName($productName){
        $productName = urldecode($productName);
        return $this->find(array('where' => "LOWER(Name)='" . $productName . "'"));
    }

    public function take($productId, $quantity){
        $product = $this->getProductById($productId)[0];
        $model = array(
            'id' => $productId,
            'Quantity' => intval($product['Quantity']) - intval($quantity)
        );
        return $this->update($model);
    }

    public function give($productId, $quantity){
        $product = $this->getProductById($productId)[0];
        $model = array(
            'id' => $productId,
            'Quantity' => intval($product['Quantity']) + intval($quantity)
        );
        return $this->update($model);
    }

    public function addToCart($model){
        $product = $this->getProductById(intval($model->id));
        $product = $product[0];
        if(intval($model->quantity) > $product['Quantity']) {
            return "Cannot order so many items";
        }

        if(empty($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }

        //unset($_SESSION['cart']);

        $inCart = false;
        foreach($_SESSION['cart'] as $cartProduct){
            if($cartProduct['product']['id'] == intval($model->id)){
                $inCart = true;
                break;
            }
        }

        if($inCart == false) {
            array_push($_SESSION['cart'], array('quantity' => intval($model->quantity), 'product' => $product));
        } else {
            return $product['Name'] . " already in cart";
        }

        return true;
    }
}