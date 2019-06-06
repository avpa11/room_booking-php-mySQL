<?php
include_once '../objects/reservations.php';
include_once 'PDOAgent.class.php';
class reservation    
{
    //Attributes
    public $lastInsertId = null;

    // function to read the tables
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

    // function to delete the selected player
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

    function listOne($reservation_id)
    {
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //Setup the Bind Parameters
        $bindParams = ['reservation_id' => $reservation_id];

        //Get the results of the insert query (rows inserted)
        $results = $p->query("SELECT * FROM reservation WHERE reservation_id = :reservation_id;", $bindParams);

        //Disconnect from the database
        $p->disconnect();
        
        //Return the objects
        return $results;
    }


    function update($postdata) 
    {        
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //Setup the Bind Parameters
       $bindParams = ["reservation_id" => $postdata['reservation_id'],
       //"stud_id" => $postdata['stud_id'],
       //"room_id" => $postdata['room_id'],
       "description" => $postdata['description'],
       "number_of_people" => $postdata['number_of_people'],
       "date" => $postdata['date'],
       "start_time" => $postdata['start_time'],
       "end_time" => $postdata['end_time']];

        //Get the results of the insert query (rows inserted)
       $results = $p->query("UPDATE reservation SET description = :description, number_of_people = :number_of_people, date = :date, start_time = :start_time, end_time = :end_time WHERE reservation_id = :reservation_id;", $bindParams);
       
       //Disconnect from the database
        $p->disconnect();
        
        // IF the query "did not work"
        if ($p->rowcount != 1)  {
            trigger_error("An error has occured");
            die();
        }
        else
        { 
            header('Location: ../user/admin.php');
        }

    }

    function search($term) 
    {
        $newTerm = "%".$term."%";

        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //Setup the Bind Parameters
        $bindParams = ["term"=>$newTerm];
        
        //Get the results of the insert query (rows inserted)
        $results = $p->query("SELECT * FROM reservation
        JOIN students
        ON students.id = reservation.stud_id
        JOIN room
        ON room.room_id = reservation.room_id
        WHERE username LIKE :term OR
        first_name LIKE :term OR last_name LIKE :term OR email LIKE :term OR
        phone LIKE :term OR type LIKE :term
        OR capacity LIKE :term OR description LIKE :term
        OR floor LIKE :term OR number_of_people LIKE :term
        OR room_number LIKE :term OR date LIKE :term
        OR end_time LIKE :term OR start_time LIKE :term;", $bindParams);
              
        //Disconnect from the database
        $p->disconnect();
        
        //Return the objects
        return $results;
    }


    //////////////////////////////////
    // FUNCTIONS FOR USERS USING BOOKING
    /////////////////////////////////

    function listCurrentReservations()
    {
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        //WE NEED TO SPECIFY DATE FORMATS!!! FOR SQL TO READ
        $format = 'Y-m-d H:i:s'; 


        $date = date($format);
        
        

        //WE NEED current date plus one week
        $datePlusWeek = date($format, strtotime("+1 week"));

        //Setup the Bind Parameters
        $bindParams = [
            'date' => $date,
            'date_weekPlus' => $datePlusWeek
        ];

        //Get the results of the insert query (rows inserted)
        $results = $p->query("SELECT reservation_id, first_name, room_number, description, number_of_people, date, start_time, end_time
        FROM reservation 
        JOIN students
        ON students.id = reservation.stud_id
        JOIN room
        ON room.room_id = reservation.room_id WHERE date > :date AND date < :date_weekPlus", $bindParams);

        //Disconnect from the database
        $p->disconnect();
        
        //Return the objects
        $reservations = array();

        foreach($results as $row)   {
            $reservation = new Reservations();
            $reservation->id = $row->reservation_id;
            $reservation->stud_name = $row->first_name;
            $reservation->room_number = $row->room_number;
            $reservation->description = $row->description;
            $reservation->number_of_people = $row->number_of_people;
            $reservation->date = $row->date;
            $reservation->start_time = $row->start_time;
            $reservation->end_time = $row->end_time;

            $reservations[] = $reservation;
        }

        return $reservations;
    }

    function createNewReservation($reservation){
        //new PDOAgent
        $p = new PDOAgent("mysql", "root", "", "localhost", "test");

        //Connect to the Database
        $p->connect();

        $bindParams = [
            'stud_id' => $reservation->stud_name,
            'room_id' => $reservation->room_number,
            'description' => $reservation->description,
            'number_of_people' => $reservation->number_of_people,
            'date' => $reservation->date,
            'start_time' => $reservation->start_time,
            'end_time' => $reservation->end_time
        ];

        $result = $p->query("INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time)
        VALUES(:stud_id, :room_id, :description, :number_of_people, :date, :start_time, :end_time)", $bindParams);

        $p->disconnect();
    }
    
}

?>