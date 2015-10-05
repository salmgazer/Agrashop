<?php
include "adb.php";

class Book extends adb{

    function getBooks($searchEntry){
       // $str_sql = "SELECT * FROM book WHERE title like '$searchEntry'";
        $str_sql = "select * from book where title LIKE CONCAT('%','$searchEntry','%')";

        $this->query($str_sql);
        $books = $this->fetch();
        if($books == null){
            return false;
        }
        return $books;
    }

    function getBookById($current_book_id){
        //query to get single book based on book id
        $str_sql = "select * from book where id = $current_book_id limit 0,1";

        $this->query($str_sql);
        $current_book = $this->fetch();
        if($current_book == null){
            return false;
        }
        return $current_book;
    }
}
