<?php header('Access-Control-Allow-Origin: *');
 session_start();
/**
 * Created by PhpStorm.
 * User: Salifu
 * Date: 9/5/2015
 * Time: 11:17 AM
 */

if(!isset($_REQUEST['cmd'])){
    echo '{"result":0,message:"unknown command"}';
    exit();
}
$cmd=$_REQUEST['cmd'];
switch($cmd) {
    case 1:
        signIn();
        break;
    case 2:
        getUserDetails();
        break;
    case 3:
        getProducts();
        break;
    case 4:
        getProductById();
        break;
    case 5:
        registerUser();
        break;
    case 6:
        addProduct();
        break;
    case 7:
        addSale();
        break;
    case 8:
        signOut();
        break;
    case 9:
        getSales();
        break;
    case 10:
        updateProduct();
        break;
    default:
        echo '{"result":0, message:"unknown command"}';
        break;

}


//shopkeeper sign in
function signIn(){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    include_once "../model/Seller.php";
    $seller = new Seller();
    if($seller->signInShopkeeper($username, $password)){
        echo '{"result": 1, "message": "Signed in successfully"}';
            return;
    }
    echo '{"result": 0, "message": "Sign in was unsuccessful"}';
    return;
}

function registerUser(){
    $seller_name = $_REQUEST['seller_name'];
    $seller_username = $_REQUEST['seller_username'];
    $seller_password = $_REQUEST['seller_password'];
    $seller_phone = $_REQUEST['seller_phone'];
    $seller_type = $_REQUEST['seller_type'];
    $admin_password = $_REQUEST['admin_password'];
    
    include_once "../model/Seller.php";
    $seller = new Seller();
    $adduser = $seller->addShopKeeper($seller_name, $seller_username, $seller_password, $seller_phone, $seller_type, $admin_password);
    if($adduser == "wrong admin password!"){
        echo '{"result": 0, "message": "'.$adduser.'"}';
        return;
    }
    if($adduser == "existing username"){
        echo '{"result": 0, "message": "'.$adduser.'"}';
        return;
    }
    if($adduser){
        echo '{"result": 1, "message": "You successfully added '.$seller_name.' as a '.$seller_type.'"}';
        return;
    }
    echo '{"result": 0, "Failed to add '.$seller_name.' as '.$seller_type.'"}';
    return;
}

function signOut(){
    if(session_destroy()){
        echo '{"result": 1}';
    }else{
        echo '{"result": 0}';
    }
    
}

function getUserDetails(){
    if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['user_type'])){
        echo '{"result": 1, "username": "'.$_SESSION['username'].'", "user_type": "'.$_SESSION['user_type'].'"}';
        return;
    }
   //session_destroy();
    echo '{"result": 0, "message": "You need to sign in first"}';
    return;
}


function addProduct(){
    $product_id = $_REQUEST['product_id'];
    $product_name = $_REQUEST['product_name'];
    $product_quantity = $_REQUEST['product_quantity'];
    $product_unit_price = $_REQUEST['product_unit_price'];

    include_once "../model/Product.php";
    $product = new Product();
    if($product->addProduct($product_id, $product_name, $product_quantity, $product_unit_price)){
        echo '{"result": 1, "message": "'.$product_name.' has been added"}';
        return;
    }
    echo '{"result": 0, "message": "'.$product_name.' has not been added"}';
    return;
}

function getProducts(){
    include_once "../model/Product.php";
    $searchEntry = $_REQUEST['searchEntry'];
    $product = new Product();
    $products = $product->getProducts($searchEntry);
    if(!$products){
        echo '{"result": 0, "message": "No products yet"}';
        return;
    }
    echo '{"result": 1, "products": [';
    while($products){
        echo json_encode($products);
        $products = $product->fetch();
        if($products){
            echo ",";
        }
    }
    echo ']}';
    return;
}

function getProductById(){
    include_once "../model/Product.php";

    $current_product_id = $_REQUEST['current_product_id'];
    $product = new Product();
    $singleProduct = $product->getProductById($current_product_id);

    if(!$singleProduct){
        echo '{"result": 0, "message": "No such product"}';
        return;
    }
    echo '{"result": 1, "singleProduct": ['.json_encode($singleProduct).']}';
    return;
}

function addSale(){
    include_once "../model/Sale.php";
    
    $product_id = $_REQUEST['product_id'];
    $product_price = $_REQUEST['product_price'];
    $quantity_sold = $_REQUEST['quantity_sold'];
    $total_cost = $_REQUEST['total_cost'];
    $buyer_phone = $_REQUEST['buyer_phone'];
    $seller_username = $_SESSION['username'];
    
    $mysale = new Sale();
    if(!$mysale->addSale($product_id, $product_price, $quantity_sold, $total_cost, $buyer_phone, $seller_username)){
        echo '{"result": 0, "message": "Could not add sale"}';
        return;
    }
    echo '{"result": 1, "message": "Sale has been recorded"}';
    return;
}

function getSales(){
    include_once "../model/Sale.php";
    
    $sales = new Sale();
    $mysales = $sales->getSales();
    
    if(!$mysales){
        echo '{"result": 0, "No sales"}';
        return;
    }
    
    echo '{"result": 1, "sales": [';
    while($mysales){
        echo json_encode($mysales);
        $mysales = $sales->fetch();
        if($mysales){
            echo ",";
        }
    }
    echo ']}';
}

function updateProduct(){
    include_once "../model/Product.php";
    
    $product = new Product();
    $product_id = $_REQUEST['product_id'];
    $new_quantity = $_REQUEST['new_quantity'];
    $new_price = $_REQUEST['new_price'];
     
    if(!$product->updateProduct($product_id, $new_quantity, $new_price)){
        echo '{"result": 0, "message": "could not update product"}';
        return;
    }
    echo '{"result": 0, "message": "product has been updated"}';
    return;
}

