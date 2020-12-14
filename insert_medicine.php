
<?php

// Create a medicinal database.
// Stock Management page - Stock Display, issuing
// 
// Create a dispensary page for substracting the stock
session_start();
$uid = 0;
if(!isset($_SESSION['unid'])){
     header('location:userlogin.php');
}else if($_SESSION['user']['secid'] !=2){
    header('location:userlogin.php');
}else{
    $uid = $_SESSION['user']['uid'];
}
include('dbcon.php');
$init =1;
$flag = 0;
//$personnel = "NULL";
$personnel  = $uid;

if(isset($_POST['submit_stock'])){
$init = 0;
    $med = $_POST['medicine'];
    $dosage = $_POST['dosage'];
    $doe = $_POST['doe'];
    $stock = $_POST['stock'];
    $expiry = $_POST['expiry'];
    $desc = $_POST['description'];
    $type = $_POST['type'];
//    $personnel = $_POST['personnel'];
    
    
    // Medicines Table Record
    $sql  = "Insert into medicines( medicine, dosage, notes, expiry, personnel, doe, type) values('{$med}', '{$dosage}', '{$desc}', '{$expiry}', '{$personnel}', '{$doe}', '{$type}')";
    
    $result = $conn->query($sql);

    if($result)
        $flag = 1;
    
    // medicine_stock table 
    if($flag){
        $result = $conn->query("SELECT LAST_INSERT_ID() as mid from medicines");
            $row = $result->fetch_assoc();
        $mid = $row['mid'];
        if($conn->query("INSERT into medicine_stock(mid, stock) values('{$mid}','$stock')")){
            echo "Stock Table Updated! - MID ";
        }else{
            echo "Error Updating Stock Table!";
        }
    }
        
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pharmacy New Medicine Page</title>
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
<div class="container-fluid">
    <center>
  <h2>Pharmacy Register New Medicine</h2>
  <p>For inserting New medicine stock to the pharmacy database<br>
    Please make sure that the records are unique</p>
        </center>
    <form method="post">
  <table class="table table-bordered">
      <thead>
      <tr>
        <th>M-ID</th>
        <th>Medicine</th>
        <th>Dosage</th>
          <th>Type</th>
          <th>Date of Expiry</th>
          <th>Stock Quantity</th>
          <th>Description</th>
          <th>Date Issued</th>
          <th>Personnel</th>
      </tr>
    </thead>
      <tbody>
    <tr>
          <td>#auto</td>
        <td><input type="text" name="medicine" ></td>
        <td><input type="text" name="dosage" ></td>
        <td><input type="text" name="type"></td>
        <td><input type="date" name="expiry" ></td>
        <td><input type="number" name="stock" ></td>
        <td><input type="text" name="description" ></td>
        <td><input type="date" name="doe"></td>
        <td><?php echo "{$_SESSION['user']['lname']} {$_SESSION['user']['fname']}";?></td>
          </tr>
       </tbody>
  </table>
        <?php
        
        if($flag){
        echo "<h4 style=\"color:green\">New Record with MID - {$mid} Inserted Successfully!</h4><br><h5></h5>";
        }else if($init != 1){
            echo "<h4 style=\"color:red\">Some Error Occured!<br>Please check the Values you have entered.<br>
            If problem persists, contact IT.</h4>";
        }
        ?>
        <input class="btn-warning" style="float:right; padding:10px" value="Insert Record" name="submit_stock" type="submit">
        </form>
</div>
<?php
    include('footer.php');
    ?>
    
</body>
</html>
