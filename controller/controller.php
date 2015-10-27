<?php session_start();
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
        getBooks();
        break;
    case 4:
        getBookById();
        break;
    case 5:
        registerUser();
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
    $seller_name = $_REQUEST['seller_username'];
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

function getUserDetails(){
    if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['user_type'])){
        echo '{"result": 1, "username": "'.$_SESSION['username'].'", "user_type": "'.$_SESSION['user_type'].'"}';
        return;
    }
   //session_destroy();
    echo '{"result": 0, "message": "You need to sign in first"}';
    return;
}

function getBooks(){
    include_once "../model/Book.php";

    $searchEntry = $_REQUEST['searchEntry'];
    $book = new Book();
    $books = $book->getBooks($searchEntry);
    if(!$books){
        echo '{"result": 0, "message": "No books yet"}';
        return;
    }
    echo '{"result": 1, "books": [';
    while($books){
        echo json_encode($books);
        $books = $book->fetch();
        if($books){
            echo ",";
        }
    }
    echo ']}';
    return;
}

function getBookById(){
    include_once "../model/Book.php";

    $current_book_id = $_REQUEST['current_book_id'];
    $book = new Book();
    $singleBook = $book->getBookById($current_book_id);

    if(!$singleBook){
        echo '{"result": 0, "message": "No such book"}';
        return;
    }
    echo '{"result": 1, "singleBook": ['.json_encode($singleBook).']}';
    return;
}

