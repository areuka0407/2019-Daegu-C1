<?php
namespace Areuka\App;

class Router {
    static $pageList = [];
    static function connect(){
        $current_url = explode("?", $_SERVER['REQUEST_URI'])[0];
        
        foreach(self::$pageList as $page){
            // 각 페이지마다 인수를 분리시킨다.
            $regex = preg_replace("/\//", "\\/", $page->url);
            $regex = preg_replace("/{([^\/]+)}/", "(?<$1>[^\/]+)", $regex);

            if(preg_match("/^{$regex}$/", $current_url, $matches)){
                unset($matches[0]);
                
            }
        }
    }

    static function __callStatic($name, $args){
        if(strtolower($_SERVER['REQUEST_METHOD']) === strtolower($name))
            self::$pageList[] = (object)["url" => $args[0], "action" => $args[1]];
    }
}