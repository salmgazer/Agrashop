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
    default:
        echo '{"result":0, message:"unknown command"}';
        break;

}


//shopkeeper sign in
function signIn(){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $user_type = $_REQUEST['user_type'];

    include "../model/Member.php";
    $member = new Member();

    if($user_type == "1"){
        if($member->signInShopkeeper($username, $password)){
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['user_type'] = $user_type;
            echo '{"result": 1, "message": "Signed in successfully as shopkeeper"}';
            return;
        }else{
            echo '{"result": 0, "message": "Sign in as shopkeeper unsuccessful"}';
            return;
        }
    }
    else if($user_type == "2"){
        if($member->signInAdmin($username, $password)){
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['user_type'] = $user_type;
            echo '{"result": 1, "message": "Signed in successfully as admin"}';
            return;
        }else{
            echo '{"result": 0, "message": "Sign in as admin was unsuccessful"}';
            return;
        }
    }

}

function getUserDetails(){
    if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['user_type'])){
        echo '{"result": 1, "username": "'.$_SESSION['username'].'", "user_type": "'.$_SESSION['user_type'].'"}';
        return;
    }
   // session_destroy();
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

