<?php
include_once "adb.php";

/**
 * Class Sale
 */
 class Sale extends adb{
     
     function addSale($product_id, $product_price, $quantity_sold, $total_cost, $buyer_phone, $seller_username){
         //check if sale is possible
         include_once "Product.php";
         $product = new Product();
         $available = $product->getProductById($product_id)['product_quantity'];
         if($available < $quantity_sold){
             return "Can not complete sale. Only $available available";
         }
         $str_sql = "INSERT into sales(product_id, product_price, quantity_sold, total_cost, buyer_phone, seller_username)
          values ('$product_id', $product_price, $quantity_sold, $total_cost, '$buyer_phone', '$seller_username')";
          $sell = $this->query($str_sql);
         if($sell){
             if(!$product->updateQuantity($product_id, $quantity_sold)){
                 //do offline
                 return "could not update quantity after sale";
             }
         }
         return true;
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
//echo $sale->addSale("898jhbh", 88, 8, (88 * 8), "0246119996", "salmut123");

?>
