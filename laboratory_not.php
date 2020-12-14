<?php
include('dbcon.php');
session_start();
$flag = 0;
if(isset($_POST['sample'])){
    // update labrecords
    $sql_add_sample = "insert into labrecords ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laboratory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
    
  <center><h2>- Pathology Laboratory Testing -</h2></center>
 <br><br>
    <div class="row">
        
        
        
        
         <div class="col-sm-1">
            <form action="" method="post">
<h4>Sample Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='6'";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<h4>".$row['refid']."<input type=\"radio\" name=\"forwardtoken\" value=\"{$row['refid']}\"> </h4>";

    }
                if(isset($_POST['forwardtoken'])){
                    
                    $sql = "UPDATE tokens set active='7' where refid='{$_POST['forwardtoken']}'";
                     $result = $conn->query($sql);
                    echo "Patient Token Sample Under Testing !!<br>";
                }
                
    ?><input class="btn-info" type="submit" name="forward_token" value="Call">
            </form>
        </div>
        
        
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Testing Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='7'";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<h4>".$row['refid']."<input type=\"radio\" name=\"forwardtoken\" value=\"{$row['refid']}\"> </h4>";

    }
                if(isset($_POST['forwardtoken'])){
                    
                    $sql = "UPDATE tokens set active='8' where refid='{$_POST['forwardtoken']}'";
                     $result = $conn->query($sql);
                    echo "Patient Token Forwarded to Doctor !!<br>";
                }
                
    ?><input class="btn-info" type="submit" name="forward_token" value="Forward to Doc">
            </form>
        </div>
        
        
        <div class="col-sm-1"></div>
        
    <div class="col-sm-4">
        
        <form class ="form-horizontal" method="post">
    
            <div class="form-group">
      <label class="control-label col-sm-3"> Token No. : </label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  placeholder="Enter Token Number of the Patient" name="token">
      </div>
        
    </div>
      
            <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-3">
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
        
        
        }  
                
            } else {
        echo "No Such Token found!";
            }

$conn->close();
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
    <form <?php if(!isset($_POST['token'])){echo 'style="display:none"';} ?> class="form-horizontal" action="" method="post">  
      <input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
      <input type="hidden" name="ptoken" value=" <?php if(isset($_POST['token'])){echo "{$_POST['token']}";}?>" >
      
      
        <div class="form-group">
      <label class="control-label col-sm-2"> Samples Collected : </label>
      <div class="col-sm-10">
         Test
      </div>
    </div>
         <div class="form-group">
      <label class="control-label col-sm-2">Upload Lab Results </label>
             
      <div class="col-sm-10">
          <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Report" name="upload">
      </div>
    </div>
      
      <?php
        if(isset($_POST['upload'])){
            
           // Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "doc" && $imageFileType != "xls" && $imageFileType != "pdf"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
            
        }
        ?>
        
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
        <button type="submit" name="submit" class="btn btn-default">Submit Data</button>
      </div>
    </div>
  </form>
        </div>
        </div>
</div>

</body>
</html>
