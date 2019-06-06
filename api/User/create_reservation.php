<?php
include_once '../objects/reservations.php';
include_once 'reservation.php';


session_start();
$_POST["user_id"] = $_SESSION["user_id"];
$reservation = new Reservations();
$reservation->stud_name = (int)$_POST["user_id"];
$reservation->room_number = (int)$_POST["room_id"];
$reservation->description = $_POST["roomDescription"];
$reservation->number_of_people = (int)$_POST["numberOfPeople"];
$reservation->date = $_POST["date"];
$reservation->start_time = $_POST["start_time"];
$reservation->end_time = $_POST["end_time"];

$reservationController = new reservation();

$reservationController->createNewReservation($reservation);

header('Location: reservation_page.php');
?>