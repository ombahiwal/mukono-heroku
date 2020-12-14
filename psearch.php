<?php
include('dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
    <body>
<div class="container-fluid">
<div class="row">
<div class="col-sm-1"></div>
        
<div class="col-sm-4">
        
        <form class ="form-horizontal" method="post">
            <div class="form-group">
                <h3><b>Search Patient Info -</b></h3>
      <label class="control-label col-sm-5">Query : </label>
      <div class="col-sm-6">
        <input type="text" class="form-control"  placeholder="Enter NID or Passport of the Patient" name="searchquery">
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

        
         $valueToSearch = $_POST['searchquery'];
                $sql = "SELECT * from patient_info where CONCAT(pfname, plname, paddress, phone) LIKE '%".$valueToSearch."%' LIMIT 0, 30";
                
                $result = $conn->query($sql);
                if($result->num_rows == 0){
                    echo "<p style=\"color:red\" class=\"smallerror\">No Records Found!</p>";
                    exit();
                }
            
                while($row = $result->fetch_assoc()){
                    
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
               
                }
            
            } else {
            
                    // Not Submited
            
            echo '<h5 style="color:orange">Please Enter Name, Address, Phone or ID of the Patient to search.</h5>';
            exit();
            }

        ?>

        </div>
        <div class="col-sm-1"></div>
        </div>
</div>
      </body>  