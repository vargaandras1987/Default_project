<?php

namespace core\database;

use mysqli;

class MysqlClass
{
    private $_host;
    private $_username;
    private $_password;
    private $_database;
    private $_connection;

    function __construct($db)
    {
        $this->_host = constant($db . '_DB_HOST');
        $this->_username = constant($db . '_DB_USER');
        $this->_password = constant($db . '_DB_PASS');
        $this->_database = constant($db . '_DB_NAME');

        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);

        if ($this->_connection->connect_errno) {
            die ('Adatbáziskapcsolati hiba' . $this->_connection->error);
        }

    }

    public function query($query)
    {
        return $this->_connection->query($query);
    }

    public function escape_string($str)
    {
        return $this->_connection->escape_string($str);
    }
}