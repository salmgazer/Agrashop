<?php
include "adb.php";

/**
 * Class Sale
 */
 class Sale extends adb{
     
     function addSale($product_id, $product_price, $quantity_sold, $total_cost){
         $str_sql = "INSERT into (product_id, product_price, quantity_sold, total_cost) values ('$product_id', $product_price, $quantity_sold, $total_cost)";
         return $this->query($str_sql);
     }
     
     function getSales(){
         $str_sql = "SELECT * from sales";
         if(!$this->query($str_sql)){
             return false;
         }
         return $this->fetch();
     }
}

?>
