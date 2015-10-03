<?php

namespace Models;

include_once DX_ROOT_DIR . "models/promotion.php";

class PromotionproductsModel extends MasterModel {
    public function __construct($args = array()){
        parent::__constuct(array('table' => 'promotionproducts'));
    }

    public function addPromotionProduct($model){
        $pair = array(
            'Promotions_id' => $model->promotionId,
            'Products_id' => $model->productId
        );

        return $this->add($pair);
    }

    public function addPromotionCategory($bindingModel){
        $model = new \Models\ProductModel();
        $products = $model->getCategoryProducts($bindingModel->categoryId);
        foreach($products as $product){
            $pair = array(
                'Promotions_id' => $bindingModel->promotionId,
                'Products_id' => $product['id']
            );

            $response = $this->add($pair);
            if($response == 0){
                return 0;
            }
        }

        return 1;
    }

    public function addPromotionAll($bindingModel){
        $model = new \Models\ProductModel();
        $products = $model->find();
        foreach($products as $product){
            $pair = array(
                'Promotions_id' => $bindingModel->promotionId,
                'Products_id' => $product['id']
            );

            $response = $this->add($pair);
            if($response == 0){
                return 0;
            }
        }

        return 1;
    }

    public function deleteByProductId($productId){
        $query = "DELETE FROM {$this->table} WHERE Products_id=" . intval( $productId );

        $this->db->query( $query );

        return $this->db->affected_rows; die();
    }

    public function deleteByPromotionId($promotionId){
        $query = "DELETE FROM {$this->table} WHERE Promotions_id=" . intval( $promotionId );

        $this->db->query( $query );

        return $this->db->affected_rows; die();
    }

    public function verifyPromotion($promotionId){
        $model = new \Models\PromotionModel();
        $promotion = $model->getPromotionById($promotionId);
        $today = date("Y-m-d");
        $start = date_create($promotion['promotion_start'])->format("Y-m-d");
        $end = date_create($promotion['promotion_end'])->format("Y-m-d");

        // expired
        if($today > $end){
            return -1;
        }

        // not started
        if($today < $start){
            return 0;
        }

        // started, yet to end
        if($today >= $start && $today <= $end){
            return 1;
        }
    }

    public function checkForPromotions($productId){
        $model = new \Models\PromotionModel();
        $promotions = $model->allPromotions();
        foreach($promotions as $promotion){
            $response = $this->verifyPromotion($promotion['id']);
            if($response == -1){
                $this->deleteByPromotionId($promotion['id']);
                $model->delete($promotion['id']);
            }
        }

        return $this->find(array('where' => 'Products_id=' . intval($productId)));
    }

    function getBiggestPromotion($productId){
        $productPromotions = $this->find(array('where' => "Products_id=" . intval($productId)));
        $promotions = array();

        $model = new \Models\PromotionModel();

        foreach($productPromotions as $productPromotion){
            $promotion = $model->getPromotionById($productPromotion["Promotions_id"]);
            if($this->verifyPromotion($promotion['id']) == 1){
                array_push($promotions, $promotion);
            }
        }

        $biggestDiscount = 0;
        $biggestPromotion = array();
        foreach($promotions as $promotion){
            if(intval($promotion['discount']) > $biggestDiscount){
                $biggestDiscount = intval($promotion['discount']);
                $biggestPromotion = $promotion;
            }
        }

        return $biggestPromotion;
    }
}