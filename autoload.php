<?php

function classLoader($className){
    $basePath = SRC.DS;
    $prefix = "Areuka";
    $prefixLength = strlen($prefix);

    $className = str_replace("\\", DS, $className);

    // 접두사가 일치하면...
    if(strncmp($prefix, $className, $prefixLength) === 0){
        $className = substr($className, $prefixLength);
        $classPath = $basePath . $className . ".php";
        if(is_file($classPath)){
            require $classPath;
        }
    }
}


spl_autoload_register("classLoader");