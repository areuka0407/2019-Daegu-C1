<?php
namespace Areuka\App;

function session(){
    return new Session();
}

function user(){
    return new User();
}

function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    call_user_func_array("dump", func_get_args());
    exit;
}

function redirect($url, $message = null){
    header("Location: {$url}");
    $message !== null && session()->set("message", $message);
}
