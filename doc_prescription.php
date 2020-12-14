<?php
// Algoritm for Storing the prescription
session_start();

include('dbcon.php');


if(isset($_POST['diagnosis']) || isset($_POST['token'])){
//    echo "Test !";
    
    $flag = 0;
    // IDs
    $token = $_POST['token'];
    $dnid = $_SESSION['dnid'];
    $pnid = $_POST['pnid'];
    
    // Screening input
    $bp = $_POST['bp'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    
    // New Inputs
    $treat = $_POST['treatmentnotes'];
    $diagnosis = $_POST['diagnosis'];
    
    // Arrays of Prescription
    $countmeds = $_POST['countmeds'];
    $meds = $_POST['searchmed'];
    $types = $_POST['typeofmed'];
    $dosages = $_POST['dosage'];
    $courses = $_POST['course'];
    $mids = $_POST['mid'];
    
    // Start Algo Here
    
    // Check if OPD_Prescription has an Active prescription
    $sql_check_pres = "SELECT * from opd_prescription where pnid = '{$pnid}' and ptoken = '{$token}' and active = '1' ORDER BY timestamp desc";
    $res = $conn->query($sql_check_pres);
    
    if($res->num_rows > 0){
        // OPD Prescription has ALREADY Generated.
        // So Update the Data
        $row = $res->fetch_assoc();
        $refid = $row['refid'];
        
        $update_prescription = $conn->query("UPDATE opd_prescription SET height = '{$height}', weight='{$weight}', bp='{$bp}', dnid = '{$dnid}', diagnosis = '{$diagnosis}', treatment_notes = '{$treat}' where refid='{$refid}'");
           
        if($update_prescription){
            echo "<h4>Prescription with Ref Id - {$refid} Updated!</h4>";
            
            // Insert records
            
             // Loop and Insert for Each Med from POST Arrays
            
            for($i=0; $i< $countmeds; $i++){
            
                $sql_insert_med_rec  = "INSERT INTO prescriptionrec(prid, medicine, type, dosage, course, mid) VALUES('{$refid}', '{$meds[$i]}','{$types[$i]}', '{$dosages[$i]}','{$courses[$i]}', '{$mids[$i]}')";
//                echo $sql_insert_med_rec;
                if($conn->query($sql_insert_med_rec)){
                    echo "Med - ".($i+1)." Inserted!<br>";
                }else{
                    echo "Could Not Insert Med - ".($i+1);
                    $flag = 0;
                }
                
            }
            
            $flag = 1;
            
        }else{
            echo "<h4>Couldnot Update Prescription</h4>";
            $flag = 0;
        }
        
    }else{
        // Generate New OPD Prescription
        // Insert new Prescription.
        $sql_insert_p = "INSERT INTO opd_prescription (diagnosis, treatment_notes, height, weight, bp, dnid, pnid, ptoken, active) VALUES ('{$diagnosis}', '{$treat}', '{$height}', '{$weight}', '{$bp}', '{$dnid}', '{$pnid}', '{$token}', '1')";
        
//        echo $sql_insert_p;
        
        $insert_prescription = $conn->query($sql_insert_p);
        
        
        
        if($insert_prescription){
            
            // Get Ref ID of Prescription
            $res_pres = $conn->query($sql_check_pres);
            $row_pres = $res_pres->fetch_assoc();
            $refid = $row_pres['refid'];
            
            echo "<h3>Prescription Generated with Ref ID - {$refid} Successfuly!</h3>";
            $flag = 1;
            // Using the Ref ID Create Medicine Records
            // Prid is Prescription Reference ID for Ref. OPD_Prescription records.
            
            
            // Loop and Insert for Each Med from POST Arrays
            
             for($i=0; $i< $countmeds; $i++){
            
                $sql_insert_med_rec  = "INSERT INTO prescriptionrec(prid, medicine, type, dosage, course, mid) VALUES('{$refid}', '{$meds[$i]}','{$types[$i]}', '{$dosages[$i]}','{$courses[$i]}', '{$mids[$i]}')";
//                echo $sql_insert_med_rec;
                if($conn->query($sql_insert_med_rec)){
                    echo "Med  - ".($i+1)." Inserted!<br>";
                }else{
                    echo "Could Not Insert Med - ".($i+1);
                    $flag = 0;
                }
                
            }
            
            
            
        }else{
            echo "Couldnot Insert new OPD_Prescription Record!";
            $flag = 0;
        }
        
    }
    
    // Update Token to Pharmacy 4 and check flag
    
    if($flag == 1){
        // Update to 4
        
        if($conn->query("UPDATE tokens set active = '4' where refid='{$token}'")){
            echo "<h3>Token - {$token} Updated to Pharmacy!</h3>";
        }
        
        
    }else{
        echo "Could Not update the token due to some error!";
    }
    
    
    
// End of main POST Check
}


?>
<h3><a href="doctor.php">Go_Back</a></h3>

