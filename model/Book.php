<?php
include "adb.php";

class Product extends adb{

    function getProductss($searchEntry){
       // $str_sql = "SELECT * FROM product WHERE title like '$searchEntry'";
        $str_sql = "select * from product where product_name LIKE CONCAT('%','$searchEntry','%')";

        $this->query($str_sql);
        $products = $this->fetch();
        if($products == null){
            return false;
        }
        return $products;
    }

    function getProductById($current_product_id){
        //query to get single product based on product id
        $str_sql = "select * from product where product_id = '$current_product_id' limit 0,1";

        $this->query($str_sql);
        $current_product = $this->fetch();
        if($current_product == null){
            return false;
        }
        return $current_product;
    }
}
