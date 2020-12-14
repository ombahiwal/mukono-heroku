
<!DOCTYPE html>
<html lang="en">
<head>
  <title>HMS by MMC | Mukono Municipal Council</title>
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
    session_start();
           ?>
    
    
    <div class="container-fluid">
        
        
        <div class="row">
      
            <div class="col-sm-12"></div>
        
        </div>
        <br><br>
        <div class="row">
            <div class="col-sm-2"></div>
        
            <div class="col-sm-4">
            
            <h3>Roles</h3>
    <div class="list-group">
  
  <a href="appointment.php" class="list-group-item">Reception</a>
       
        
        <a href="screening.php" class="list-group-item">Screening</a>
        <a href="doctor.php" class="list-group-item">Doctor</a>
         <a href="lab.php" class="list-group-item">Laboratory</a>
         <a href="pharmacy.php" class="list-group-item">Pharmacy</a>
        <a href="dashboard.php" class="list-group-item">Admin</a>
</div>
    
            </div>

            <div class="col-sm-4">
            
            <h3>Quick Access</h3>
                <div class="list-group">
              <a href="registration.php" class="list-group-item">Patient Registration</a>
                    <a href="patient.php" class="list-group-item">Patient Information Retrieval</a>
              <a href="tokendisplay.php" class="list-group-item">Token Display (Waiting)</a>
            <a href="labtokens.php" class="list-group-item">Token Display (Laboratory)</a>
             <a href="laboratory_sample.php" class="list-group-item">Laboratory Sample Collection</a>
            
              <a href="dashboard.php" class="list-group-item">Admin Dashboard</a>
                </div>
            
            </div>
            
            <div class="col-sm-2"></div>
            
        </div>
        <div class="row"><br></div>
        
        <div class="row">
            <div class="col-sm-2">
                
            </div>
        
            <div class="col-sm-4">
            
            <h3>User Login</h3>
    <div class="list-group">
  <a href="doclogin.php" class="list-group-item">Doctor Login</a>
  <a href="userlogin.php" class="list-group-item">OPD User Login</a>
  <a href="adminlogin.php" class="list-group-item">Admin Login</a>
</div>
    
            </div>
        </div>
        
        
    </div>
    
    </body>
    
    <?php
    include('footer.php');
    ?>
    
</html>

