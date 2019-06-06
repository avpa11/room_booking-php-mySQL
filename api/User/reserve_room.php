<?php
session_start();

function heading(){?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Welcome Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/welcome.css" />
    </head>
    <body>

    <nav class="navbar navbar-light" style="background-color: #754343;">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
        <li><a href="../../welcome.html">Welcome</a></li>
        <li class="active"><a href="#">Reservation schedule</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
        </ul>
    </div>
    </nav>
<?php
} ?>
<?php
function footer(){ ?>
    <!-- Bootstrap scripts-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
     <!-- scripts for Carousel slider-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>

<?php 
}?>
<?php
function createForm(){?>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <form action="create_reservation.php" method="POST">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Number of people</label>
                        <select class="form-control" id="numberOfPeople" name="numberOfPeople">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <label for="exampleFormControlTextarea1">Why you need the room</label>
                        <textarea class="form-control" id="roomDescription" name="roomDescription" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="start_time" value=<?php echo $_GET["start_time"] ?>>
                    <input type="hidden" name="end_time"  value=<?php echo $_GET["end_time"] ?>>
                    <input type="hidden" name="date"  value=<?php echo $_GET["date"] ?>>
                    <input type="hidden" name="room_id"  value=<?php echo $_GET["room_id"] ?>>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>

<?php

heading();
if(isset($_GET["date"])){
    createForm();
}else{
    echo 'Please return to <a href="reservation_page.php">schedule</a>';
}
footer();

?>