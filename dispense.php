<?php
session_start();
include('dbcon.php');
if(isset($_POST['submitdispense'])){
    $token = $_POST['token'];
    $refid = $_POST['prid'];
    $uid = 0;
    $mids = $_POST['mid'];
    $meds = $_POST['meds'];
    $quants = $_POST['quantity'];
    $medicines = $_POST['meds'];
     $uid = $_SESSION['uid'];
    
    /* 
    - OPD Prescription
        - Add uid to OPD Prescription
        - Set Active = '0'
    
    - Update Stock
        Tasks -
        - Fetch Current Stock
        - Subtract and Update to medicine_stock
        - Update to prid 
    - Update Token to Expired -> 0
        -
    */
    $flag = 1;
    $sql_fetch_rec = "SELECT * from prescriptionrec where prid = '{$refid}'";
    $res = $conn->query($sql_fetch_rec);
    if($res){
        $counter = 0;
        while($row = $res->fetch_assoc()){
            // Update 
            if($mids[$counter] !=0){
                // if Medicine ID is available 
                if($conn->query("UPDATE prescriptionrec SET dispensed = '{$quants[$counter]}' where prid = '{$refid}' and mid = '{$mids[$counter]}'")){
                    
                    // Fetch Stock of Medicine
                    $stock_fetch_res = $conn->query("SELECT stock from medicine_stock where mid='{$mids[$counter]}'");
                    $row_stock = $stock_fetch_res->fetch_assoc();
                    $stock = $row_stock['stock'];
                    // Subtract Stock
                    $newstock = $stock - $quants[$counter];
                    
                    if($newstock > 0){
                        // If stock is positive
                        
                        // Update Medicine Stock
                    $stock_update_res = $conn->query("UPDATE medicine_stock SET stock ='{$newstock}' where mid='{$mids[$counter]}'");
                    
                        if($stock_update_res){
                            echo "Prescription Record - ".($counter +1)." Updated !<br>"; 

                            $log = $mids[$counter].",".$stock.",".$newstock;
                            // add log to pharmacy_stats
                            if($conn->query("INSERT INTO pharmacy_stats(userid, data) VALUES('{$uid}', '{$log}')")){
                                echo "";
                            }else{
                                echo "Couldnot add log";
                            }
                        }else{
                            echo "Could Not Update Prescription Record - ".($counter +1);
                            $flag = 0;
                        }
                        
                        
                    }else{
                        // if stock is negative
                        echo "Cannot Dispense Record - ".($counter+1);
                        echo " - Not Enough Stock for MEDID- {$mids[$counter]}<br>";
//                        $flag = 0;
                    }
                    
                
                }else{
                    $flag = 0;
                }   
            }else{
                
                 if($conn->query("UPDATE prescriptionrec SET dispensed = '{$quants[$counter]}', uid = '{$uid}' where prid = '{$refid}' and medicine = '{$meds[$counter]}'")){

                     
                    echo "Prescription Record - ".($counter +1)." Updated !<br>"; 

                }else{
                     $flag = 0;
                 }   
                
            }
            
            
            $counter++;
        }
        
    }else{
        echo "Couldnot Fetch Prescription Records!";
    }
    
    
if($flag == 1){
    // Update OPD_Presc and 
    
    $update_opd_pres = $conn->query("UPDATE opd_prescription SET active='0', medicines = '1', uid='{$uid}' where refid ='{$refid}'");
    if($update_opd_pres){
        echo "<h3>Token No. {$token} - Process Completed successfuly!</h3> <br>";
    }
    
    $update_token = $conn->query("UPDATE tokens SET active='0', prid='{$refid}' where refid = '{$token}'");
    
    if($update_token){
        echo "<p>Token Updated!</p>";
    }else{
        echo "Couldnot Update Token!";
    }
}
    
}




?>
<a href="pharmacy.php">GO_BACK</a>