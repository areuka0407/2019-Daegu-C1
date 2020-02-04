<?php
namespace Areuka\App;

class Session {
    public function has($key){
        return isset($_SESSION[$key]);
    }

    public function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public function get($key, $save = false){
        if($this->has($key)){
            $returned = $_SESSION[$key];

            if($save == false){
                unset($_SESSION[$key]);
            }
            return $returned;
        }
        else return false;
    }

    public function unset($key){
        unset($_SESSION[$key]);
    }
}