<?php

namespace core\database;

use Exception;
use PDO;
use PDOException;

class PdoClass
{
    private $_host;
    private $_username;
    private $_password;
    private $_database;
    private $pdo;

    function __construct($db)
    {
        $this->_host = constant($db . '_DB_HOST');
        $this->_username = constant($db . '_DB_USER');
        $this->_password = constant($db . '_DB_PASS');
        $this->_database = constant($db . '_DB_NAME');


        // Set DSN
        $dsn = 'mysql:host=' . $this->_host . ';dbname=' . $this->_database;

        // Create a new PDO instanace
        try {
            $this->pdo = new PDO($dsn, $this->_username, $this->_password);
        } catch (PDOException $e) {
            throw new Exception('Adatbázis kapcsolódási hiba!' . $e->getMessage());
        }
    }

    public function prepare($query){
        return $this->pdo->prepare($query);
    }

    public function insert($tableName, $tableItems)
    {
        $query = "INSERT INTO " . $tableName . " (" . implode(', ', array_keys($tableItems)) . ") VALUES (:" . implode(", :", array_keys($tableItems)) . ")";
        $this->pdoRun($query, $tableItems);
    }

    public function lastIndexId(){
        return $this->pdo->lastInsertId();
    }

    private function pdoRun($query, $tableItems = array(), $tableItemsTwo = array())
    {
        try {
            $stmt = $this->pdo->prepare($query);

            $this->bindValueFromarray($tableItems, $stmt);
            $this->bindValueFromarray($tableItemsTwo, $stmt);

            $stmt->execute();
            return $stmt;
        } catch (PDOException $exception) {
            throw new PDOException("PDO hiba!" . $exception->getMessage());
        }
    }

    private function bindValueFromarray($bindArray, $stmt)
    {
        if (!empty($bindArray)) {
            foreach ($bindArray as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
        }
    }

    public function update($tableName, $setArray, $whereArray)
    {
        $query = "UPDATE " . $tableName . " SET " . implode(', ', $this->arrayTransformation($setArray)) . " WHERE " . implode('AND ', $this->arrayTransformation($whereArray));

        $this->pdoRun($query, $setArray, $whereArray);
    }

    private function arrayTransformation($passArray)
    {
        $str = array();
        foreach ($passArray as $key => $value) {
            array_push($str, $key . " =:" . $key);
        }
        return $str;
    }

    public function select($query,$items){

        $stmt = $this->pdoRun($query,$items);
        try {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception){
            throw new PDOException("Eredmény visszaadása sikertelen.".$exception->getMessage());
        }
        return $result;
    }
}

