<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "students";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // login user
    function login(){
        // select all query
        $query = "SELECT
                    id, username, password, created
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
}