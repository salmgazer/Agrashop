<?php
include_once "adb.php";

/**
 * Class Product
 */
class Product extends adb{

    /**
     * @param $searchEntry
     * @return array|bool
     */
    function getProducts($searchEntry){
       // $str_sql = "SELECT * FROM product WHERE title like '$searchEntry'";
        $str_sql = "select * from product where product_name LIKE CONCAT('%','$searchEntry','%')";

        $this->query($str_sql);
        $products = $this->fetch();
        if($products == null){
            return false;
        }
        return $products;
    }

    /**
     * @param $current_product_id
     * @return array|bool
     */
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

    /**
     * @param $product_id
     * @param $product_name
     * @param $product_quantity
     * @param $product_unit_price
     * @return bool
     */
   function addProduct($product_id, $product_name, $product_quantity, $product_unit_price){
       $str_sql = "INSERT INTO product(product_id, product_name, product_quantity, product_unit_price) VALUES ('$product_id', '$product_name', $product_quantity, $product_unit_price)";
       return $this->query($str_sql);
   }

    /**
     * @param $product_id
     * @param $newPrice
     * @return bool
     */
   function updatePrice($product_id, $newPrice){
       $str_sql = "UPDATE product set product_unit_price = $newPrice WHERE product_id = '$product_id'";
       return $this->query($str_sql);
   }
   
   function updateQuantity($product_id, $quantity_sold){
       $row = $this->getProductById($product_id);
       $quant = $row['product_quantity'];
       $newQ =  $quant - $quantity_sold;
       $str_sql = "UPDATE product set product_quantity = $newQ WHERE product_id = '$product_id'";
       return $this->query($str_sql);
   }
   
   function setQuantity($product_id, $newQuantity){
       $str_sql = "UPDATE product set product_quantity = $newQuantity WHERE product_id = $product_id";
       return $this->query($str_sql);
   }
   
   function updateProduct($product_id, $product_quantity, $product_unit_price){
       $str_sql = "UPDATE product set product_quantity = $product_quantity, product_unit_price = $product_unit_price WHERE product_id = '$product_id'";
       return $this->query($str_sql);
   }

}

//$prod = new Product();
//echo $prod->addProduct("89hj3", "Apple Iphone", 34, 34.78);
//$row = $prod->getProductById("TV123JJ");
//echo $row['product_quantity'];

//echo $prod->getProducts("apple")['product_name'];
//echo $prod->updateQuantity("TV123JJ", 4);
//echo $prod->updateProduct('898jhbh', 100, 100);
