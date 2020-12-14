<?php
include('hmslib.php');
session_start();
if(!isset($_SESSION['unid']) ){
    
   header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=1 && $_SESSION['user']['secid'] !=4){
    header('location:userlogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Patient Appointment and Token Generation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
    
    <?php
    include('header.php');
    ?>
<body>

<div class="container-fluid">
    
  <center><h2>- Patient Appointment and Token Generation -</h2></center>   
    <?php
    include('userlogoutbtn.php');
    ?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">
  <form class="form-horizontal" action="appoint.php" method="post">
    <div class="form-group">
      <label class="control-label col-sm-5" >Patient NID / Passport No.: </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" placeholder="Enter National ID or Passport Number" name="pnid">
      </div>
        <br>
        
    </div>
       
      <div class="form-group">
  <label for="sel1">Appoint Available Doctor :</label>
  <select name="docid" class="form-control" id="sel1" required>
    <option value="" selected disabled>select a doctor</option>
      
      <?php
      
      include('dbcon.php');
      $sql = "select * from doctors where online_status='1'";
      $result = $conn->query($sql);
      
      if($result->num_rows == 0){
      
        echo "<option disabled> No Doctors Available</option>";
          
      }else{
      while($row = $result->fetch_assoc()){
          echo "<option value=\"{$row['dnid']}\">Dr. ".$row['fname']." ".$row['lname']." </option>\n";   
      }}
      ?>
      </select>        
</div>  
<div class="form-group">
  <label for="comment">Comments : </label>
  <textarea name="comments" class="form-control" rows="4" id="comment"></textarea>
</div>
     
      
    
      
      
<!--
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd"> ID Document No.</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="pwd" placeholder="Enter Document ID" name="pwd">
      </div>
    </div>
-->
      
    
<!--
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
      </div>
    </div>
-->
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-success">Generate Token</button>
      </div>
    </div>
  </form>
            </div>
        
        <div class="col-sm-1"></div>
        
        <div class="col-sm-6">
        
        <form class ="form-horizontal" method="post">
    
            <div class="form-group">
                <h4> <b>Fetch Patient Info -</b></h4>
      <label class="control-label col-sm-3">NID or Passport No. : </label>
      <div class="col-sm-5">
        <input type="text" class="form-control"  placeholder="Enter NID or Passport of the Patient" name="token">
      </div>
       
    </div>
            
       <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-8">
         <h5><a href="registration.php">New Patient Registration?</a></h5>
      </div>
    </div>
            <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-info">Fetch Details</button>
      </div>
    </div>
            
        </form>
        
        
        <table class="table table-hover">
    
<?php
        if(isset($_POST['submit'])){    
            
         $token = $_POST['token'];
        
         $pnid = $token;
                $sql = "SELECT * from patient_info where pnid ='{$pnid}'";
                
                $result = $conn->query($sql);
                if($result->num_rows == 0){
                    echo "<p style=\"color:red\" class=\"smallerror\">No Records Found!</p>";
                    exit();
                }
            
                $row = $result->fetch_assoc();
            
                $cat = $row['pcategory'];
                if($cat == 0){
                    $cat = "National";
                }else if($cat == 1){
                    $cat = "Foreigner";
                }else{
                    $cat = "Refugee";
                }
                
                $gender = $row['pgender'];
                
                if($gender == 0){
                    $gender = "Male";
                }else{
                    $gender = "Female";
                }
                
                
               echo  "
    <tbody>
    
    <th>{$row['plname']}</th>
    <th>{$row['pfname']}</th>
    <th>{$gender}</th>
    
      <tr>
        <td>{$row['dob']}</td>
        <td>{$cat}</td>
        <td>{$row['paddress']}</td>
      </tr>
      
      <tr>

      <td>{$row['phone']} </td>
            <td>Registered : {$row['timestamp']}</td>
            <td>Last Updated : {$row['time_updated']}</td>
      </tr>
    </tbody>";
               
            
            
            } else {

            }


            
         
        /*
        
          <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      
        */
        ?>
  </table>
        <?php
            // Check Active Token Number for the given Patient ID
            
            if(isset($_POST['token'])){
                $sql_check_token = "Select * from tokens where pnid = {$token} and active <> '0'";
                $res_check_token = $conn->query($sql_check_token);
                if($res_check_token->num_rows >0){
                    echo "<b>Active Token Found - </b><br>";
                    while($rows = $res_check_token->fetch_assoc()){
                        echo "Token No. <b>{$rows['refid']} </b>- Created - {$rows['created_at']}";
                        echo "<br>";
                    }
                }
                
                
                // Task Check Last Visited - fetched from opd_prescription
                $message = "N/A";
                $rescheck = $conn->query("SELECT * from opd_prescription where pnid='{$token}'");
                
                if($rescheck){
                    $row = $rescheck->fetch_assoc();
                    $message = $row['timestamp'];
                    
                      
                echo "<br><b>Last Visit : {$message}</b><br>";
                // Task Check Last Appointed Doctor - from OPD prescription
                    $doc = $conn->query("SELECT fname, lname from doctors where dnid='{$row['dnid']}'");
                        $row = $doc->fetch_assoc();
                echo "<b>Last Appointed Doctor : Dr. {$row['fname']} {$row['lname']}</b>";
                }
              
            }
            
            ?>
        
        </div>
            
        </div>
</div>

</body>
    
    <?php
    include('footer.php');
    $conn->close();
    ?>
</html>