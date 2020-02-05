<?php
namespace Areuka\App;

class Validator {
    // new Validator(["name" => "김민재"], ["name" => "korean, name-max"], ["name.korean" => "한글만 가능", "name.name-max" => "3자까지만 가능"])

    function __construct(array $inputs, array $rules, array $errors){
        $this->inputs = $inputs;
        $this->rules = $rules;
        $this->errors = $errors;
        $this->result = [];
    }

    function check(){
        foreach($this->inputs as $key => $value){
            // 이 과제에선 모든 값이 무조건 존재해야함
            $this->require($key, $value);

            if(isset($this->rules[$key])) {
                // 분할
                $rules = explode(",", $this->rules[$key]);
                foreach($rules as $rule){
                    $ruleName = trim($rule);
    
                    // rules과 키가 같은 요소를 이름으로한 메소드가 있는지 확인
                    $existMethod = is_callable([$this, $ruleName]);
    
                    if($existMethod){
                        $this->{$ruleName}($key, $value);
                    }
                }
            }
        }
        return $this;
    }

    function execute(...$message){
        $this->result = array_merge($this->result, $message);
        if(count($this->result) > 0){   // 에러 메세지가 1개 이상이면
            back($this->result);
        }
    }

    /**
     * Types
     */
    function require($key, $value){
        if($value !== null ){
            if((gettype($value) === "string" && $value === "") || (is_array($value) && $value['tmp_name'] === ""))
                $this->result[] = $this->errors[$key];
        }
    }

    function number($key, $value){
        if(!preg_match("/^([0-9]+)$/", $value)){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }

    function email($key, $value){
        if(!preg_match("/^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,4})$/", $value)){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }

    function image($key, $value){
        if(!isset($value['type']) || strncmp($value['type'], "image", 5) !== 0){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }

    function donation_unit($key, $value){
        if($value === "" || $value / 10000 !== 0){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }

    function donation_min($key, $value){
        if($value < 1000000){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }       
    }

    function business_id($key, $value){
        if(!preg_match("/^[0-9]{3}-[0-9]{2}-[0-9]{5}$/", $value)){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }
    
    function timetable($key, $value){
        if(!preg_match("/^[0-9]{1,2}:[0-5][0-9]$/", $value)){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }

    function seat($key, $value){
        if(!preg_match("/^[0-9][A-Z]$/", $value)){
            $this->result[] = $this->errors[$key.".". __FUNCTION__];
        }
    }

    function seat_file($key, $value){
        if(isset($value['tmp_name'])){
            extract($value);
            $content = file_get_contents($tmp_name);
    
            if(!$type || strncmp($type, "text", 4) !== 0){
                $this->result[] = $this->errors[$key.".". __FUNCTION__];
                return;
            }
            if(!$name || strncmp(substr($name, -3), "txt", 3) !== 0){
                $this->result[] = $this->errors[$key.".". __FUNCTION__];
                return;
            }

            $map = explode("\r\n", $content);
            $length = strlen(trim($map[0]));

            
            for($i = 1; $i < count($map); $i++){
                $row = $map[$i];

                // 가로 세로 길이가 다를 경우
                if(strlen($row) !== $length){
                    $this->result[] = $this->errors[$key.".". __FUNCTION__];
                    return;
                }

                // 0~3외의 문자가 있을 경우
                if(preg_match("/([^0-3]+)/", $row, $matches)){
                    $this->result[] = $this->errors[$key.".". __FUNCTION__];
                    return;
                }
            }
        }
    }
}