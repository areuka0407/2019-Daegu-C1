<?php
namespace Areuka\App;

class Session {
    public has($key){
        return isset($_SESSION[$key]);
    }

    public set($key, $value){
        $_SESSION[$key] = $value;
    }

    public get($key, $save = false){
        if($this->has($key)){
            $returned = $_SESSION[$key];

            if($save === false){
                $_SESSION[$key];
            }
            return $returned;
        }
        else return false
    }
}