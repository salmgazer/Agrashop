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
}
