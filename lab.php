<?php
include('dbcon.php');
session_start();
$uid = 0;
if(!isset($_SESSION['unid'])){
     header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=3  && $_SESSION['user']['secid'] !=4){
    header('location:userlogin.php');
}else{
    $uid = $_SESSION['user']['uid'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laboratory Test Panel</title>
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
    
  <center><h2>- Pathology Laboratory Testing Panel -</h2></center>
 
    <div class="row">
        <div  class="col-sm-3">
            
        </div>
        <div class="col-sm-6"></div>
        <div class="col-sm-1">
       
        </div>
        <div class="col-sm-2">
        
            <?php 
             if($_SESSION['user']['secid'] !=4){
            echo "<h4>Hello, <br>Dr. {$_SESSION['user']['fname']} {$_SESSION['user']['lname']} </h4>";
                echo '  <a href="ulogout.php"><button class="btn-danger">Logout</button></a>';
            }else{
                echo "<pre>Admin</pre>";
            }     
            ?>
             <a href="ulogout.php"><button class="btn-danger">Logout</button></a>
        </div>
        
    </div>
    <div class="row">
        
        <div class="col-sm-2">
            <form action="" method="post">
<h4>Test Request Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='7'";
    
    $result = $conn->query($sql);
     echo "<select name=\"screentoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['screentoken'])){
                    
                    $sql = "UPDATE tokens set active='8' where refid='{$_POST['screentoken']}'";
                     $result = $conn->query($sql);
                    if($result);
//                    echo "Patient Token Updated to Tested!!<br>";
                }
                
    ?><br>
    
                <input class="btn-info" type="submit" name="call_token" value="Call for Report">
            </form>
        </div>
        
         <div class="col-sm-1">
            <form action="" method="post">
<h4>Tested Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='8'";
    $currentoken = -1;
    if(isset($_POST['submittoken'])){
        $currentoken = $_POST['token'];
    }
    $result = $conn->query($sql);
                echo "<select>";
    while($row = $result->fetch_assoc()){

        echo "<option>".$row['refid']."</option>";

    }
                echo "</select>";
              
                
    ?>
<!--                <input class="btn-info" type="submit" name="forward_token" value="Forward to Doc">-->
            </form>
        </div>
        
    <div class="col-sm-4">
        
        <form class ="form-horizontal" method="post">
    
            <div class="form-group">
      <label class="control-label col-sm-3"> Token No. : </label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  placeholder="Enter Token Number of the Patient" name="token">
      </div>
        
    </div>
      
            <div class="form-group">        
      <div class="col-sm-offset-4">
        <button type="submit" name="submittoken" class="btn btn-default">Fetch Details</button>
      </div>
    </div>
            
        </form>
        
        
        <table class="table table-hover">
    
<?php
        if(isset($_POST['submittoken'])){    
            
         $token = $_POST['token'];
            $sql = "SELECT * FROM tokens where refid='{$token}'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $pnid = $row['pnid'];
    
         
                $sql = "SELECT * from patient_info where pnid ='{$pnid}'";
                
                $result = $conn->query($sql);
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
                
                $birthDate = $row['dob'];
  //explode the date to get month, day and year
  $birthDate = explode("-", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
                
               echo  "
    <tbody>
    
    <th>{$row['plname']}</th>
    <th>{$row['pfname']}</th>
    <th>{$gender}</th>
    
      <tr>
        <td>{$row['dob']} ({$age})</td>
        <td>{$cat}</td>
        <td>{$row['paddress']}</td>
      </tr>
      
      <tr>
      <td>{$row['phone']} </td>
      </tr>
    </tbody>";
        
        
        }else{
           echo "<p style=\"color:red\">No Such Token found!</p>";
                exit();
            }  
                
            } else {
        echo "Enter a Token Number!";
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
        
        
        </div>
        
        
        
        <div class="col-sm-5">
            <div <?php 
                 $flgtest  = 0;
                 if(!isset($_POST['token']) || isset($_POST['sample'])){echo 'style="display:none"'; $token = $_POST['token'];} ?>>
                <b><?php echo "Token No. {$token}";?></b>
                <br>
                <b>Active Laboratory Test Requests : </b>
                <div class="list-group">
                    
                    <?php
                    
                
                    
                        
                    // Fetch Lab Test IDs from Labrecords which are active
                    $sql_fetch_test_ids = "SELECT testids, recid from lab_records where pnid='{$pnid}' and active='1'";
//                    echo $sql_fetch_test_ids;
                    $res_fetch_test_ids = $conn->query($sql_fetch_test_ids);
                    $activetestflag = 0;
                    if($res_fetch_test_ids->num_rows > 0){   
                        $activetestflag = 1;
                        $row_test_ids = $res_fetch_test_ids->fetch_assoc();
//                    print_r($row_test_ids);
                                            
                    // Convert Ids to names
                          $tids = $row_test_ids['testids'];
                        $recid = $row_test_ids['recid'];
                        $rowlabrec = $row_test_ids;
                        
                    $row_test_ids = explode(" ", $row_test_ids['testids']);
                                            
                    // Bootstraping Solution to each query
                    $set =  "";
                    foreach($row_test_ids as $testid){
                        
                        $set = $set."'{$testid}',";    
                    }
                        $set = substr($set, 0, -1);
                        $sqltests = "SELECT * from labtests where testid IN ({$set})";
                        $restests = $conn->query($sqltests);
                              
                                            echo "<table class=\"table\">
                            <thead>
                            <tr>
                                <th>Lab Ref.{$rowlabrec['recid']}<br>
                                Test ID</th>
                                <th>Requested Test</th>
                                <th>Suggested Sample</th>
                                
                            </tr>
                            </thead>
                            <tbody>";
                                            
                        while($testrows = $restests->fetch_assoc()){
                            
                            
                            echo "<tr>
                                <td>{$testrows['testid']}</td>
                                <td>{$testrows['test']}</td>
                                <td>{$testrows['samples']}</td>
                              </tr>";
                            
                        }
                            echo "</tbody>
                            </table>
                            ";
                        
                  
                                            
                                            
                    }else{
                        echo "No Test Found!";
                        $flgtest = 1;
                    }
                    echo "<br><br>";
                
                      // Check previous Records.
                                            
                    $sql_check_prev_test = "SELECT * from lab_records where pnid = '{$pnid}' and samples IS NOT NULL ORDER BY timestamp DESC";
                    $res_check_prev_test = $conn->query($sql_check_prev_test);
                        
                        // Check Number of Samples
                        if($res_check_prev_test->num_rows > 0){
//                            $activetestflag = 1;
                        echo"<b>Latest Samples / Tests : </b>";                 
                                            
                    
                       
                        
                        while($rowlabrec = $res_check_prev_test->fetch_assoc()){
                            echo "<a class=\"list-group-item\">Lab Ref. - {$rowlabrec['recid']}
 - Test Ids - {$rowlabrec['testids']} - on <b> {$rowlabrec['timestamp']}</b></a>";  
                        
                                }
                            
                        }else{
                            echo"<b>Previous Sample Collections : None </b>";                 
                        
                        }
                            
                    ?>
                </div>
        
            </div>
        </div>
    </div>
    
    <br><br>
    <?php
    // end execution if no active test found
    if($flgtest)
        exit();
    ?>
    <div class="row">
    <div class="col-sm-7"></div>
    <div class="col-sm-5">
        <h3>Upload Reports and Inference Notes</h3>
       <form class="form-horizontal" method="post" action="uploadlabreport.php" enctype="multipart/form-data">
        
           <?php
        // Lab Rec ID 
            echo "<input type=\"hidden\" name=\"recid\" value=\"{$recid}\">";
           echo "<input type=\"hidden\" name=\"pnid\" value=\"{$pnid}\">";
            echo "<input type=\"hidden\" name=\"token\" value=\"{$token}\">";
           
            
        ?>
           
             <div class="form-group">
      <label class="control-label col-sm-3"> Select Report File(s) : </label>
      <div class="col-sm-5">
        <input type="file" class="form-control" name="file[]" id="file" multiple>
      </div>
    </div>
           
           <br>
            <div class="form-group">
      <label class="control-label col-sm-3"> Inference Notes : </label>
      <div class="col-sm-5">
          <textarea class="form-control" name="inference" required> </textarea>
      </div>
    </div>
           
           <div class="form-group">
      <div class="col-sm-offset-3 col-sm-5">
        <input class="form-control btn-info" type="submit" value="Submit Reports" name="submit">
      </div>
    </div>
           
           
        </form>
        
    </div>
        
        
    </div>
</div>

</body>
    
    
    <?php
    include('footer.php');
    ?>
</html>
