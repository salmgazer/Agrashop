<?php
include "adb.php";

/**
 * Class Sale
 */
 class Sale extends adb{
     
     function addSale($product_id, $product_price, $quantity_sold, $total_cost, $buyer_phone){
         $str_sql = "INSERT into sales(product_id, product_price, quantity_sold, total_cost, buyer_phone) values ('$product_id', $product_price, $quantity_sold, $total_cost, '$buyer_phone')";
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

//$sale = new Sale();
//echo $sale->addSale("898jhbh", 88, 5, (88 * 5));

?>
