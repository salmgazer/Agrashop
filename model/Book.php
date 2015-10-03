<?php
include "adb.php";

class Book extends adb{

    function getBooks(){
        $str_sql = "SELECT * FROM book";

        $this->query($str_sql);
        $books = $this->fetch();
        if($books == null){
            return false;
        }
        return $books;
    }
}
