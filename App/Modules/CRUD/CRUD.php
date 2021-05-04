<?php

class CRUD
{
    public $db;

    public function __construct($host, $login, $password, $name)
    {
        $this->db = new MysqliDb($host, $login, $password, $name);
    }

    public function insert(){}
}