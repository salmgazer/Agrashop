<?php

/**
 * Created by PhpStorm.
 * User: Salifu
 * Date: 9/5/2015
 * Time: 8:07 AM
 */

/* Include adb.php */
include_once "adb.php";

/**
 * Class Seller
 */
class Seller extends adb
{

    /**
     * @param $admin_password
     * @return bool
     */
    function checkAdminPass($admin_password){

        $str_sql = "SELECT * from seller where seller_password = '$admin_password' AND seller_type = 'admin' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }

    /**
     * @param $seller_name
     * @param $seller_username
     * @param $seller_password
     * @param $seller_phone
     * @param $seller_type
     * @param $admin_password
     * @return bool|string
     */
    function addShopkeeper($seller_name, $seller_username, $seller_password, $seller_phone, $seller_type, $admin_password) {
        
        /* SEARCH IF  ADMIN PASSWORD EXISTS */
        if(!$this->checkAdminPass($admin_password))
        {
            return "wrong admin password!";
        }

        if($this->checkShopkeeper($seller_username))
        {
            return "existing username";
        }
        $seller_id = $seller_name.$seller_phone;
        /* Add new shop keeper */
        $str_sql = "INSERT INTO seller(seller_id, seller_name, seller_username, seller_password, seller_phone, seller_type) VALUES 
        ('$seller_id', '$seller_name', '$seller_username', '$seller_password', '$seller_phone', '$seller_type')";

        return $this->query($str_sql);
    }

    /**
     * @param $seller_username
     * @param $seller_password
     * @return bool
     */
    function signInShopkeeper($seller_username, $seller_password)
    {
        $str_sql = "SELECT * FROM seller WHERE seller_username = '$seller_username' AND
seller_password = '$seller_password' limit 0,1";
        $this->query($str_sql);
        $row = $this->fetch();
        if($row == null)
        {
         return false;
        }
        
        /* set sessions */
        $_SESSION['user_type'] = $row['seller_type'];
        $_SESSION['username'] = $seller_username;
        $_SESSION['password'] = $seller_password;

        return true;
    }

    /**
     * @param $seller_username
     * @return bool
     */
    function checkShopkeeper($seller_username)
    {
        $str_sql = "SELECT * FROM seller where seller_username = '$seller_username' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }

    }
    
 //   $mysel = new Seller();
   //echo $mysel->checkShopkeeper("aliseller", "aliseller123");
 //  echo $mysel->addShopkeeper("King Seller", "j9908j", "joeioitler67", "0247900234", "admin", "dototo4real");
   
    

