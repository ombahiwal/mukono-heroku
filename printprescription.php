<?php
include('dbcon.php');
session_start();
$refid = 0;
if(isset($_GET['ref']))
    $refid = $_GET['ref'];
if(isset($_POST['ref']))
    $refid = $_POST['ref'];
// Alogrithm for Retreiving Prescription
if(!isset($_SESSION['uid'])){
    echo "Invalid Request!";
    exit();
}else if(isset($_SESSION['docid'])){
      $conn->query("INSERT INTO misc_logs(uid, description) VALUES('{$_SESSION['docid']}', '{$refid},Prescription Access')");
}

if(isset($_SESSION['uid'])){
    $conn->query("INSERT INTO misc_logs(uid, description) VALUES('{$_SESSION['uid']}', '{$refid},Prescription Access')");
}else if(isset($_SESSION['docid'])){
    
}





$pnid = 0;
 $sql_check_pres = "SELECT * from opd_prescription where refid = '{$refid}'";
            
        $res_pres = $conn->query($sql_check_pres);
        if($res_pres->num_rows == 0){
            echo "No Records Found!";
            exit();
        }
        if($res_pres){
            $row_pres = $res_pres->fetch_assoc();
            $pnid = $row_pres['pnid'];
            
        }else{
            echo "Error Fetching Prescription with Given ID.";
            exit();
        }
 /*
        Final Prescription Display Algorithm
         - Name and Details of the Patient
         - Name of the Doctor
         - Diagnosis Prescription.
         - Name of Person Dispensing medicine (Pharmacy)
         - Check Lab Tests
            - Display List of Lab Tests Performed
            - Display Name of Lab Technician
         
        
        */
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>OPD Prescription</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
   
    
    <style>
        
        .header-time{
            float:right;
            font-size: 13px;
            color:green;
        }
        
        
        body{
/*            margin: 50px;*/
        }
        
        .table{
            
        }
    
        .table td {
   text-align: center; 
            font-size: 12px;
}
        h4{
            font-size: 16px;
        }
        p{
            font-size: 12px;
        }
        
        .table th {
   text-align: center;   
            background: lightgray;
            font-size: 14px;
}
        .tablelabtests{
            font-size: 12px;
        }
        .container-fluid{
            align-content: center;
        }
        
        
    </style>
    
<body>

<?php
    include('pres_header.php');
    ?>
    
<div class="container-fluid">
    
    <div class="row">
        <center>
    <h3>Patient Report</h3>
            </center>
    </div>
    
    
    <!-- Patient Details  -->
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h4>Patient Info :</h4>
        <table class="table table-hover table-bordered">
    
