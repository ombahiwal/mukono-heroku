<?php
session_start();
include('dbcon.php');
error_reporting(0);
if(!isset($_SESSION['unid'])){
    
   header('location:adminlogin.php');
}else if($_SESSION['user']['secid'] !=4){
    header('location:adminlogin.php');
}else{
    $unid = $_SESSION['unid'];
}
?>

<?php
// Statistics



// Total Numbers

// Users
$res = $conn->query("SELECT COUNT(uid) as total from users");
$row = $res->fetch_assoc();
$total_users = $row['total'];

// Doctors
$res = $conn->query("SELECT COUNT(docid) as total from doctors");
$row = $res->fetch_assoc();
$total_doctors = $row['total'];

// Registered Patients
$res = $conn->query("SELECT COUNT(pnid) as total from patient_info");
$row = $res->fetch_assoc();
$total_patients = $row['total'];

// Prescriptions
$res = $conn->query("SELECT COUNT(refid) as total from opd_prescription");
$row = $res->fetch_assoc();
$total_prescriptions = $row['total'];

// Medicines
$res = $conn->query("SELECT COUNT(mid) as total from medicines");
$row = $res->fetch_assoc();
$total_medicines = $row['total'];

// Lab Records
$res = $conn->query("SELECT COUNT(recid) as total from lab_records");
$row = $res->fetch_assoc();
$total_lab_records = $row['total'];

// Total Appointments (Tokens)
$res = $conn->query("SELECT COUNT(refid) as total from tokens");
if($res->num_rows >0){
$row = $res->fetch_assoc();
$total_tokens = $row['total'];
}else{
    $total_tokens = -1;
}



// Today
// - Visits Today & Percentage of Visits against Total Registrations
// - Prescriptions Today & Percentage against Total Presc.
// - New Registrations Today
// - Total Visits (Appointments)

function percentage($num, $total){
    // Num is X percent of Total, return X
    try{
    return (($num/$total)*100);
    }catch(Exception $e){
        return 0;
    }
}

