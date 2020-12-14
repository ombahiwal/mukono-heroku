<!DOCTYPE html>
<html lang="en">
<head>
  <title>Token Display System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
    <style>
    
        .col-sm-2{
            color:dimgray;   
            background: lightyellow;
            border-radius: 20px;
        }
        .container-fluid{
            
        }
        h1, h4{
            color:white;
        }
        body{
            background:#a1a1a1;
        }
        .active{
            color
            background: green;
        }
        h3{
            color:green;
        }
        .waitbar{
            color: white;
            background: gray;
                border-radius: 10px;
        }
    </style>
    
    
    
<body>
    <center><img src="media/ugflagextrasmall.png"></center>
    
<h4><center>Mukono General Hospital</center></h4>
    <h1 ><center>Patient Tokens
        <br>
        </center></h1>
<center>
    <div class="header-time"id="txt"></div> 
    <div class="header-time"><?php echo date(" M d Y");?></div></center>

<div class="container-fluid">
<br><br>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10 waitbar">
            <center>
            <h2>----- Waiting ----</h2>
                
            </center>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <div class="row">
        <div class="col-sm-1"></div>
        
        <div class="col-sm-2 active">
            <center>
    <h2>OPD Waiting</h2>
<?php
    
    include('dbcon.php');
    // Add upper and lower limit for the time stamp and expired tokens..
    
    $sql = "SELECT * from tokens where active ='1' or active = '8' order by created_at desc";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
//        echo "<h3>".$row['refid']."</h3><br>";
        echo "<h3>".$row['refid'];
        if($row['active'] == 8)
            echo "(L)";
        echo"</h3><br>";
        
    }
    
    ?>
                </center>
    </div>
    
        <div class="col-sm-2">
        <center><h2>Screening</h2>
          <?php  
    $sql = "SELECT * from tokens where active ='2'";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        
        echo "<h3>".$row['refid']."</h3><br>";
    
        
    }
    
    ?></center>
        </div>
        
        <div class="col-sm-2">
        <center><h2>Doctor</h2>
          <?php  
            
    $sql = "SELECT * from tokens where active ='3' OR active ='9' order by created_at asc";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        
        echo "<h3>".$row['refid'];
        if($row['active'] == 9)
            echo "[L]";
        echo"</h3><br>";

    }
    
    ?></center>
        </div>
        
        <div class="col-sm-2">
            <center>
            <h2>Pharmacy</h2>
        <?php
          $sql = "SELECT * from tokens where active ='4'";    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo "<h3>".$row['refid']."</h3><br>";
    }
                
            ?>
                </center>
        </div>
      
        
        <div class="col-sm-2">
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
    <script>
    
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
    startTime();
        
        // Refresh rate
        setTimeout(function(){
   window.location.reload(1);
}, 5000);

</script>
    <style>
        .header-time{
            font-size: 20px;
            color:white;
        }
</style>
</html>
