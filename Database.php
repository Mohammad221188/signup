<?php

class Database {
    protected $server   = 'localhost';
    protected $username = 'root';
    protected $password = '';
    protected $dbname   = 'employee_manager_dbs';

    public $salt= "asdfasfdasdf23453567567727
    1+§$%&///%&$%&";
    public $connection;

    public function __construct() {
        $this->connection = new mysqli($this->server, $this->username, $this->password, $this->dbname);
        if($this->connection->connect_error){
           die("connection ist gescheitert".$this->connection->connect_error); 
        }
    }
    
}