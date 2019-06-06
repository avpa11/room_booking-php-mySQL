<?php
// include database and object files

include_once '../config/database.php';
include_once '../user/PDOAgent.class.php';
include_once '../user/reservation.php';
 
$resev = new reservation();

// function for html haed and nav
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
  <script src="../../assets/js/monthlycalendar.js"></script>  
  
</head>
<body>
<nav class="navbar navbar-light" style="background-color: #754343;">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href="admin.php">Welcome, librarian!</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="../../index.html"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
    </ul>
  </div>
</nav>
<div class="container">

  <h1 id="click_for_stats">For your monitoring...</h1>
  <div id="monitor">
    <div id="calendar">
    </div>

    <div id="stats">
      <h2>Search</h2>
      <?php searchForm(); ?>
    </div>
  </div>

  <script>

  document.getElementById("calendar").innerHTML = createCalendar(curDay);

    //slide Toggle to hide/show monitoring menu
    $(document).ready(function(){
      $("#click_for_stats").click(function(){
        $("#monitor").slideToggle();
      });
    });

  </script>

<?php
}?>

  <?php
// function that creates the table based on the db reading
function listReservations($reservation){
  ?>


  <?php
  if ($reservation == null) {

    if (!empty($_GET['search']))
            {
                ?>
                <div class="box content">
                    <H5>No results found for "<?php echo $_GET['search']; ?>"</H5>
                </div>
            <?php
            }
            else
            {
                ?>
                <div class="box content">
                    <H5>No reservations in the database</H5>
                </div>
                <?php
            }
  }

  else{
  ?>
  <table class="table ">
    <caption>Manage reservations</caption>
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
        <TD><a id="update" href = "?action=update&reservation_id='.$r->reservation_id.'">Update</a></TD>
        <TD><a id="delete" href = "?action=delete&reservation_id='.$r->reservation_id.'">Delete</a></TD>
        </TR>';
      }
    }
      ?>
    </tbody>

  </table>  
  </div>
</body>
</html>
<?php
}

function updateReservation($reservation)
    {

      $resev = new reservation();

        // Verifies if there is any POST data
        if (!empty($_POST))
        {
            // Verifies if the ENTIRE FORM was filled in, and if so, creates the new reservation
            if (!empty($_POST['reservation_id']) && !empty($_POST['description']) && !empty($_POST['number_of_people'])
            && !empty($_POST['date']) && !empty($_POST['start_time']) && !empty($_POST['end_time']))
            {
              $resev->update($_POST); 
            }
        }

        // Creates an array from which to get the reservation's data
        foreach ($reservation as $attribute)
        {
            $myReservation = ['reservation_id' =>$attribute->reservation_id,
            //'stud_id'=>$attribute->stud_id,
            //'room_id'=>$attribute->room_id,
            'description'=>$attribute->description,
            'number_of_people'=>$attribute->number_of_people,
            'date'=>$attribute->date,
            'start_time'=>$attribute->start_time,
            'end_time'=>$attribute->end_time];
        }
        ?>
        <div class="box content">
        <FORM METHOD="POST" ACTION="">
            <DIV CLASS="form-group">
                <INPUT TYPE="hidden" NAME="reservation_id" ID="reservation_id" VALUE="<?php echo $myReservation['reservation_id'] ?>" />
                <LABEL FOR="description">Description</LABEL>
                <INPUT TYPE="text" CLASS="form-control" NAME="description" ID="description" ARIA-DESCTIBEDBY="description_help" VALUE = "<?php echo $myReservation['description']; ?>">
            </DIV>

            <DIV CLASS="form-group">
                  <LABEL FOR="number_of_people">Number of People</LABEL>
                  <INPUT TYPE="text" CLASS="form-control" NAME="number_of_people" maxlength="1" ID="number_of_people" ARIA-DESCTIBEDBY="number_of_people_help" VALUE = "<?php echo $myReservation['number_of_people']; ?>">
            </DIV>

            <DIV CLASS="form-group">
                <LABEL FOR="date">Date</LABEL>
                <INPUT TYPE="date" CLASS="form-control" NAME="date" ID="date" ARIA-DESCTIBEDBY="date_help" VALUE = "<?php echo $myReservation['date']; ?>">
            </DIV>

            <DIV CLASS="form-group">
                  <LABEL FOR="start_time">Start Time</LABEL>
                  <INPUT TYPE="text" CLASS="form-control" NAME="start_time" ID="start_time" ARIA-DESCTIBEDBY="start_time_help" VALUE = "<?php echo $myReservation['start_time']; ?>">
            </DIV>

            <DIV CLASS="form-group">
                  <LABEL FOR="end_time">End Time</LABEL>
                  <INPUT TYPE="text" CLASS="form-control" NAME="end_time" maxlength="1" ID="end_time" ARIA-DESCTIBEDBY="end_time_help" VALUE = "<?php echo $myReservation['end_time']; ?>">
            </DIV>

        
            <INPUT CLASS="btn btn-primary" TYPE="SUBMIT" VALUE="Update Reservation ">
        </DIV>
        <?php 
  }


// the search form
function searchForm() { ?>
  <form action = "" method = "GET">
      <div>
          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" id = "search" name = "search" />
          
      </div>
      <input class="button" type = "submit" value = "Search" />
  </form>
<?php
}

//calling all the php functions

heading();

/*
if (empty($_GET))
{
  listReservations($resev->read());
}
*/
if (empty($_GET))
{
  /*
  if (!empty($_GET['search']))
  {
      listReservations($resev->search($_GET['search']));
  }
  */

  // If no search term(s) were provided,  renders the complete PLAYERS table
  //else
  //{
      listReservations($resev->read());
  //}  
}

else if (!empty($_GET['search'])) 
{
  listReservations($resev->search($_GET['search']));
}

else if (isset($_GET['action']))
{
  switch ($_GET['action'])
  {
    case 'delete':
      $resev->delete($_GET['reservation_id']);
      listReservations($resev->read());
      break;

    case 'update':
      updateReservation($resev->listOne($_GET['reservation_id']));
      break;
  }
}
?>