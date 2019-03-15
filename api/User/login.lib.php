<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/librarian.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$librarian = new Librarian($db);
// set ID property of user to be edited
$librarian->username = isset($_GET['username']) ? $_GET['username'] : die();
$librarian->password = isset($_GET['password']) ? $_GET['password'] : die();
// read the details of user to be edited
$stmt = $librarian->login();
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $librarian_arr=array(
        "status" => true,
        "message" => "Successfully Login!",
        "id" => $row['id'],
        "username" => $row['username']
    );
    header('Location: ../../page2.html');
}
else{
    $librarian_arr=array(
        "status" => false,
        "message" => "Invalid Username or Password!",
    );
}
// make it json format
print_r(json_encode($librarian_arr));
?>