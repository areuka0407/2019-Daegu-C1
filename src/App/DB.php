<?php
namespace Areuka\App;

class DB {
    static $ctx = null;
    
    static function takeDB(){
        if(self::$ctx === null){
            self::$ctx = new \PDO("mysql:host=localhost;dbname=biff3;charset=utf8mb4", "root", "");
        }

        return self::$ctx;
    }

    static function query($sql, $data = []){
        $q = self::takeDB()->prepare($sql, $data);
        $q->execute($data);
        return $q;
    }

    static function fetch(){
        return self::query(...func_get_args())->fetch(\PDO::FETCH_OBJ);
    }

    static function fetchAll(){
        return self::query(...func_get_args())->fetchAll(\PDO::FETCH_OBJ);
    }

    static function find($table, $id){
        return self::fetch("SELECT * FROM $table WHERE id = ?", [$id]);
    }

    static function lastInsertId(){
        return self::takeDB()->lastInsertId();
    }
}