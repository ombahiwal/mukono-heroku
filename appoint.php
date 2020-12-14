<?php
include('dbcon.php');
session_start();
$uid = 0;
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
}else { echo "
             <br> Redirecting...</h3>
             <script> window.location='userlogin.php'
        </script>
             ";
       $uid = 0;
}
if(isset($_POST['submit'])){
    $pnid = $_POST['pnid'];
    $docid = $_POST['docid'];
    $comment = $_POST['comments'];
    
    
    
    // Check if the Token with given ID exists and has not expired.
    
    $sqlexp = "SELECT * from tokens where pnid ='{$pnid}' and active <> '0'";
    $resexp  = $conn->query($sqlexp);
    if($resexp->num_rows > 0){
        echo "<p style=\"color:red\">Unexpired or Active Tokens found with the provided ID ({$pnid}) : <br></p>";
        while($rows = $resexp->fetch_assoc()){
            print_r($rows);
            echo "<br>";
        }
        echo "<p>Please Complete Previous Tokens to Create New! or Contact Admin.</p>";
        
        exit();
    }
        
        
    
    
    
    // Creating New Token for the ID
    $sql = "INSERT INTO tokens (pnid, docid, comments,  active, uid) VALUES ('{$pnid}', '{$docid}', '{$comment}','1', {$uid})";

if ($conn->query($sql) === TRUE) {
    $sql = "select * from tokens where pnid = '{$pnid}' and active = '1'";

    $result = $conn->query($sql);

            if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $refid = $row['refid'];
    
            } else {
        echo "Some error Occured, Please contact IT!";
            }
    
    echo "<center>Appointment registered!<br>New Token Generated - <h1>".$refid."</h1><br><br> <a href = \"appointment.php\">Create Another Appointment</a></center>";
    
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
    
}
?>