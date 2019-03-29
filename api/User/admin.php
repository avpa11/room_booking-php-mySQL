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
<div class="container">

  <h1 id="click_for_stats">For your monitoring...</h1>
  <div id="monitor">
    <div id="calendar">
    </div>

    <div id="stats">
      <h2>Statistics</h2>
    </div>
  </div>

  <!-- jQuery out into separate file -->
  <script>
    //slide Toggle to hide/show monitoring menu
    $(document).ready(function(){
      $("#click_for_stats").click(function(){
        $("#monitor").slideToggle();
      });
    });
  </script>

  <!-- javascript put into separate file -->
  <script type="text/javascript" defer>
    "use strict";
    var curDay = new Date();

    document.getElementById("calendar").innerHTML = createCalendar(curDay);
    //function that created the clanedar and writes the <table>
    function createCalendar(date) {

      var calendarHTML = "<table id='calendar_table'>";
      calendarHTML += caption(date);
      calendarHTML += tableHead();
      calendarHTML += tableRow(date);
      calendarHTML += "</table>";
      return calendarHTML;
    }

    //function that prints the caption depending on the current month and year
    function caption(date) {
      var monthName = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      
      var curMonth = date.getMonth();
      
      var curYear = date.getFullYear();
      
      var str = "<caption>" + monthName[curMonth] + " " + curYear + "</caption>";
      
      return str;
    }

    // function that prints the table head
    function tableHead() {
      var days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
      var row = "<tr>";
      
      for(var i = 0; i < days.length; i++) {
        row += "<th class='calendar_weekdays'>" + days[i] + "</th>";
      }
      row += "</tr>";
      
      return row;
    }

    // function to determine the length of the month
    function daysInMonth(date) {
      var dayCount = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      
      var curYear = date.getFullYear();
      var curMonth = date.getMonth();
      
      // to determine the lead year and 29 days in February
      if(curYear % 4 == 0) { 
        if( (curYear % 100 != 0) || (curYear % 400 == 0) ) {
          dayCount[1] = 29;	
        }
      }
      
      return dayCount[curMonth];
    }

    // prints the table rows and days in month
    function tableRow(date) {
      var day = new Date(date.getFullYear(), date.getMonth(), 1);
      var weekDay = day.getDay();  
      
      var html = "<tr>";
      for(var i = 0; i < weekDay; i++) {
        html += "<td></td>";
      }
      
      
      var totalDays = daysInMonth(date);
      
      var today = date.getDate();
      
      for(var i = 1; i <= totalDays; i++) {
        day.setDate(i);
        weekDay = day.getDay();
        
        // starts new row if the weekday is Sun
        if(weekDay === 0){
          html += "<tr>";
        }
        // special condition to highlight the current day through css
        if(i === today) {
          html += "<td class='calendar_dates' id='calendar_today'>" + i + "</td>";
        } else {
          html += "<td class='calendar_dates'>" + i + "</td>";
        }
        
        // finishes the row if the weekday is Sat
        if(weekDay === 6){
          html += "</tr>";
        }

        
      }
      
      return html;
      
    }
    </script>

<?php
}?>

  <?php
// function that creates the table based on the db reading
function listReservations($reservation){
  ?>


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
        <TD><a id="update" href = "update.php">Update</a></TD>
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

//calling all the php functions

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