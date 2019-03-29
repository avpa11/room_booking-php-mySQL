<?php
// include database and object files

include_once '../config/database.php';
include_once '../user/PDOAgent.class.php';
include_once '../user/reservation.php';
 
$resev = new reservation();

function heading() { ?>
  
  <!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Admin Page</title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/welcome.css" />
  <link rel="stylesheet" href="../../assets/css/reservation.css" />
  
</head>
<body>
<nav class="navbar navbar-light" style="background-color: #754343;">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Welcome, librarian!</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="../../index.html"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
    </ul>
  </div>
</nav>

<?php
}?>

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
  <table class="table ">
    <thead>
      <tr>
        <th>Reservation #</th>
        <th>Student Username</th>
        <th>Room Type</th>
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
        <TD>'.$r->username.'</TD>
        <TD>'.$r->type.'</TD>
        <TD>'.$r->description.'</TD>
        <TD>'.$r->number_of_people.'</TD>
        <TD>'.$r->date.'</TD>
        <TD>'.$r->start_time.'</TD>
        <TD>'.$r->end_time.'</TD>
        <TD><a id="update" href = "update.php">Update</a></TD>
        <TD><a id="delete" href = "?action=delete&reservation_id='.$r->reservation_id.'">Delete</a></TD>
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

heading();

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