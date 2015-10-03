<?php

namespace Models;

include_once DX_ROOT_DIR . "models/promotionproducts.php";

class ProductModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'products'));
    }

    public function getProductById($id){
        return $this->find(array('where' => "id=" . $id));
    }

    public function getUserProduct($productId){
        $productId = intval($productId);
        return $this->find(array(
            'columns' => 'id, Name, Price, CategoryId',
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

    public function removeProductById($model){
        $promotionProductsModel = new \Models\PromotionproductsModel();
        $response = $promotionProductsModel->deleteByProductId($model->productId);
        if($response < 0){
            return 0;
        }

        return $this->delete($model->productId);
    }

    public function deleteProductById($id){
        $promotionProductsModel = new \Models\PromotionproductsModel();
        $response = $promotionProductsModel->deleteByProductId($id);
        if($response < 0){
            return 0;
        }

        return $this->delete($id);
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
//        var_dump($pairs); die();
        return $this->add($pairs);
    }

    public function addToCart($model){
        $product = $this->getProductById(intval($model->id));
        $product = $product[0];

        $promotionProductsModel = new \Models\PromotionproductsModel();
        $promotion = $promotionProductsModel->getBiggestPromotion($product['id']);

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
            array_push($_SESSION['cart'], array(
                'quantity' => intval($model->quantity),
                'product' => $product,
                'promotion' => $promotion
            ));
        } else {
            return $product['Name'] . " already in cart";
        }

        return true;
    }

    public function getCategoryProducts($categoryId){
        return $this->find(array("where" => "CategoryId=" . $categoryId));
    }

    public function deleteProductByCategory($id){
        $id = intval($id);
        $products = $this->find(array('where' => 'CategoryId=' . $id));
        if(count($products) > 0){
            foreach($products as $product){
                $response = $this->deleteProductById($product['id']);
                if($response == 0){
                    return 0;
                }
            }
        }

        return 1;
    }

    public function move($model){
        if(intval($model->from) == intval($model->to)){
            return "Already in this category";
        }

        $pairs = array(
            'id' => $model->productId,
            'CategoryId' => $model->to
        );
        return $this->update($pairs);
    }

    public function changeQuantity($model){
        $pairs = array(
            'id' => $model->productId,
            'Quantity' => $model->quantity
        );

        return $this->update($pairs);
    }

    public function getAllProducts(){
        return $this->find();
    }
}