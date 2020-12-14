<?php
session_start();
include('dbcon.php');

// After collecting the sample this script mus execute
// updating the lab records table
// updating token to go in lab testing phase.
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

if(isset($_POST['sample'])){
    $flag = 0;    
    $samples = $_POST['sample'];
    $token = $_POST['ptoken'];
//    $pnid = $_POST['pnid'];
    // update labrecords
    $sql_update_sample = "update lab_records set samples = '{$samples}', tested_by='{$uid}' where tokenrefid = '{$token}'";
    $res_update = $conn->query($sql_update_sample);
    if($res_update){
        $flag=1;
        
        $sql = "UPDATE tokens set active='7' where refid='{$token}'";
                     $result = $conn->query($sql);
                    echo "Token ({$token}) Forwarded to Lab!<br>Please Send Patient Samples Under Testing !!<br>";
    
        echo "Lab Records Updated!";
        
    }else{$flag=0;
         echo "Could Not update Lab records please try again later!";
         }
}

?>  

<html>
    <p>
<a href="laboratory_sample.php">Go Back. - to Sample Collection.</a></p>
</html>