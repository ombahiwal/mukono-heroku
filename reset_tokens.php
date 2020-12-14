<?php
include('dbcon.php');
session_start();
$uid = 0;
$flag = 0;
if(isset($_SESSION['docid']) || isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    if(isset($_SESSION['docid'])){
        $uid = $_SESSION['docid'];
    }
}

if(isset($_POST['resettokenbtn'])){
    
    // Check if any Active Tokens;
    $res = $conn->query("SELECT * from tokens where active <>'0'");
    if($res && $res->num_rows>0){
        // Active Tokens Present
        $flag = 1;
        echo "<center><h1>Active Tokens Found!</h1><br><h4> Could Not Reset, Please Expire the Tokens and Try Again!</h4></center>";
        // Terminate Program.
        exit();
    }
    
    
    // Start Operation Copy Logs 
    $res = $conn->query("SELECT * from tokens");
    if($res && $res->num_rows >0){
        while($row = $res->fetch_assoc()){

        $sql_insert = "INSERT INTO tokens_log (refid, pnid, docid, comments, active, prid, uid) VALUES
    ('{$row['refid']}', '{$row['pnid']}','{$row['docid']}','{$row['comments']}','{$row['active']}','{$row['pnid']}','{$row['uid']}');";
//            echo $sql_insert;
            if($conn->query($sql_insert)){
                echo "Token Number - {$row['refid']} Saved!<br>";
            }else{
                echo "Token Number - {$row['refid']} Couldnot be Saved!<br>";
                
                $flag = 1;
            }

        }
    }else{
        echo "<h4>No Tokens Found in the System!</h4>";
        $flag = 1;
    }
    
    
    // Truncate Table if No Issue
    
    if($flag == 0){
        
        if($conn->query("TRUNCATE tokens")){
            echo "<center><h1>System Tokens have been Reset Successfuly!</h1></center>";
        }else{
            echo "Could Not Reset Due to some error in Truncate!";
        }
    }else{
        
        echo "<center><h4>CouldNot Reset Tokens Due to some Error!<br> Please Contact IT Support!</h4></center>";
    }
    
    
}




?>