// New Patients Registered Today
$res = $conn->query("SELECT count(pnid) as total FROM patient_info WHERE DATE(`timestamp`) = CURDATE()
");
$row = $res->fetch_assoc();
$new_patients_today = $row['total'];
$new_patients_percent = percentage($new_patients_today, $total_patients);

// Prescriptions
$res = $conn->query("SELECT count(refid) as total FROM opd_prescription WHERE DATE(`timestamp`) = CURDATE()
");
$row = $res->fetch_assoc();
$new_pre_today = $row['total'];
$new_pre_percent = percentage($new_pre_today, $total_prescriptions);

// New Appointments today
$res = $conn->query("SELECT count(refid) as total FROM tokens WHERE DATE(`created_at`) = CURDATE()
");
$row = $res->fetch_assoc();
$new_tokens_today = $row['total'];
$new_tokens_percent = percentage($new_tokens_today, $total_tokens);


// New labtests today
$res = $conn->query("SELECT count(recid) as total FROM lab_records WHERE DATE(`timestamp`) = CURDATE()
");
$row = $res->fetch_assoc();
$new_lab_records_today = $row['total'];
$new_lab_records_percent = percentage($new_lab_records_today, $total_lab_records);



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
    <?php include('header.php'); ?>
    
    <style>
    
        .col-sm-1{
            border-style: groove;
            height: 150px;
        }
        
    </style>
    
    
    
    		<nav class="navbar navbar-default navbar-static-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">
                                Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<b>Administrator Panel</b>
						</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">			
						<ul class="nav navbar-nav navbar-right">
							<li><a href="" >
                                <?php 
                                
                                if(isset($_SESSION['user'])){
                                     echo "<h4>Hello, {$_SESSION['user']['fname']} </h4>"; 
                                }
                                echo "";?>
                                </a></li>
							<li class="dropdown ">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li class="dropdown-header">Actions</li>
										<li><a href="ulogout.php">Logout</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
				<div class="container-fluid">
                    <h4>Statistics :</h4>
					<div class="col col-md-3">			
						<div class="panel-group" id="accordion">
						  <div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
								Total</a>
							  </h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse in">
								<ul class="list-group">
                                    <li class="list-group-item"><span class="badge"><?php echo $total_tokens;?></span>Appointments</li>
									<li class="list-group-item"><span class="badge"><?php echo $total_patients;?></span>Registered Patients</li>
									<li class="list-group-item"><span class="badge"><?php echo $total_prescriptions;?></span> Prescriptions</li>
									<li class="list-group-item"><span class="badge"><?php echo $total_doctors;?></span> Doctors</li>
                                    <li class="list-group-item"><span class="badge"><?php echo $total_lab_records;?></span> Lab Records</li>
                                    <li class="list-group-item"><span class="badge"><?php echo $total_users;?></span> Users</li>
								</ul>
							</div>
						  </div>
						  <div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
								Registrations</a>
							  </h4>
							</div>
							<div id="collapse2" class="panel-collapse collapse">
								<ul class="list-group">
                                    <a href="registration.php"class="list-group-item"><span class="badge"></span>New Patient</a>
									<a href="regdoctor.php"class="list-group-item"><span class="badge"></span>New Doctor</a>
									<a href="reguser.php"class="list-group-item"><span class="badge"></span> New User</a>
								</ul>
							</div>
						  </div>
							<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
								Pages</a>
							  </h4>
							</div>
							<div id="collapse3" class="panel-collapse collapse">
								<ul class="list-group">
									<a href="index.php"class="list-group-item"><span class="badge"></span>Home</a>
									<a href="patient.php"class="list-group-item"><span class="badge"></span>Patient Information Retrieval</a>
								</ul>
							</div>
						  </div>
                            
                            <div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
								Export Reports</a>
							  </h4>
							</div>
							<div id="collapse4" class="panel-collapse collapse">
								<ul class="list-group">
                                    <a href="exportpharmacystock.php?ref=1"class="list-group-item"><span class="badge"></span>Pharmacy Stock</a>
                                    <a href="exportdata.php?ref=lab_records"class="list-group-item"><span class="badge"></span>Lab Records</a>
									<a href="exportdata.php?ref=patient_info"class="list-group-item"><span class="badge"></span>Patient Info</a>
									<a href="exportdata.php?ref=users"class="list-group-item"><span class="badge"></span> User List</a>
                                    <a href="exportdata.php?ref=doctors"class="list-group-item"><span class="badge"></span> Doctor List</a>
								</ul>
							</div>
						  </div>
                            
                            
						</div> 
					</div>
					<div class="col col-md-9">
						<div class="row">
							<div class="col col-md-5">
								<h4>Today Stats:</h4>
										
									<?php echo"<b>{$new_tokens_today}</b> Visits / Appointments";?><span class="pull-right strong">+ <?php echo "{$new_tokens_percent}%";?></span>
										 <div class="progress">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo "{$new_tokens_percent}%";?>"><?php echo "{$new_tokens_percent}%";?></div>
										</div>	
                                
										<?php echo"<b>{$new_patients_today}</b> New Patient Registrations";?><span class="pull-right strong">+ <?php echo "{$new_patients_percent}%";?></span>
										 <div class="progress">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo "{$new_patients_percent}%";?>"><?php echo "{$new_patients_percent}%";?></div>
										</div>
								
										<?php echo"<b>{$new_pre_today}</b> New Prescriptions";?><span class="pull-right strong">+ <?php echo "{$new_pre_percent}%";?></span>
										 <div class="progress">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo "{$new_pre_percent}%";?>"><?php echo "{$new_pre_percent}%";?></div>
										</div>	
                                
										<?php echo"<b>{$new_lab_records_today}</b> New Lab Records";?><span class="pull-right strong">+ <?php echo "{$new_lab_records_percent}%";?></span>
										 <div class="progress">
											<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="30"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo "{$new_lab_records_percent}%";?>"><?php echo "{$new_lab_records_percent}%";?></div>
										</div>
							</div>
						
                            
						</div>
                     
					</div>
				</div>
    
    <body>
    
        
        
        <div class="container-fluid panel panel-default">
            <h4>Patient Token Management</h4>
        <div class="row">
              
            <div class="col-sm-1">
            
            <form action="" method="post">
<h4>Waiting </h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active ='1'";
    
    $result = $conn->query($sql);
                echo "<select name=\"token1\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['token1'])){
                    
                    $sql = "UPDATE tokens set active='2' where refid='{$_POST['token1']}'";
                     $result = $conn->query($sql);
                    echo "Token Updated !!<br>";
                }
                
    ?>
                    <input class="btn-info" type="submit" name="call_token" value="Fwd">
            </form>
            </div>
            
             <div class="col-sm-1">
            <form action="" method="post">
<h4>Screened</h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active ='2'";
    
    $result = $conn->query($sql);
                echo "<select name=\"token2\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['token2'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['token2']}'";
                     $result = $conn->query($sql);
                    echo "Token Updated !!<br>";
                }
                
    ?>
                    <input class="btn-info" type="submit" name="call_token" value="Fwd">
                 </form>
        </div>
       
            
            
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Doctor</h4>
            <?php
         $sql = "SELECT * from tokens where active ='3'";
    
    $result = $conn->query($sql);
                         echo "<select name=\"token3\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                // Forward token to Pharmacy
                if(isset($_POST['call_token_pharm']) && isset($_POST['token3'])){
                    
                    $sql = "UPDATE tokens set active='4' where refid='{$_POST['token3']}'";
                     $result = $conn->query($sql);
                    echo " Token Updated!!";
                }
                
               
       
                
    ?>
                
                <input class="btn-info" type="submit" name="call_token_pharm" value="Fwd">
            </form>    
        </div> 
            
             <div class="col-sm-1">
        
            <form action="" method="post">
<h4>Pharmacy </h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active ='4'";
    
    $result = $conn->query($sql);
                echo "<select name=\"token4\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['token4'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['token4']}'";
                     $result = $conn->query($sql);
                    echo " Token Updated !!<br>";
                }
                
    ?>
                    <input class="btn-info" type="submit" name="call_token" value="Expire">
            </form>
            
            </div>
            
    <div class="col-sm-1">
             <form action="" method="post">
<h4>All Active</h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active <> '0'";
    
    $result = $conn->query($sql);
                echo "<select name=\"token9\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['token9'])){
                    
                    $sql = "UPDATE tokens set active='0' where refid='{$_POST['token9']}'";
                     $result = $conn->query($sql);
                    echo "<br>Token Expired !!<br>";
                }
                
    ?>
                    <input class="btn-danger" type="submit" name="call_token" value="Expire">
            </form>
        
            </div>        
            <div class="col-sm-2" style="border-color:lightblue;border-style:groove; height:150px">
            
                <h4>Change Token State</h4><br>
                <form action="" method="post">
                 <?php
                       $sql = "SELECT * from tokens where active <> '0'";
    $result = $conn->query($sql);
   echo "Token : <select name=\"tokenstate\"> 
        <option selected disabled> - Select - </option>
   ";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    
                    echo "</select><br>";
         $sql = "SELECT * from token_states";
    $result = $conn->query($sql);
   echo "State : <select  name=\"tokenupdate\"> 
        <option selected disabled> - Select - </option>
   ";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['state']}\">{$row['statename']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['tokenstate']) && isset($_POST['tokenupdate'])){
                    if($_POST['tokenupdate'] <1 && $_POST['tokenupdate'] > 8){
                        echo "Some Error Occured!";
                        exit();
                    }
                    
                    $sql = "UPDATE tokens set active='{$_POST['tokenupdate']}' where refid='{$_POST['tokenstate']}'";
                     $result = $conn->query($sql);
                    if($result){
                        echo "<br>Token Updated!";
                    }
                }
                
            ?>
                <input class="btn-info" type="submit" name="call_token" value="Update">
                
                </form>
            </div>
            
    </div>
    <div class="row">
            
            
            <div class="col-sm-1">
                
                
            <form action="" method="post">
