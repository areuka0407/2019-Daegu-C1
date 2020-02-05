<?php
namespace Areuka\Controller;

class MasterController {
    function __construct(){
        define("CACHE", SRC.DS."Caches");
        define("VIEW", SRC.DS."Views");
    }

    function view($pageName, $data = []){
        $normal = session()->get("segment", true)[0] !== "admin";
        
        if($normal){
            $this->decode("template/header");
            $this->require("template/header", $data);
        }
        else {
            $this->decode("template/admin-header");
            $this->require("template/admin-header", $data);
        }
        $this->decode("$pageName");
        $this->require("$pageName", $data);

        if($normal){
            $this->decode("template/footer");
            $this->require("template/footer", $data);
        }
    }

    function decode($pageName){
        $pageName = str_replace("/", DS, $pageName);
        $pageName = str_replace(".", DS, $pageName);

        $input_path = VIEW.DS.$pageName.".php";
        $output_path = CACHE.DS.$pageName.".php";
        
        if(is_file($output_path))  
            $makeTime = filemtime($output_path);    // 캐시가 이미 존재한다면 
                                                    // 생성된 시간을 가져온다.
        else 
            $makeTime = false;                      // 없다면 FALSE

        
        // 캐시가 생성된 적이 없거나, 원본보다 이전 데이터라면 덮어쓴다.
        if($makeTime === FALSE || $makeTime < filemtime($input_path)){
            $content = file_get_contents($input_path);
            
            // 정규식으로 블레이드 문법을 허용한다.
            $content = preg_replace("/@(if|for|foreach|while|elseif)\((.+)\)/", "<?php $1 ($2): ?>", $content);
            $content = preg_replace("/@(endif|endforeach|endfor|endwhile)/", "<?php $1; ?>", $content);
            $content = preg_replace("/@php/", "<?php", $content);
            $content = preg_replace("/@endphp/", "?>", $content);
            $content = preg_replace("/{{([^{}]+)}}/", "<?= $1 ?>", $content);


            // 데이터를 저장한다.
            $dirname = dirname($output_path);
            if(!is_dir($dirname)){
                mkdir($dirname, 0777, true);
            }
            file_put_contents($output_path, $content);
        }
    }

    function require($pageName, $data){
        $pageName = str_replace("/", DS, $pageName);
        $pageName = str_replace(".", DS, $pageName);

        $target = CACHE.DS.$pageName.".php";
        if(is_file($target)){
            extract($data);
            require_once($target);
        }
    }
}