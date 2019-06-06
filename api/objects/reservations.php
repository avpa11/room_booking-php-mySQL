<?php
class Reservations{
    private $table_name = "reservations";
 
    // object properties
    public $id;
    public $stud_name;
    public $room_number;
    public $description;
    public $number_of_people;
    public $date;
    public $start_time;
    public $end_time;


    //this function will be extensively used to build the proper display of already booked reservations
    //for specific time regions
    function getReservationTimeArrayAsInteger(){
        //setting variables;
        //$dateformat = 'H:i:s';
        $int_start_time;
        $int_duration = strtotime($this->end_time) - strtotime($this->start_time);
        $int_duration = (int)date('h', $int_duration);
        //$reservationTimeArray = array($this->start_time, $this->end_time);

        //first switch case function will convert all possible bookings to integer value
        switch($this->start_time){
            case '9:00:00':
                $int_start_time = 0;
                break;
            case '10:00:00':
                $int_start_time = 1;
                break;
            case '11:00:00':
                $int_start_time = 2;
                break;
            case '12:00:00':
                $int_start_time = 3;
                break;
            case '13:00:00':
                $int_start_time = 4;
                break;
            case '14:00:00':
                $int_start_time = 5;
                break;
            case '15:00:00':
                $int_start_time = 6;
                break;
            case '16:00:00':
                $int_start_time = 7;
                break;
            case '17:00:00':
                $int_start_time = 8;
                break;
        }

        //by the end of this switch case we have array which will have exactly 2 values inside
        //the problem is if smbd booked for more than 1 hour the array will be missing these intermediate value
        // EXAMPLE: Booking from 15:00 to 18:00 will result in array value of [6,9];
        //the next step is we need to fill up missing values;

        for($i = $int_start_time; $i < ($int_start_time + $int_duration); $i++){
            $int_reservationTimeArray[] = $i;
        }
        

        //after this we have array which can look as [6,9,7,8];
        //the array is not sorted, so we better sort it before we pass it back


        sort($int_reservationTimeArray);

        return $int_reservationTimeArray;


    }


    //this function will be extensively used to build the proper display of already booked reservations
    //for presenting reservations just for one week
    




}



?>