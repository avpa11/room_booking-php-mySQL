<?php
include_once '../objects/room.php';
include_once 'PDOAgent.class.php';

class RoomController{
    private $table_name = "room";
 
    function read() {
        
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //Setup the Bind Parameters
        $bindParams = [];

        //Get the results of the insert query (rows inserted)
        $results = $p->query("SELECT * FROM room", $bindParams);

        //Disconnect from the database
        $p->disconnect();
        
        //Return the objects
        $rooms = array();

        foreach($results as $row)   {
            $room = new Room();
            $room->id = $row->room_id;
            $room->type = $row->type;
            $room->capacity = $row->capacity;
            $room->floor = $row->floor;
            $room->room_number = $row->room_number;

            $rooms[] = $room;
        }
        

        return $rooms;
    }



}



?>