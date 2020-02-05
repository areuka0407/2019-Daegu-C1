<?php
function session(){
    return new Areuka\App\Session();
}

function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}

function redirect($url, $message = null, $background = "bg-danger"){
    header("Location: {$url}");
    $message !== null && session()->set("message", [$message, $background]);
    exit;
}

function back($message = null, $background = "bg-danger"){
    $url = $_SERVER["HTTP_REFERER"];
    header("Location: {$url}");
    $message !== null && session()->set("message", [$message, $background]);
    exit;
}

function json_response($message, $success, $anything = []){
    $data = ["message" => $message, "success" => $success];
    header("Content-Type: application/json");
    echo json_encode(array_merge($data, $anything), JSON_UNESCAPED_UNICODE);
}

function checkUp(){
    foreach($_POST as $input){
        if(trim($input) === ""){
            back("모든 정보를 기재해 주세요!");
        }
    }
    return false;
}

function isLogin(){
    return session()->has("login");
}

function random_varchar($length = 30){
    $string = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
    $result = "";
    for($i = 0; $i < $length; $i ++){
        $result .= $string[random_int(0,  strlen($string) - 1)];
    }
    return $result;
}

function time_format($number){
    $hour = floor($number / 60);
    $min = $number % 60;
    return ($hour > 0 ? "{$hour}시간 " : "")."${min}분";
}

function time2minute(string $time){
    if(!preg_match("/^(?<hour>[0-9]{1,2}):(?<minute>[0-5][0-9])$/", $time, $matches)) return null;
    return (int)$matches['hour'] * 60 + (int)$matches['minute'];
}