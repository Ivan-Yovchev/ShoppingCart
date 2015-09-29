<?php

namespace Lib;

class Auth {

    private static $is_logged_in = false;
    private static $logged_user = array();

    private function __construct(){
        session_set_cookie_params(1800, "/");
        session_start();

        if(!empty($_SESSION['user'])){
            self::$is_logged_in = true;
            self::$logged_user = $_SESSION['user'][0];
        }
    }

    public static function get_instance(){
        static $instance = null;

        if(null === $instance){
            $instance = new static();
        }

        return $instance;
    }

    public function is_logged_in(){
        return self::$is_logged_in;
    }

    public function get_logged_user(){
        return self::$logged_user;
    }

    public function clean_auth(){
        self::$is_logged_in = false;
        self::$logged_user = array();
    }
}