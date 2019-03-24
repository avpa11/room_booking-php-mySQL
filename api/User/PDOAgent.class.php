<?php

class PDOAgent {

    // Attributes
    private $dsn = "";
    private $dbuser = "";
    private $dbpass = "";
    
    public $rowcount;
    public $pdo;
    public $lastInsertId = null;

    // Constructor for the PDO
    function __construct($dbtype, $user, $pass, $host, $db) {
        //Build the DSN for conenction
        $this->dsn = $dbtype.":host=".$host.";dbname=".$db;

        //Username and password credentials
        $this->dbuser = $user;
        $this->dbpass = $pass;
    }

    // toString method
    function __toString()   {
        return "DSN: ".$this->dsn." ";
    }

    // Function which connects to the database
    function connect()  {
        try {
            $this->pdo = new PDO($this->dsn, $this->dbuser, $this->dbpass);
        } catch (Exception $ex) {
            echo "Error connecting to the database:".$ex->getMessage();
        }
    }

    // Function which prepares queries, binds parameters and executes them
    function query($strQuery, $bindParams) {
        try 
        {
            $stmt = $this->pdo->prepare($strQuery);
            $stmt->execute($bindParams);
        } 
        catch (Exception $ex) 
        {
            echo "Error Executing Query:".$ex->getMessage();
        }
        
        $resultset = null;

        while ($result =  $stmt->fetch(PDO::FETCH_OBJ)) 
        {
            $resultset[] = $result;
        }
        
        //Update the rowcount
        $this->rowcount = $stmt->rowcount();
        //Update the last inserted id
        $this->lastInsertId = $this->pdo->lastInsertId();
        
        //Return the resultset
        return $resultset;
       
    }

    // Function which disconnects from the database
    function disconnect()   {
        try {
            $this->db = null;
        } catch (Exception $ex) {
            echo "Error Disconnect: ".$ex->getMessage();
        }
    }
        
}
?>