<?php
include('dbcon.php');
session_start();
$uid = 0;
if(!isset($_SESSION['unid'])){
    
     header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=3 && $_SESSION['user']['secid'] !=4){
    header('location:userlogin.php');
}
else{
    $uid = $_SESSION['user']['uid'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sample Collection for Laboratory</title>
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
    
  <center><h2>- Pathology Laboratory Sample Collection-</h2></center>
 <br><br>
    <?php
    include('userlogoutbtn.php');
    ?>
    <div class="row">
        
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Waiting Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='5'";
    
    $result = $conn->query($sql);
     echo "<select name=\"screentoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['screentoken'])){
                    
                    $sql = "UPDATE tokens set active='6' where refid='{$_POST['screentoken']}'";
                     $result = $conn->query($sql);
//                    echo "Patient Token Updated to Sample!!<br>";
                }
                
    ?>
                <input class="btn-info" type="submit" name="call_token" value="Call">
            </form>
        </div>
        
         <div class="col-sm-1">
            <form action="" method="post">
<h4>Sample Tokens</h4>
            <?php
                
         $sql = "SELECT * from tokens where active ='6'";
    $currentoken = -1;
    if(isset($_POST['submittoken'])){
        $currentoken = $_POST['token'];
    }
    $result = $conn->query($sql);
     echo "<select name=\"forwardtoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['forwardtoken'])){
                    
                    $sql = "UPDATE tokens set active='7' where refid='{$_POST['forwardtoken']}'";
                     $result = $conn->query($sql);
//                    echo "Patient Token Forwarded !!<br>";
                }
                
    ?>
                <input class="btn-info" type="submit" name="forward_token" value="Forward">
            </form>
        </div>
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Tested Report Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='8'";
    $currentoken = -1;
    if(isset($_POST['submittoken'])){
        $currentoken = $_POST['token'];
    }
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){

        echo "<h4>".$row['refid']."<input type=\"radio\" name=\"forwardtoken\" value=\"{$row['refid']}\"> </h4>";

    }
                if(isset($_POST['forwardtoken'])){
                    
                    $sql = "UPDATE tokens set active='7' where refid='{$_POST['forwardtoken']}'";
                     $result = $conn->query($sql);
                    echo "Patient Token Forwarded !!<br>";
                }
                
    ?><input class="btn-info" type="submit" name="forward_token" value="Forward">
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
            <div <?php if(!isset($_POST['token']) || isset($_POST['sample'])){echo 'style="display:none"'; $token = $_POST['token'];} ?>>
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
                    if($res_fetch_test_ids->num_rows > 0){                    $row_test_ids = $res_fetch_test_ids->fetch_assoc();
//                    print_r($row_test_ids);
                                   $activetestflag = 1;         
                    // Convert Ids to names
                          $tids = $row_test_ids['testids'];                $recid = $row_test_ids['recid'];
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
                                <th>Lab Ref. {$recid}<br>Test ID</th>
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
                        echo "No Tests Found!";
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
    if($activetestflag == 0){
        exit();
    }
    ?>
    
    
    
    
    
    <div class="row">
    
    <div class="col-sm-5">
        <form <?php if(!isset($_POST['token']) || isset($_POST['sample'])){echo 'style="display:none"';} ?> class="form-horizontal" action="collect_sample.php" method="post">  
      <input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
      <input type="hidden" name="ptoken" value=" <?php if(isset($_POST['token'])){echo "{$_POST['token']}";}?>" >
      
      
        <div class="form-group">
      <label class="control-label col-sm-3"> Samples Collected : </label>
      <div class="col-sm-7">
<!--          <textarea  class="form-control"  placeholder="Enter the Type of Sample Collected seperated with commas eg. blood, urine, etc" name="sample"></textarea>-->
          <input class="form-control" type="checkbox" name="sample" value="<?php echo"{$tids}";?>">
      </div>
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
        <?php
        if(isset($flag)){
            if($flag){
                echo "Records Updated with Sample Successfully! ";
            }else{
                echo "Could not Update Lab Records !";
            }
        }
            $conn->close();
        ?>
        
    <div class="form-group">        
      <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" name="submit" class="btn btn-default">Update Data</button>
      </div>
    </div>
  </form>
        </div>
    </div>
</div>

</body>
</html>