<?php
              
                $result = $conn->query("SELECT * from patient_info where pnid ='{$pnid}'");
     if($result){
                $row = $result->fetch_assoc();
                
                $cat = $row['pcategory'];
                if($cat == 0){
                    $cat = "National";
                }else if($cat == 1){
                    $cat = "Foriegner";
                }else{
                    $cat = "Refugee";
                }
                $gender = $row['pgender'];
                
                if($gender == 0){
                    $gender = "Male";
                }else{
                    $gender = "Female";
                }
         $height = $row['height'];
         $weight = $row['weight'];
         $bp = $row['bp'];
    
                 $birthDate = $row['dob'];
  //explode the date to get month, day and year
  $birthDate = explode("-", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
                
               echo  "
               <h5>Patient ID - {$row_pres['pnid']}  | Token No. {$row_pres['ptoken']}</h5>
               <h5></h5>
    <tbody>
    
    <th>{$row['plname']}</th>
    <th>{$row['pfname']}</th>
    <th>{$gender}</th>
    
      <tr>
        <td>{$row['dob']} (Age : {$age})</td>
        <td>{$cat}</td>
        <td>{$row['paddress']}</td>
      </tr>
      
      <tr>  
      <td>BP : {$row['bp']} mmHg</td>
      <td>Weight : {$row['weight']} kg</td>
      <td>Height : {$row['height']} cm</td>
      </tr>

    </tbody>";
        
        
        }else {
        echo "Patient Not Found with Given PNID !";
            }
        

        ?>
  </table>
        
        </div>
    
    
    </div>
    
    
<div class="row">
<div class="col-sm-3"></div>
    <div class="col-sm-6">
    
    

<?php
       
        // Print Diagnosis and Prescription
        
        if($res_pres->num_rows > 0){
           
            
            // Fetch Prescription Records with refid
            $sql_pres_rec = "SELECT * from prescriptionrec where prid = '{$refid}'";
            
           
            
            // Prescription Rec
            $res_rec = $conn->query($sql_pres_rec);
            
            if($res_rec->num_rows > 0){
                

                
                 echo "<h4>Diagnosis : <u>{$row_pres['diagnosis']}</u></h4>";
            echo "
            <h4>Treatment Notes : </h4><p>{$row_pres['treatment_notes']}</p>";
                
                 echo "
            <h4>Prescription - </h4>
            
            <table class=\"table table-bordered\">
            
            <thead>
            <tr>
            <th>No.</th>
            <th>Medicine</th>
            <th>Type</th>
            <th>Dosage</th>
            <th>Course</th>
            <th>Dispensed</th>
            </tr>
            </thead>
            
            <tbody>
            ";
              $count = 1;  
                while($row = $res_rec->fetch_assoc()){
                    
                    echo "<tr>
                            <td>{$count}</td>
                            <td><b>{$row['medicine']}</b>
                            <input type=\"hidden\" name=\"meds[]\" value=\"{$row['medicine']}\">
                            </td>
                            <td>{$row['type']}</td>
                            <td>{$row['dosage']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['dispensed']}</td>
                        </tr>";
                    $count++;
                }
                
                $res_pharm_name = $conn->query("SELECT * from users where uid ='{$row_pres['uid']}'");
                $pharm_user_row = $res_pharm_name->fetch_assoc();
                $pharmacist = $pharm_user_row['fname']. " ". $pharm_user_row['lname'];
                echo "
                <tr>
            
                </tr>
                </tbody>
                </table>
                
                ";
                    
               
            }else{
                echo "<h4>Diagnosis, Treatment and Prescription : </h4>
                <p>No Diagnosis Yet.</p>";
            }
            
            // Check Doctor's Name
        
            $res_check_doc = $conn->query("SELECT * from doctors where dnid = '{$row_pres['dnid']}'");
            if($res_check_doc){
                $row_doc = $res_check_doc->fetch_assoc();
                echo "<p>Diagnosed by <b>Dr. ".$row_doc['lname']. " ".$row_doc['fname']. "</b></p>";
            }
            
            
        }


?>
        
        </div>
    </div>
    
    
    
    
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
        
<?php
            
            // Print Lab Tests If Present.
            
            if($row_pres['labtestids'] != ""){
                $pnid = $row_pres['pnid'];
               
                
                 // Fetch Lab Test IDs from Labrecords which are active
                    $sql_fetch_test_ids = "SELECT * from lab_records where pnid='{$pnid}'";
//                    echo $sql_fetch_test_ids;
                    $res_fetch_test_ids = $conn->query($sql_fetch_test_ids);
                    $activetestflag = 0;
                    if($res_fetch_test_ids->num_rows > 0){                    $row_test_ids = $res_fetch_test_ids->fetch_assoc();
//                    print_r($row_test_ids);
                                   $activetestflag = 1;         
                    // Convert Ids to names
                          $tids = $row_test_ids['testids'];                $recid = $row_test_ids['recid'];
                                                          
                    // Print Title
                         echo "<h4>Laboratory Tests : Ref. {$recid}</h4>";
                    $tested_by = $row_test_ids['tested_by'];           $labtesttime = $row_test_ids['time_updated']; 
                    $row_test_ids = explode(" ", $row_test_ids['testids']);
                                            
                                                          
                    // Bootstraping Solution to each query
                    $set =  "";
                    foreach($row_test_ids as $testid){
                        
                        $set = $set."'{$testid}',";    
                    }
                        $set = substr($set, 0, -1);
                        $sqltests = "SELECT * from labtests where testid IN ({$set})";
                        $restests = $conn->query($sqltests);
                              
                                            echo "<table class=\"table table-bordered tablelabtests\">
                            <thead>
                            <tr>
                            <th>No.</th>
                                <th>Test ID</th>
                                <th>Requested Test</th>
                                <th>Expected Sample</th>
                                
                            </tr>
                            </thead>
                            <tbody>";
                        $count =1;                
                        while($testrows = $restests->fetch_assoc()){
                            
                        echo "<tr>
                        <td>{$count}</td>
                                <td>{$testrows['testid']}</td>
                                <td>{$testrows['test']}</td>
                                <td>{$testrows['samples']}</td>
                              </tr>";
                            $count++;
                        }
//                        print_r($row_test_ids);
                           $res_lab_name = $conn->query("SELECT * from users where uid ='{$tested_by}'");
                        $lab_user_row = $res_lab_name->fetch_assoc();
                        $labtechname = $lab_user_row['fname']. " ". $lab_user_row['lname'];
                        
                        
                            echo "<tr>
                            <td></td>
                                <td><small>Reported By Mr/s {$labtechname} at {$labtesttime}</small></td>
                            </tr>";
                                                          
                            echo "</tbody>
                            </table>
                            ";
                            
                            echo "<small>Prescription Ref No. {$refid}</small>";
                    }else{
                        echo "No Lab Tests.";
                    }
                
            }    
?>
            
        </div>
    </div>
        
        
    </div>
    
    
</body>
    <?php
        include('footer.php');
    ?>
</html>