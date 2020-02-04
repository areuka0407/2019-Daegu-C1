<?php
namespace Areuka\App;

class Router {
    static $pageList = [];

    static function takeURL(){
        return explode("?", $_SERVER['REQUEST_URI'])[0];
    }


    static function connect(){
        $current_url = self::takeURL();
        
        $segment = explode("/", substr(Router::takeURL(), 1));
        session()->set("segment", $segment == "" ? "home" : $segment);
        
        foreach(self::$pageList as $page){
            // 페이지에 적힌 이름을 인수로 사용할 수 있도록 정규식화 시킨다.
            $regex = preg_replace("/\//", "\\/", $page->url);
            $regex = preg_replace("/{([^\/]+)}/", "([^\/]+)", $regex);

            // 정규식을 통해 현재 URL과 일치하는 페이지가 있는지 찾는다.
            if(preg_match("/^{$regex}$/", $current_url, $matches)){
                if($segment[0] === "admin" && isLogin() === false) redirect("/login", "관리자만 접근가능합니다.");

                unset($matches[0]);
                $split = explode("@", $page->action);
                $className = "Areuka\\Controller\\".$split[0];
                $method = $split[1];
                $class = new $className();
                $class->{$method}(...$matches);
                exit;
            }
        }

        redirect("/", "페이지를 찾을 수 없었습니다...");
    }

    static function __callStatic($name, $args){
        if(strtolower($_SERVER['REQUEST_METHOD']) === strtolower($name))
            self::$pageList[] = (object)["url" => $args[0], "action" => $args[1]];
    }
}