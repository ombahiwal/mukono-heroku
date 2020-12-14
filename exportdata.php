<?php
session_start();
$uid = 0;
if(isset($_SESSION['docid']) || isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    if(isset($_SESSION['docid'])){
        $uid = $_SESSION['docid'];
    }
}

// Connection 
if(isset($_GET['ref']) || isset($_POST['ref'])){
        $table = $_GET['ref'];
        if(isset($_POST['ref'])){
            $table = $_POST['ref'];
        }
    
        
        $conn=mysqli_connect('localhost','root','root');
        $db=mysqli_select_db($conn, 'mukono-master');

        $filename = "mukono_data_pharmacy_stock.xls"; // File Name
        // Download file
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $user_query = mysqli_query($conn, "SELECT * from {$table}");
        // Write data to file
        $flag = false;
        while ($row = mysqli_fetch_assoc($user_query)) {
            if (!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\r\n";
                $flag = true;
            }
            echo implode("\t", array_values($row)) . "\r\n";
        }  
    mysqli_query($conn, "INSERT INTO misc_logs (uid,description) VALUES('{$uid}', 'Export Data - {$table}')");
}
?>

