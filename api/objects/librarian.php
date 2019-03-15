<?php
class Librarian{
 
    // database connection and table name
    private $conn;
    private $table_name = "librarians";
 
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
                    lib_id, lib_username, lib_password, lib_created
                FROM
                    " . $this->table_name . " 
                WHERE
                    lib_username='".$this->username."' AND lib_password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
}