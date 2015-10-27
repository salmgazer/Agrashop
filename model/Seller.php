<?php

/**
 * Created by PhpStorm.
 * User: Salifu
 * Date: 9/5/2015
 * Time: 8:07 AM
 */

/* Include adb.php */
include "adb.php";

class Seller extends adb
{

    function checkAdminPass($admin_password){

        $str_sql = "SELECT * from seller where seller_password = '$admin_password' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }

    function addShopkeeper($seller_name, $seller_username, $seller_password, $seller_phone, $seller_type, $admin_password)
    {
        
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

   /* function addAdmin($firstname, $lastname, $email, $admin_username, $admin_password, $other_admin_password)
    {
        /* SEARCH IF  ADMIN PASSWORD EXISTS */
        /*if(!$this->checkAdminPass($other_admin_password))
        {
            return "wrong existing admin password!";
        }

        /* Add new Admin */
        /*$str_sql = "INSERT INTO shopadmin (firstname, lastname, email, admin_username, admin_password) VALUES
('$firstname', '$lastname', '$email', '$admin_username', '$admin_password')";

        return $this->query($str_sql);
    }*/

    //working
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

    //Not needed as at now
    /*function signInAdmin($admin_username, $admin_password)
    {
        $str_sql = "SELECT * FROM shopadmin where admin_username = '$admin_username' AND admin_password = '$admin_password' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }

        /*se sessions */
        /*$_SESSION['user_type'] = "admin";
        $_SESSION['username'] = $admin_username;
        $_SESSION['password'] = $admin_password;

        return true;
    }
    */
    //working
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

    //working
    /*function checkAdmin($seller_username)
    {
        $str_sql = "SELECT * FROM seller where seller_username = '$seller_username' AND seller_type = 'admin' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }*/

    }
    
    /*$mysel = new Seller();
   //echo $mysel->checkShopkeeper("aliseller", "aliseller123");
   echo $mysel->addShopkeeper("Joe Juhu", "j5y28j", "joethertler67", "0247998234", "admin", "dototo4real");
   */
    

