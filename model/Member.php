<?php

/**
 * Created by PhpStorm.
 * User: Salifu
 * Date: 9/5/2015
 * Time: 8:07 AM
 */

/* Include adb.php */
include "adb.php";

class Member extends adb
{

    function checkAdminPass($admin_password){

        $str_sql = "SELECT * from shopadmin where admin_password = '$admin_password' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }

    function addShopkeeper($firstname, $lastname,$shopkeeper_username, $shopkeeper_password, $address, $phone, $email, $sex, $admin_password)
    {
        /* SEARCH IF  ADMIN PASSWORD EXISTS */
        if(!$this->checkAdminPass($admin_password))
        {
            return "wrong admin password!";
        }

        if(!$this->checkShopkeeper($shopkeeper_username))
        {
            return "existing username";
        }

        /* Add new shop keeper */
        $str_sql = "INSERT INTO shopkeeper(firstname, lastname, shopkeeper_username, shopkeeper_password, address, phone, email,
 sex) VALUES ('$firstname', '$lastname','$shopkeeper_username', '$shopkeeper_password', '$address', '$phone', '$email', '$sex')";

        return $this->query($str_sql);
    }

    function addAdmin($firstname, $lastname, $email, $admin_username, $admin_password, $other_admin_password)
    {
        /* SEARCH IF  ADMIN PASSWORD EXISTS */
        if(!$this->checkAdminPass($other_admin_password))
        {
            return "wrong existing admin password!";
        }

        /* Add new Admin */
        $str_sql = "INSERT INTO shopadmin (firstname, lastname, email, admin_username, admin_password) VALUES
('$firstname', '$lastname', '$email', '$admin_username', '$admin_password')";

        return $this->query($str_sql);
    }

    function signInShopkeeper($shopkeeper_username, $shopkeeper_password)
    {
        $str_sql = "SELECT * FROM shopkeeper WHERE shopkeeper_username = '$shopkeeper_username' AND
shopkeeper_password = '$shopkeeper_password' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
         return false;
        }

        /* set sessions */
        $_SESSION['user_type'] = "shopkeeper";
        $_SESSION['username'] = $shopkeeper_username;
        $_SESSION['password'] = $shopkeeper_password;

        return true;
    }

    function signInAdmin($admin_username, $admin_password)
    {
        $str_sql = "SELECT * FROM shopadmin where admin_username = '$admin_username' AND admin_password = '$admin_password' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }

        /*se sessions */
        $_SESSION['user_type'] = "admin";
        $_SESSION['username'] = $admin_username;
        $_SESSION['password'] = $admin_password;

        return true;
    }

    function checkShopkeeper($shopkeeper_username)
    {
        $str_sql = "SELECT * FROM shopkeeper where shopkeeper_username = '$shopkeeper_username' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }

    function checkAdmin($admin_username)
    {
        $str_sql = "SELECT * FROM shopadmin where admin_username = '$admin_username' limit 0,1";
        $this->query($str_sql);
        if($this->fetch() == null)
        {
            return false;
        }
        return true;
    }



    }

