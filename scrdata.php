<html>
<?php
session_start();
    $uid = 0;
if(!isset($_SESSION['unid'])){
    
     echo "
             <br> Redirecting...</h3>
             <script> window.location='userlogin.php'
        </script>
             ";
}else{
    $uid = $_SESSION['user']['uid'];
}
    
include('dbcon.php');
if(isset($_POST['submit'])){
$pheight = $_POST['pheight'];
$pbp = $_POST['pbp'];
$pweight = $_POST['pweight'];
$pnid =$_POST['pnid'];
$ptoken = $_POST['ptoken'];
// Calculating BMI, rounded to 2 decimals.
$bmi = round(($pweight / $pheight / $pheight ) * 10000, 2);
    echo "<b>BMI : {$bmi}</b>";
    
$sql = "Update patient_info set height='{$pheight}', weight='{$pweight}', bp='{$pbp}', bmi='{$bmi}' where pnid='{$pnid}'";


if($conn->query($sql) == TRUE){
 
    // Token Forwarding to Doctor (3)
    // This is avoided to allow doctor to decide.
//      $sql = "UPDATE tokens set active='3' where refid='{$ptoken}'";
//           $result = $conn->query($sql);
    
      // Token Updating to Screened (20)
//      $sql = "UPDATE tokens set active='20' where refid='{$ptoken}'";
//           $result = $conn->query($sql);
    
//    if($result == TRUE){
//        echo "Token Updated!";
//    }
    echo "<h2>Patient Screening Data Updated Successfully!<br>
    </h2>";
    
    
    
    
    // Screening Log
    
    $scrlog = $conn->query("INSERT INTO screening_stats(pnid, data) values('{$pnid}', '{$pheight}, {$pweight}, {$pbp}, {$uid}') ");
    
    
}else{
    echo "Some error has orrcured,<br>Details Not Updated!";
}

/* Tasks -
 - Done - Create table for Screening Data - Update and Creation Timestamp
 - Update Screening Records. Each ID Should be Screened.
 - 
   */
    
    
    
    
    
 /* 
 //TASK inserting in opd_prescription when working on Prescription
    $sql = "insert into opd_prescription(height, weight, pnid, ptoken, bp) values('{$pheight}', '{$pweight}', '{$pnid}', '{$ptoken}', '{$pbp}')";
    
    if($conn->query($sql) == TRUE){
    echo "<br>OPD Precription process initiated successfully!";
    }
    
    */
    
}else{
    echo "<p style=\"color:red\"> No Token Number Supplied 
    </p>";
}

?>

    <a href="screening.php">Go Back - Screen Another Patient</a>
    
</html>