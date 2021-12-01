<?php

namespace App\Models;
use mysqli;
class BaseModel
{
    protected static $fillable = [];//хранится набор атрибутов которые хранятся в БД
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

    public function save(){
        $connection = self::getConnection();
        $tableName= static::getTableName();

        if (isset($this->id) && !empty($this->id)){
            $values = [];

            foreach (static::$fillable as $attributeName) {
                $values[] = $attributeName.' = '.'"'.$this->{$attributeName}.'"';
            }

            $values = implode(', ', $values);
            $sql = "UPDATE {$tableName} SET {$values} WHERE id = {$this->id}";
            $connection->query($sql);//update

        } else {
            $fields = implode(',', static::$fillable);
            $values = [];

            foreach (static::$fillable as $attributeName){
                $values[] = $this->{$attributeName} ?? null;
            }

            $values = "'".implode("' , '", $values)."'";
            $sql = "INSERT into {$tableName} ({$fields}) VALUES ({$values})";
            $connection->query($sql);

            if ($connection->insert_id){
                $this->id = $connection->insert_id;
            }
        }

    }
}