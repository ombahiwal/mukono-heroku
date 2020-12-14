<?php
session_start();
include('dbcon.php');
if(!isset($_SESSION['dnid'])){
       echo "<script> window.location.href = \"doclogin.php\";</script>";
}

if(isset($_POST['tests'])){
    $teststring = "";
//    $pheight  = $_POST['height'];
//    $pweight = $_POST['weight'];
    $pnid = $_POST['pnid'];
    $ptoken = $_POST['token'];
//    $pbp = $_POST['bp'];
    $dnid = $_SESSION['dnid'];
    
    
echo "Token No. : ".$ptoken."<br>";
    echo "Selected Tests : <br>";
    
    
    foreach ($_POST['tests'] as $test){
        echo $test."<Br>";
        $teststring = $teststring."".$test." ";        
    
    }   
    $sql = "SELECT * from opd_prescription where pnid = '{$pnid}' and ptoken = '{$ptoken}'";
    $res = $conn->query($sql);
    
    if($res){
      $sql = "UPDATE opd_prescription SET pnid='{$pnid}', ptoken='{$ptoken}', labtestids='{$teststring}' where pnid = '{$pnid}' and ptoken = '{$ptoken}'";
        $update_pres = $conn->query($sql);
        if($update_pres){
            echo "<h3>Prescription Process Updated Successfuly!</h3>";
//             $update_pres = $update_pres->fetch_assoc();
            
            
            $sqlupdatetoken = "UPDATE tokens set active='5' where refid='{$ptoken}'";
            $res = $conn->query($sqlupdatetoken);
            if($res){
                echo "Token Updated!";
            }else{
                echo "Couldnot Update Token!";
            }
        }
        
        $sql_update_labrecords = "insert into lab_records(testids, tokenrefid, pnid) values('{$teststring}','{$ptoken}', '{$pnid}')";
        $res_labrec = $conn->query($sql_update_labrecords);
        if($res_labrec){
            echo "Lab Records Initiated!<br>";
            
            $res_insert_id = $conn->query("UPDATE opd_prescription set labrecid = LAST_INSERT_ID() where where pnid = '{$pnid}' and ptoken = '{$ptoken}'");
            if($res_insert_id){
               echo "LabRecord Updated in Prescription !"; 
            }else{
                
            }}
        
    }else{
        // Create New Prescription
    $sql = "insert into opd_prescription (pnid, ptoken, labtestids) values ('{$pnid}', '{$ptoken}', '{$teststring}')";
//   echo $sql;
    $result = $conn->query($sql);
    if($result){
        // Get Prescription ID
        $res_prescription_id = "SELECT LAST_INSERT_ID() as prid";
        $row_pres = $res_prescription_id->fetch_assoc();
        $prid = $row_pres['prid'];
        echo "
        <h3>Prescription Process Initiated Successfuly!</h3>";
        
        $sql_update_labrecords = "insert into lab_records(testids, tokenrefid, pnid) values('{$teststring}','{$ptoken}', '{$pnid}')";
        $res_labrec = $conn->query($sql_update_labrecords);
        if($res_labrec){
            echo "Lab Records Initiated!<br>";
            
            $res_insert_id = $conn->query("UPDATE opd_prescription set labrecid = LAST_INSERT_ID() where refid = '{$prid}'");
            if($res_insert_id){
//               echo "LabRecord ID Updated in Prescription !"; 
            }else{
                
            }
            
            
            
        }else{
            echo "Lab Records couldnot be Initiated!";
        }
        
        $sqlupdatetoken = "UPDATE tokens set active='5' where refid='{$ptoken}'";
        $res = $conn->query($sqlupdatetoken);
        if($res){
            echo "Token Updated!";
        }else{
            echo "Couldnot Update Token!";
        }
       /* echo "<h3><br> Redirecting...</h3>
             <script>  var timer = setTimeout(function() {
            window.location='doctor.php'
        }, 3000);
        </script>
             ";
             */
    }else{
        echo "Could not generate prescription, Please Try Again! or contact IT..";
    }
    }
}
?>
<html>

<h3>
    <a href="doctor.php">Go Back.</a>
    </h3>
    
</html>