<?php
// include database and object files

include_once '../config/database.php';
include_once '../user/PDOAgent.class.php';
include_once '../user/reservation.php';
 
$resev = new reservation();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Admin Page</title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
  <link rel="stylesheet" href="./assets/css/style.css">
  
</head>
<body>
  <?php

function listReservations($reservation){
  ?>



  <h1>Manage reservations</h1>

  <?php
  if ($reservation == null) {
    ?>
    <div>
      <h2>There are no records in the database</h2>
    </div>
    <?php
  }

  else{
  ?>
  <table class="table">
    <thead>
      <tr>
        <th>Reservation #</th>
        <th>Student ID</th>
        <th>Room ID</th>
        <th>Description</th>
        <th>Number of People</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($reservation as $r)    {
        echo '<TR>
        <TD>'.$r->reservation_id.'</TD>
        <TD>'.$r->stud_id.'</TD>
        <TD>'.$r->room_id.'</TD>
        <TD>'.$r->description.'</TD>
        <TD>'.$r->number_of_people.'</TD>
        <TD>'.$r->date.'</TD>
        <TD>'.$r->start_time.'</TD>
        <TD>'.$r->end_time.'</TD>
        <TD><a href = "update.php">Update</a></TD>
        <TD><a href = "?action=delete&reservation_id='.$r->reservation_id.'">Delete</a></TD>
        </TR>';
      }
    }
      ?>
    </tbody>

  </table>  
  
</body>
</html>
<?php
}


if (empty($_GET))
{

  listReservations($resev->read());
}

else if (isset($_GET['action']))
{
  switch ($_GET['action'])
  {
    case 'delete':
    $resev->delete($_GET['reservation_id']);
    listReservations($resev->read());
    break;
  }
}
?>