<h4>Lab Waiting</h4>
            <?php
         $sql = "SELECT * from tokens where active ='5'";
    
    $result = $conn->query($sql);
   echo "<select name=\"token5\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['labcall']) && isset($_POST['token5'])){
                    
                    $sql = "UPDATE tokens set active='6' where refid='{$_POST['token5']}'";
                     $result = $conn->query($sql);
                }
                
            ?>
             <input class="btn-info" type="submit" name="labcall" value="Fwd">
        </form>
            </div>
            
              <div class="col-sm-1">
            
             <form action="" method="post">
<h4>Lab Sample</h4>
            <?php
         $sql = "SELECT * from tokens where active ='6'";
    
    $result = $conn->query($sql);
   echo "<select name=\"token6\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['labcall']) && isset($_POST['token6'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['token6']}'";
                     $result = $conn->query($sql);
                }
                
            ?>
             <input class="btn-info" type="submit" name="labcall" value="Fwd">
        </form>
                  </div>
            
            <div class="col-sm-1">
            <form action="" method="post">
<h4>Lab Testing</h4>
            <?php
         $sql = "SELECT * from tokens where active ='7'";
    
    $result = $conn->query($sql);
   echo "<select name=\"token7\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['labcall']) && isset($_POST['token7'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['token7']}'";
                     $result = $conn->query($sql);
                }
                
            ?>
             <input class="btn-info" type="submit" name="labcall" value="Fwd">
        </form>
                </div>
