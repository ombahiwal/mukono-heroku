<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$user = 'root';
$password = 'root';
$db = 'mukono-master';
$host = 'localhost';
//$port = 8889;

$servername = $host;
$username = $user;
//$password = ;
$dbname = $db;
//$pname = $_POST['pname'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

echo "Connected!";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inserting Data
if(isset($_POST['submit'])){
    
    // check if id already exists
    $pnid = $_POST['pnid'];
    $sqlcheck = "SELECT pnid from patient_info where pnid='{$pnid}'";
    $rescheck = $conn->query($sqlcheck);
    if($rescheck->num_rows == 1){
        echo "<h1 style=\"color:red\">ID - {$pnid} <br> Aready Exists!</h1>";
        exit();   
    }
    
        
    // get post data.    
    $pdob = $_POST['pdob'];
    $pfname = $_POST['pfname'];
    $plname = $_POST['plname'];
    
    $pcategory = $_POST['pcategory'];
    $pgender = $_POST['pgender'];
    $paddress = $_POST['paddress'];
    $phone = $_POST['phone'];

    
    // apply sql injection protection here. (preg)
    $sql = "INSERT INTO patient_info (pnid, pfname, plname, pgender, pcategory, paddress, dob, phone) VALUES ('{$pnid}', '{$pfname}', '{$plname}', {$pgender}, {$pcategory}, '{$paddress}', '{$pdob}', '{$phone}')";

    if ($conn->query($sql) === TRUE) {
        echo "<h1>New record created successfully with provided ID - {$pnid}.</h1>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<h3><a href="registration.php">Go Back - Register New Patient.</a></h3>