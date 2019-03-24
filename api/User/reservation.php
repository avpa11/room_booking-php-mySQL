<?php

class reservation    
{
    //Attributes
    public $lastInsertId = null;

    // Function which lists all players IF NO SEARCH TERMS WERE INPUT
    function read() {
        
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //Setup the Bind Parameters
        $bindParams = [];

        //Get the results of the insert query (rows inserted)
        $results = $p->query("SELECT * FROM reservation;", $bindParams);

        //Disconnect from the database
        $p->disconnect();
        
        //Return the objects
        return $results;
    }

    // Function which deletes the selected player
    function delete($reservation_id)   
    {        
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //Setup the Bind Parameters
        $bindParams = ["reservation_id" => $reservation_id];
        
        //Get the results of the insert query (rows inserted)
        $results = $p->query("DELETE FROM reservation WHERE reservation_id = :reservation_id;", $bindParams);
        
        //Disconnect from the database
        $p->disconnect();

        // IF the query "did not work"
        if ($p->rowcount != 1)  {
            trigger_error("An error has occured");
            die();
        }
        else
        { 
            
        }
    }
    
}

?>