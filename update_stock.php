
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
if(isset($_POST['submitmed'])){
$init = 0;
    $flag = 0;
    $mid = $_POST['mid'];
//    $dosage = $_POST['dosage'];
//    $doe = $_POST['doe'];
    $stock = $_POST['stock'];
    $newstock = $_POST['newstock'];
//    $expiry = $_POST['expiry'];
//    $desc = $_POST['description'];
//    $personnel = $_POST['personnel'];
    $userid = $uid;
    // $userid = $_SESSION['id'];
    
//    $sql  = "Insert into medicines( medicine, dosage, notes, stock, expiry, personnel, doe) values('{$med}', '{$dosage}', '{$desc}', '{$stock}', '{$expiry}', '{$personnel}', '{$doe}')";
    
    // for logs
    $res_log = $conn->query("INSERT into pharmacy_stats (userid, data) values ('{$userid}', '{$mid},{$stock},{$newstock}')");
        
    
    
    $sql = "Update medicine_stock set stock = '{$newstock}' where mid ='{$mid}'";
    
    $result = $conn->query($sql);
    if($result)
        $flag = 1;
    
        
    
}

if(isset($_POST['search']) && $_POST['valueToSearch'] != '')
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT medicines.type, medicines.dosage, medicines.mid as mid1, medicines.medicine, medicine_stock.last_updated, medicine_stock.stock , medicine_stock.mid FROM medicines, medicine_stock where medicines.mid =medicine_stock.mid and CONCAT(medicine_stock.mid, `medicine`, `dosage`) LIKE '%".$valueToSearch."%'";
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
  <title>Pharmacy Stock Update Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
       <script src="search/typeahead.min.js"></script>

 <script>
     // Medicine Search Module
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search/search.php?key=%QUERY',
        limit : 10
    });
});
    </script>
    <style type="text/css">
.bs-example{
	font-family: sans-serif;
	position: relative;
	margin: 50px;
}
.typeahead, .tt-query, .tt-hint {
	border: 2px solid #CCCCCC;
	border-radius: 8px;
    
	outline: medium none;
	padding: 8px 12px;
	width: 100%;
}
.typeahead {
	background-color: #FFFFFF;
}
.typeahead:focus {
	border: 2px solid #0097CF;
}
.tt-query {
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
	color: #999999;
}
.tt-dropdown-menu {
	background-color: #FFFFFF;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 8px;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	margin-top: 12px;
	padding: 8px 0;
	width: 100%;
}
.tt-suggestion {
	font-size: 20px;
	line-height: 24px;
	padding: 3px 20px;
}
.tt-suggestion.tt-is-under-cursor {
	background-color: #0097CF;
	color: #FFFFFF;
}
.tt-suggestion p {
	margin: 0;
}
</style>
<body>
<?php
    include('header.php');
    ?>
    
<div class="container-fluid">
    <center>
  <h2>Pharmacy Stock Update Register.</h2>
  <p>For Updating medicine stock to the pharmacy database<br>
    Please make sure that the records are unique</p>
        </center>
    <br><br>
    <div class="row">
        <div class="col-sm-2"></div>
        
        
        <div class="col-sm-2">
            
            
     <form class="form-horizontal" action="update_stock.php" method="post">
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
        
        
            
        <div class="col-sm-6">
            <h5>Search Results : </h5>
          <table class="table table-bordered">
                <tr>
                    <th>MId</th>
                    <th>Medicine</th>
                    <th>Dosage</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>New Stock</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php if(isset($_POST['search']) && $_POST['valueToSearch'] !='')while($row = mysqli_fetch_array($search_result)):?>
              
              <form method="post" action="update_stock.php">
                <tr>
                    <td>
                        
                        <?php echo $row['mid'];?>
                        <input type="hidden" name="mid" value="<?php echo $row['mid'];?>">
                        <input type="hidden" name="stock" value="<?php echo $row['stock'];?>">
                        
                    </td>
                    <td><?php echo $row['medicine'];?></td>
                    <td><?php echo $row['dosage'];?></td>
                    <td><?php echo $row['type'];?></td>
                    <td><?php echo $row['stock'];?></td>
                    <td><input type="number" name="newstock" ></td>
                    <td><input class="btn-info" type="submit" value="Update Stock" name="submitmed"></td>
                </tr>
                  <?php if($flag) echo "<p style=\"color:green\">Record Updated!<p>";
                  ?>
                  
                  
                  </form>
                <?php endwhile;?>
            </table>
            
        </div>
          <div class="com-sm-1"></div>  
    </div>
    
    <?php
        
        if($flag){
        echo "<h4 style=\"color:green\">Record Updated Successfully!</h4><p>MID. {$_POST['mid']} - Stock : {$_POST['stock']} to {$_POST['newstock']} </p>";
        }else if($init != 1){
            echo "<h4 style=\"color:red\">Some Error Occured!<br>Please check the Values you have entered.<br>
            If problem persists, contact IT.</h4>";
        }
        ?>
    <form method="post">
          
        <h3>All Medicines</h3>
        <table class="table table-bordered">
      <thead>
      <tr>
          <th>M-ID</th>
        <th>Medicine</th>
        <th>Dose</th>
          <th>Type</th>
          <th>Last Updated</th>
          <th>Current Stock</th>
          <th>New Stock (Total)</th>
           <tr>
       
        
      
      </tr>
    </thead>
      <tbody>
          <?php 
          
      // Think about expiry of medicines
          
$sql = "SELECT medicines.dosage, medicines.type, medicines.mid, medicines.medicine, medicine_stock.last_updated, medicine_stock.stock FROM medicines INNER JOIN medicine_stock ON medicines.mid=medicine_stock.mid";
$result = $conn->query($sql);
$srn = 0;
          if($result)
    while($row = $result->fetch_assoc()){
        ?>
            <tr>
                <form method="post" action="update_stock.php">
                    <td>
                        
                        <?php echo $row['mid'];?>
                        <input type="hidden" name="mid" value="<?php echo $row['mid'];?>">
                        <input type="hidden" name="stock" value="<?php echo $row['stock'];?>">
                        
                    </td>
                    <td><?php echo $row['medicine'];?></td>
                    <td><?php echo $row['dosage'];?></td>
                    <td><?php echo $row['type'];?></td>
                    <td><?php echo $row['last_updated'];?></td>
                    <td><?php echo $row['stock'];?></td>
                    <td><input type="number" name="newstock" ></td>
                    <td><input class="btn-info" type="submit" value="Update Stock" name="submitmed"></td>
                </form>
                    </tr>
          
          <?php }?>
       </tbody>
  </table>
        
        
        
        
        </form>
</div>

</body>
    
    <?php
    include('footer.php');
    ?>
</html>
