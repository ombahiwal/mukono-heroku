<?php

// Create a medicinal database.
// Stock Management page - Stock Display, issuing
// 
// Create a dispensary page for substracting the stock

include('dbcon.php');

session_start();
$uid = 0;
if(!isset($_SESSION['unid'])){
     header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=2){
    header('location:userlogin.php');
}else{
    $uid = $_SESSION['user']['uid'];
}

if(isset($_POST['search']) && $_POST['valueToSearch'] != '')
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT medicines.dosage, medicines.mid as mid1, medicines.medicine, medicine_stock.last_updated, medicine_stock.stock , medicine_stock.mid FROM medicines, medicine_stock where medicines.mid =medicine_stock.mid and CONCAT(medicine_stock.mid, `medicine`, `dosage`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `users`";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "root", "mukono-master");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pharmacy Stock Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    include('header.php');
    ?>
    
    
    <center>
      <h2>Pharmacy Stock Records</h2>
  <p>Displaying the current stock of medicines.</p>
</center>
    <br><br>
<div class="container-fluid">
    
    <div class="row">
        <div class="col-sm-3"></div>
    <div class="col-sm-2">
    <form class="form-horizontal" action="pharmacystock.php" method="post">
           <div class="form-group">
      <label class="control-label"><b> Search Records(s)</b> </label>
               <div>
        <input type="text" name="valueToSearch" placeholder=" Type Medicine or ID" required></div>
    </div>
          <div class="form-group">
        <input type="submit" name="search" value="Search"><br><br>
        </div> 
          
        </form>
    </div>
        
        <div class="col-sm-5">
    <h5>Search Results : </h5>
          <table class="table table-bordered">
                <tr>
                    <th>MId</th>
                    <th>Medicine</th>
                    <th>Dosage</th>
                    <th>Stock</th>
                 
                </tr>

      <!-- populate table from mysql database -->
                <?php if(isset($_POST['search']) && $_POST['valueToSearch'] !='')while($row = mysqli_fetch_array($search_result)):?>
              
              <form method="post" action="pharmacystock.php">
                <tr>
                    <td>
                        
                        <?php echo $row['mid'];?>
                        <input type="hidden" name="mid" value="<?php echo $row['mid'];?>">
                        <input type="hidden" name="stock" value="<?php echo $row['stock'];?>">
                        
                    </td>
                    <td><?php echo $row['medicine'];?></td>
                    <td><?php echo $row['dosage'];?></td>
                    <td><?php echo $row['stock'];?></td>
    
                </tr>
                 
                  
                  
                  </form>
                <?php endwhile;?>
        </table>
        </div>
        <div class="col-sm-2"></div>
    
    </div>
    
    
    
    <div class="row">
        <div class="col-sm-12">

    <form  method="post">
  <table class="table table-bordered">
      <thead>
      <tr>
          <th>SNo.</th>
        <th>M-ID</th>
        <th>Medicine</th>
        <th>Dosage</th>
          <th>Type</th>
          <th>Stock</th>
          <th>Desc</th>
            <th>Expiry</th>
          <th>Personnel</th>
          <th>Issue</th>
          <th>Created On</th>
          <th>Last_Updated</th>
          
           <tr>
       
        
      
      </tr>
    </thead>
      <tbody>
      <?php 
          
      // Think about expiry of medicines

          
$sql = "SELECT * FROM medicines, medicine_stock where medicines.mid = medicine_stock.mid";

$result = $conn->query($sql);
$srn = 0;
while($row = $result->fetch_assoc()){
    $srn = $srn+1;
    echo " <tr>
    <td>{$srn}</td>
        <td>{$row['mid']}</td>
        <input type=\"hidden\" name=\"\" value=\"{$row['mid']}\">
        <td>{$row['medicine']}</td>
        <td>{$row['dosage']}</td>
        <td>{$row['type']}</td>
          <td>{$row['stock']}</td>
          <td>{$row['notes']}</td>
          <td>{$row['expiry']}</td>
          <td>{$row['personnel']}</td>
          <td>{$row['doe']}</td>
          <td>{$row['created_on']}</td>
          <td>{$row['last_updated']}</td>
         
      </tr>
      ";
}
   
        ?>
       </tbody>
  </table>
<!--        <input name="submit_stock" type="submit">-->
        </form>
        </div>
</div>
    </div>

</body>
    
    <?php
    include('footer.php');
    ?>
</html>
