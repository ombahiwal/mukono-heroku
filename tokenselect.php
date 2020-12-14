<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-1"></div>
        
        <div class="col-sm-5">
            <center>
    <h2>Active Tokens</h2>
<?php
    
    include('dbcon.php');
    // Add upper and lower limit for the time stamp and expired tokens..
    
    $sql = "SELECT * from tokens where active ='1'";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        
        echo "<h3>".$row['refid']."</h3><br>";
    
        
    }
    
    ?>
                </center>
    </div>
    
        <div class="col-sm-6">
            <center>
            <h2>Expired Tokens</h2>
        <?php
          $sql = "SELECT * from tokens where active ='0'";    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<h3>".$row['refid']."</h3><br>";
    }
            ?>
                </center>
        </div>
        
    </div>
    
    
    </div>
</body>
</html>
