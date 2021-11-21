<?php

namespace App\Models;
use mysqli;
class BaseModel
{
    protected static $tableName;
    protected static $connection;
//одно подключение к БД
    protected static function getConnection(){
        if (!self::$connection){
            self::$connection = new mysqli('localhost', 'root', '', 'mvc');
        }
        return self::$connection;
    }

    protected static function getTableName(){
        if (empty(static::$tableName)){
            $className = static::class;
            $className = explode('\\', $className);
            $className = array_pop($className);
            $className = strtolower($className);
            $tableName = $className."s";
        }
        else {
            $tableName = static::$tableName;
        }
        return $tableName;
    }
    public static function selectAll(){
        $connection = self::getConnection();
        $tableName = static:: getTableName();
        $res = $connection->query("SELECT * FROM ".$tableName);
        $arr = [];
        while ($row = $res->fetch_object(static::class)){
            $arr = $row;
        }
        return $arr;

    }
public static function findById($id){
    /**
     * @var mysqli $connection
     */
    $connection = self::getConnection();
    $sql = "select * from ".(static:: getTableName())." where id = ?";
    $smth = $connection->prepare($sql);//prepare обязательно в переменной
    $smth->bind_param('i', $id);// вместо ? подставлять конкретные данные 2 обязательных параметра 1-й- тип (какой должен быть s-string в порядке как в запросе
    $smth->execute();
    $result = $smth->get_result();
    return $result->fetch_object(static::class);//ожидаеем только одну запись поэтому assoc //static class для всех наследников

}

}