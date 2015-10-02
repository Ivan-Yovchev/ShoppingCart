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

    public function removeProductByName($productName){
        $productId = $this->getProductByName($productName)[0]['id'];
        return $this->delete($productId);
    }

    public function addProduct($model){
        if(floatval($model->price) < 0.01){
            return "Invalid Price";
        }

        if($model->productName == ''){
            return "Invalid Name";
        }

        if(intval($model->quantity) < 1){
            return "Invalid Quantity";
        }

        $pairs = array(
            'Name' => $model->productName,
            'Price' => $model->price,
            'Quantity' => $model->quantity,
            'CategoryId' => $model->categoryId
        );
        if($model->promotionId != "null"){
            $pairs['PromotionId'] = $model->promotionId;
        }
//        var_dump($pairs); die();
        return $this->add($pairs);
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