<?php
include('hmslib.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Patient Information Retrieval</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
    
    <?php
    include('header.php');
    ?>
<body>

<div class="container-fluid">
    
  <center><h2>- Patient Information Retrieval -</h2></center>   
    <?php
    include('userlogoutbtn.php');
    ?>
    <br><br>
    <div class="row">
<div class="col-sm-1"></div>
        
<div class="col-sm-4">
        
        <form class ="form-horizontal" method="post">
    
            <div class="form-group">
                <h3><b>Fetch Patient Info -</b></h3>
      <label class="control-label col-sm-5">NID or Passport : </label>
      <div class="col-sm-6">
        <input type="text" class="form-control"  placeholder="Enter NID or Passport of the Patient" name="token">
      </div>
       
    </div>
            
       <div class="form-group">        
      <div class="col-sm-offset-5 col-sm-8">
         <small><a href="registration.php">New Patient Registration?</a></small>
      </div>
    </div>
            <div class="form-group">        
      <div class="col-sm-offset-5 col-sm-10">
        <button type="submit" name="submit" class="btn btn-info">Fetch Details</button>
      </div>
    </div>
            
        </form>
        
        
        <table class="table table-hover table-bordered">
    
<?php
        if(isset($_POST['submit']) || isset($_GET['ref'])){    
            if(isset($_GET['ref']))
                $token = $_GET['ref'];
            else
            $token = $_POST['token'];
        
         $pnid = $token;
            echo "<h5>Patient ID : {$pnid}</h5>";
                $sql = "SELECT * from patient_info where pnid ='{$pnid}'";
                
                $result = $conn->query($sql);
                if($result->num_rows == 0){
                    echo "<p style=\"color:red\" class=\"smallerror\">No Records Found!</p>";
//                    exit();
                }else{
                    
                
            
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
               
                }
            
            } else {
            
                    // Not Submited
            
//            echo '<h5 style="color:red">Please Enter a Patient ID.</h5>';
//            exit();
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
            
            if(isset($_POST['token']) || isset($_GET['ref'])){    
            if(isset($_GET['ref']))
                $token = $_GET['ref'];
            else
              $token = $_POST['token'];
                
                $sql_check_token = "Select * from tokens where pnid = {$token} and active <> '0'";
                $res_check_token = $conn->query($sql_check_token);
                if($res_check_token){
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
                    if($rescheck->num_rows >0){
                    $row = $rescheck->fetch_assoc();
                    $message = $row['timestamp'];
                    
                      
                echo "<br><b>Last Visit : {$message}</b><br>";
                // Task Check Last Appointed Doctor - from OPD prescription
                    $doc = $conn->query("SELECT fname, lname from doctors where dnid='{$row['dnid']}'");
                        $row = $doc->fetch_assoc();
                echo "<b>Last Appointed Doctor : Dr. {$row['fname']} {$row['lname']}</b>";
                }
                }
            }
            }
            ?>
        
        </div>
        <div class="col-sm-1"></div>
        
        <div class="col-sm-4">
            
         <h3>Patient History (Records)</h3>
    
            <div class="list-group">
                <?php
                if(isset($_POST['token'])){
                    $count = 0;
                    $labexists = 0;
                    $res_pres = $conn->query("SELECT * from opd_prescription where pnid = '{$pnid}' ORDER BY timestamp DESC");
                
                    if($res_pres){
                        if($res_pres->num_rows >0){
                        
                        echo "<h";
                        while($row = $res_pres->fetch_assoc()){
                            $count = $count + 1;
                             echo '<div class="list-group-item">';
                            echo "<b> {$count}) OPD Ref No. {$row['refid']}</b><br> at
                            <a target=\"_blank\"href=\"./printprescription.php?ref={$row['refid']}\">  {$row['timestamp']}</a>
                            <br>";
                            
                            // Check Lab Reports
                            
            
            // Previous Test
            if(isset($_POST['token']) || isset($_GET['ref'])){
             $sql_check_prev_test = "SELECT * from lab_records where pnid = '{$pnid}' and recid='{$row['labrecid']}' order by time_updated desc";
                    $res_check_prev_test = $conn->query($sql_check_prev_test);
                        
                        // Check Number of Samples
                        if($res_check_prev_test->num_rows > 0){
//                        echo"<b>Lab Records : </b>";        
                            $labexists = 1;
                    echo '<div class="list-group">';
//                        $act = "NOT COMPLETED";
                        // report variable has the path to view reports 
                        while($rowlabrec = $res_check_prev_test->fetch_assoc()){
                            echo "<a style=\"float:left\" class=\"list-group-item\"><b>Lab Ref. No.{$rowlabrec['recid']}</b></a>";  
                            
                            // Display Files 
                               
                            echo '<br><br><div class="list-group">';
                if ($handle = opendir("./labreports/{$pnid}")) {
                    
                    while (false !== ($entry = readdir($handle))) {
                            $getarr = explode(',', $entry);
                            
                            if ($entry != "." && $entry != ".." && $rowlabrec['recid'] == ((int)$getarr[0])) {
                                
                                echo "<a target=\"_blank\"class=\"list-group-item\" href=\"./labreports/{$pnid}/{$entry}\">{$entry}</a>";
                            }
                        }
                        closedir($handle);
                    }
                echo '</div>';
                        }
                            
                        }
                            
                                }
                        }
                
            }else{
                        echo '<h5 style="color:red">No Previous Records Found!</h5>';
                    }
                    }
            echo "</div>";       
            // End of Check Lab
                            echo '</div>';
                            $count++;
                        
                }else{
                      echo '<h5 style="color:red">Please Enter a Patient ID to View records.</h5>';
                }
                    
                ?>
            </div>
            

        
      

</div>
    </div>
    
    <!-- Patient Search -->
    
    <div class="row">
<div class="col-sm-1"></div>
        
<div class="col-sm-4">
        
        <form class ="form-horizontal" method="post">
            <div class="form-group">
                <h3><b>Search Patients -</b></h3>
      <label class="control-label col-sm-5">Query : </label>
      <div class="col-sm-6">
        <input type="text" class="form-control"  placeholder="Enter NID or Passport of the Patient" name="searchquery">
      </div>
       
    </div>
          
     <div class="form-group">        
         <label class="control-label col-sm-5">Max Results : </label>
      <div class=" col-sm-3">
         <input type="number" min="1"  class="form-control"  placeholder="10" name="searchquerylimit">
      </div>
    </div>
            <div class="form-group">        
      <div class="col-sm-offset-5 col-sm-10">
        <button type="submit" name="submitsearch" class="btn btn-info">Search Details</button>
      </div>
    </div>
            
        </form>
        
        
        
    
<?php
        if(isset($_POST['submitsearch'])){ 
            $lim = 10;
            // Seach query Limit, Default is 10
            if(isset($_POST['searchquerylimit']) && $lim > 0){
                $lim = $_POST['searchquerylimit'];
            }
        
            if( $lim == NULL){
                $lim = 10;
            }
         $valueToSearch = $_POST['searchquery'];
                $sql = "SELECT * from patient_info where CONCAT(pfname, plname, paddress, phone) LIKE '%".$valueToSearch."%' LIMIT 0,{$lim}";
//            echo $sql;
                
                $result = $conn->query($sql);
                if($result->num_rows == 0){
                    echo "<p style=\"color:red\" class=\"smallerror\">No Records Found!</p>";
                    exit();
                }else{
                     echo "<p style=\"color:green\" class=\"smallsuccess\">Records Found!</p>";
                }
                $count = 1;
                while($row = $result->fetch_assoc()){
                echo "<b>{$count}.</b> Patient ID - {$row['pnid']}";
            echo '<table class="table table-hover table-bordered">';
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
    </tbody></table><br>";
               $count++;
                }
            
            } else {
            
                    // Not Submited
            
            echo '<h5 style="color:orange">Please Enter Name, Address, Phone No. or ID of the Patient to search.</h5>';
            exit();
            }

        ?>

        </div>
        <div class="col-sm-1"></div>
        </div>
    
    
    
    </div>
    </body>
    <?php
    include('footer.php');
    ?>
</html>

