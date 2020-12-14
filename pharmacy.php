<?php
include('dbcon.php');
session_start();
$uid = 0;
if(!isset($_SESSION['unid']) ){
     header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=2  && $_SESSION['user']['secid'] !=4){
    header('location:userlogin.php');
}else{
    $uid = $_SESSION['user']['uid'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pharmacy Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
   
<body>
    <?php
        include('header.php');
    ?>
    <div class="container-fluid">
    <div class="row">
        <center>
            <h2>- Pharmacy / Dispensary Panel - </h2>
        </center>
        </div>
        <?php 
            include('userlogoutbtn.php');
                
        ?>
        <div class="row">
            
            
            <div class="col-sm-2">
                <h3>Actions</h3>
                <div class="list-group">
                    <a href="pharmacystock.php" class="list-group-item">
                    View All Medicine Stock</a>
                    <a href="insert_medicine.php" class="list-group-item"> Add New Medicine.</a>
                    <a href="update_stock.php" class="list-group-item"> Update Medicine Stock</a>
                    
                    
                </div>
            </div>
            
            <div class="col-sm-1">
                <br><br>
             <form action="" method="post">
<h4>Pharmacy Patient Tokens</h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active ='4'";
    
    $result = $conn->query($sql);
                echo "<select name=\"doctokenn\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['doctokenn'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['doctokenn']}'";
                     $result = $conn->query($sql);
        //     echo "Patient Token Updated !!<br>";
                }
                
//                 echo '<input class="btn-info" type="submit" name="call_token" value="Call">';
    ?>

            </form>
    <br>
            </div>
            
            <div class="col-sm-4">
            
                <form class ="form-horizontal" action="pharmacy.php" method="post">
    <br><br>
            <div class="form-group">
      <label class="control-label col-sm-3"> Token No. : </label>
      <div class="col-sm-5">
        <input type="text" class="form-control"  placeholder="Enter Token Number of the Patient" name="token">
      </div>
    </div>
      
            <div class="form-group">        
      <div class="col-sm-offset-3 col-sm-2">
        <button type="submit" name="submittoken" class="btn btn-default">Fetch Details</button>
      </div>
    </div>
        </form>
        
        
        <table class="table table-hover">
    
<?php
        if(isset($_POST['submittoken'])){    
            
         $token = $_POST['token'];
            $sql = "SELECT * FROM tokens where refid='{$token}' and active <> '0'";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
        // output data of each row
        $row = $result->fetch_assoc();
        $pnid = $row['pnid'];
         
                $sql = "SELECT * from patient_info where pnid ='{$pnid}'";
                $result = $conn->query($sql);
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
                
               echo  "<br>
               <h4>Token No. {$token}</h4>
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
      <tr><td></td></tr>
    </tbody>";
        
        
        }else {
        echo "No Such Token found!";
            }
        }else{
                echo "No Such Token Found!";
//                include('footer.php');
                exit();
            }
        }
//$conn->close();
            
         
        /*
        
          <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      
        */
        ?>
  </table>
                      
            </div>
            
            
            <div class="col-sm-5">
                <h3> Dispense Medicine - </h3>
                <form action="dispense.php" class="form" method="post">
            <?php
        // Check if OPD_Prescription has an Active prescription
        if(isset($_POST['submittoken'])){
            echo "<input type=\"hidden\" name=\"token\" value=\"{$token}\">";
            
            
    $sql_check_pres = "SELECT * from opd_prescription where pnid = '{$pnid}' and ptoken = '{$token}' ORDER BY timestamp desc";
            
        $res_pres = $conn->query($sql_check_pres);
            
        if($res_pres){
            
            $row_pres = $res_pres->fetch_assoc();
            $refid = $row_pres['refid'];
            echo "<input type=\"hidden\" name=\"prid\" value=\"{$refid}\">";
            echo "<br><b>Diagnosis : <u>{$row_pres['diagnosis']}</u></b>";
            echo "<br><b>Treatment Notes : </b><p>{$row_pres['treatment_notes']}</p>";
            
            // Fetch Prescription Records with refid
            $sql_pres_rec = "SELECT * from prescriptionrec where prid = '{$refid}'";
            
            echo "
            <h4>Prescription - </h4>
            <p>{$row_pres['timestamp']}</p>
            <table class=\"table table-bordered\">
            
            <thead>
            <tr>
            <th>M-ID</th>
            <th>Medicine</th>
            <th>Type</th>
            <th>Strength</th>
            <th>Course</th>
            <th>Dispense Quantity</th>
            </tr>
            </thead>
            
            <tbody>
            ";
            
            // Prescription Rec
            $res_rec = $conn->query($sql_pres_rec);
            
            if($res_rec){
                
                while($row = $res_rec->fetch_assoc()){
                    
                    echo "<tr>
                            <td><b>{$row['mid']}</b>
                            <input type=\"hidden\" name=\"mid[]\" value=\"{$row['mid']}\">
                            </td>
                            <td><b>{$row['medicine']}</b>
                            <input type=\"hidden\" name=\"meds[]\" value=\"{$row['medicine']}\">
                            </td>
                            <td>{$row['type']}</td>
                            <td>{$row['dosage']}</td>
                            <td>{$row['course']}</td>
                            <td><input style=\"width:50%\" type=\"number\" value=\"0\" name=\"quantity[]\"></td>
                        </tr>";
                    
                }
                
                echo "</tbody>
                </table>
                ";
                    
                echo "
                <div class=\"form-group\">
                <div class=\"col-sm-9\"></div>
                <div class=\"col-sm-3\">
                <input type=\"submit\" class=\"form-control btn-success\" name=\"submitdispense\" value=\"Dispense\">
                </div>
                </div>
                ";
                
            }else{
                echo "<h5>Couldnt Fetch Prescription Med Records!</h5>";
            }
            
            
        }else{
            echo "<h4>No Active Precription Found!</h4>";
        }
            // echo $refid;
               
    }    
                
        ?>
        
                    
        
         </form>
                
                
            
        </div>
            
            
    </div>
        
        
        
        
        
        
        
    <div class="row">
            <div class="col-sm-1"> </div>
            <div class="col-sm-1"> </div>
            <div class="col-sm-3"></div>
       
        <div class="col-sm-6">
        
            
            
            
            
        </div>
    </div>
        
        
    </div>
    
    
</body>
    
</html>