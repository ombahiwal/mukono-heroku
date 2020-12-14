<?php
include('dbcon.php');
// Used to Display or not Display the Forms
$flag =0;
session_start();
if(!isset($_SESSION['unid'])){

     header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=1  && $_SESSION['user']['secid'] !=4){
    header('location:userlogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Patient Screening</title>
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
    
  <center><h2>- Patient Screening -</h2></center>
 
    <?php
    include('userlogoutbtn.php');
    ?>
    <div class="row">
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Waiting Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='1'";
    
    $result = $conn->query($sql);
     echo "<select name=\"screentoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['screentoken'])){
                    
                    $sql = "UPDATE tokens set active='2' where refid='{$_POST['screentoken']}'";
                     $result = $conn->query($sql);
//                    echo "Patient Token Updated !!<br>";
                }
                
    ?>
                <input class="btn-info" type="submit" name="call_token" value="Call">
            </form>
        
            
        </div>
        
         <div class="col-sm-1">
            <form action="" method="post">
<h4>Screening Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='2'";
    
    $result = $conn->query($sql);
      echo "<select name=\"doctoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
    ?>
<!--                <input class="btn-info" type="submit" name="forward_token" value="Forward" disabled>-->
            </form>
        </div>
        
    <div class="col-sm-4">
        
        <form class ="form-horizontal" action="screening.php" method="post">
    
            <div class="form-group">
      <label class="control-label col-sm-3"> Token No. : </label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  placeholder="Enter Token Number of the Patient" name="token">
      </div>
        
    </div>
      
            <div class="form-group">        
      <div class="col-sm-offset-4 col-sm-10">
        <button type="submit" name="submittoken" class="btn btn-default">Fetch Details</button>
      </div>
    </div>
            
        </form>
        
        
        <table class="table table-hover">
    
<?php
        if(isset($_POST['submittoken'])){    
            $flag = 0;
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
      </tr>
    </tbody>";
        
        
        }else {
                $flag = 1;
        echo "<p class=\"smallerror\" style=\"color:red\">No Such Token found!</p>";
                exit();
            }  
                
            } else {
        echo "Please Enter a Token!";
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
    <form <?php if(!isset($_POST['token']) && $flag !=1){echo 'style="display:none"';} ?> class="form-horizontal" action="scrdata.php" method="post">  
        <?php echo "<h4>Token No.{$_POST['token']}</h4>";
        ?>
      <input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
      <input type="hidden" name="ptoken" value=" <?php if(isset($_POST['token'])){echo "{$_POST['token']}";}?>" >
      <div class="form-group">
      <label class="control-label col-sm-2"> Height (cm): </label>
      <div class="col-sm-10">
        <input type="text" class="form-control"  placeholder="Enter the Height of the Patient" name="pheight">
      </div>
    </div>
      
       <div class="form-group">
      <label class="control-label col-sm-2"> Weight (kg): </label>
      <div class="col-sm-10">
        <input type="text" class="form-control"  placeholder="Enter the Weight of the Patient" name="pweight">
      </div>
    </div>
      
        <div class="form-group">
      <label class="control-label col-sm-2"> BP (mmHg): </label>
      <div class="col-sm-10">
          
        <input type="text" class="form-control"  placeholder="Enter the Blood Pressure of the Patient" name="pbp">
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
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
          <?php
          if(isset($_POST['token']) and $flag !=1){
        echo '<button type="submit" name="submit" class="btn btn-default">Submit Data</button><br><br><b>Screening History :</b>';
          
              $res_last_screen = $conn->query("SELECT * from screening_stats where pnid='{$pnid}' order by timestamp desc limit 0,5");
              if($res_last_screen->num_rows > 0){
              
                  while($rowscr = $res_last_screen->fetch_assoc()){
                  echo "<br>
              <a class=\"list-group-item\">
               {$rowscr['timestamp']}  - <b>{$rowscr['data']} </b> 
              </a>";
                  }
              }else{
                  echo "<a class=\"list-group-item\">
              No Past Records.</a>";
              }
          
          }
            ?>
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
