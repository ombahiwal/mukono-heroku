<?php
// Credential Files 
// DBCON
// exportdata
// exportpharmacystock
// search


$user = 'root';
$password = 'root';
$db = 'mukono-master';
$host = 'localhost';
$port = 8889;

$servername = $host;
$username = $user;
//$password = ;
$dbname = $db;
//$pname = $_POST['pname'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//echo "Connected!";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>