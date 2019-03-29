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
        $results = $p->query("SELECT reservation_id, username, type, description, number_of_people, date, start_time, end_time
        FROM reservation 
        JOIN students
        ON students.id = reservation.stud_id
        JOIN room
        ON room.room_id = reservation.room_id;", $bindParams);

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