<div class="col-sm-1">
            <form action="" method="post">
<h4>Lab Tested</h4>
            <?php
         $sql = "SELECT * from tokens where active ='8'";
    
    $result = $conn->query($sql);
   echo "<select name=\"token8\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['labcall']) && isset($_POST['token8'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['token8']}'";
                     $result = $conn->query($sql);
                }
                
            ?>
             <input class="btn-info" type="submit" name="labcall" value="Fwd">
        </form>
            
            </div>
        
         <div class="col-sm-1">
             <form action="" method="post">
<h4>All Expired</h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active = '0'";
    
    $result = $conn->query($sql);
                echo "<select class=\"form-control\" name=\"token9\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['token9'])){
                    
                    $sql = "UPDATE tokens set active='0' where refid='{$_POST['token9']}'";
                     $result = $conn->query($sql);
                    echo "Patient Token Actioned !!<br>";
                }
                
    ?>

            </form>
            
            
            </div>  
        <div class="col-sm-2 panel panel-default" style="border-color:red;border-style:solid; height:150px">
            <form method="post" class="form-group" style="height:100%" action="reset_tokens.php">
                <br>
                <small>This Button will Delete All the Current Tokens and Start New the Tokens from Number One</small>
                <br>
                <input type="submit" class="btn btn-warning" value="Reset Tokens" name="resettokenbtn">
            </form>
            
        </div>
        
        </div>
            
            
        </div>
    
        <div class="container-fluid panel panel-default">
        <h4>Online Users</h4>
        <div class="row" >
            <div class="col-sm-2"> 
                <div class="list-group">
                    <a class="list-group-item" ><b>Online Doctors</b></a>
                    
                     <?php
      
      $sql = "select * from doctors where online_status='1'";
      $result = $conn->query($sql);
      
      if($result->num_rows == 0){
      
        echo "<a class=\"list-group-item\"> No Doctors Available.</a>";
          
      }else{
      while($row = $result->fetch_assoc()){
          echo "<a class=\"list-group-item\">Dr. ".$row['fname']." ".$row['lname']." - {$row['docid']} <br>{$row['logtime']}</a>\n";   
      }}
      ?>                   
                </div>
                
                
            </div>
    
             <div class="col-sm-2"> 
                <div class="list-group">
                    <a class="list-group-item" ><b>Online Users</b></a>
                    
                     <?php
      
      $sql = "select * from users where online_status='1'";
      $result = $conn->query($sql);
      
      if($result->num_rows == 0){
      
        echo "<a class=\"list-group-item\"> No Users Online.</a>";
          
      }else{
      while($row = $result->fetch_assoc()){
          echo "<a class=\"list-group-item\">Mr/s. ".$row['fname']." ".$row['lname']." - {$row['section']} - {$row['uid']} <br>{$row['logtime']}</a>\n";   
      }}
      ?>                   
                </div>
                
                
            </div>
            
            
    </div>
        
        </div>
        
    </body>
    
    <?php
    include('footer.php');
    ?>
    
</html>