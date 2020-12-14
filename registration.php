<?php
session_start();
if(!isset($_SESSION['unid'])){
    
     echo "
             <br> Redirecting...</h3>
             <script> window.location='userlogin.php'
        </script>
             ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Patient Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    
    <?php
    include('header.php');
    ?>
    
  <h2>- Patient Registration -</h2>
  <form class="form-horizontal" action="register.php" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2" >First Name : </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" placeholder="Enter First Name" name="pfname">
      </div>
    </div>
      
      <div class="form-group">
      <label class="control-label col-sm-2" >Last Name : </label>
      <div class="col-sm-10">
        <input type="text" class="form-control"  placeholder="Enter Surname" name="plname">
      </div>
    </div>
      
      <div class="form-group">
      <label class="control-label col-sm-2" >NID / Passport No. : </label>
      <div class="col-sm-10">
        <input type="text" class="form-control"  placeholder="Enter National ID or Passport No. " name="pnid">
      </div>
    </div>
      
      
      <div class="form-group">
      <label class="control-label col-sm-2" >Category : </label>
      <div class="form-check">
    <input type="radio" class="form-check-input" value="0" name="pcategory"> National <br>
    <input type="radio" class="form-check-input" value="1" name="pcategory"> Foreigner
    <input type="radio" class="form-check-input" value="2" name="pcategory"> Refugee
  
</div>


    </div>
      
      <div class="form-group">
      <label class="control-label col-sm-2" >Gender : </label>
      <div class="form-check">
    <input type="radio" class="form-check-input" value="0" name="pgender"> Male
</div>
<div class="form-check">
  
    <input type="radio" class="form-check-input" value="1" name="pgender"> Female
  
</div>

    </div>
       
      <div class="form-group">
      <label class="control-label col-sm-2"> DOB : </label>
      <div class="col-sm-10">
        <input type="date" class="form-control"   name="pdob">
      </div>
    </div>
      
      <div class="form-group">
      <label class="control-label col-sm-2"> Phone : </label>
      <div class="col-sm-10">
        <input type="text" class="form-control"   name="phone">
      </div>
    </div>
      
      <div class="form-group">
      <label class="control-label col-sm-2"> Address : </label>
      <div class="col-sm-10">
        <input type="text" class="form-control"  placeholder="Enter Village, Parish, Sub-county, District, City, Country" name="paddress">
      </div>
    </div>
      <!--
        <div class="form-group">
      <label class="control-label col-sm-2"> Address : </label>
      <div class="col-sm-10">
       <select name="">
          <option selected disabled> Select Village</option>
          </select>
           <select name="">
          <option selected disabled> Select Parish</option>
          </select>
           <select name="">
          <option selected disabled> Select Sub-County</option>
          </select>
           <select name="">
          <option selected disabled> Select District</option>
          </select>
           <select name="">
          <option selected disabled> Select City</option>
          </select>
          <select name="">
          <option selected disabled> Select Country</option>
          </select>
      </div>
    </div>
      -->
      
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
        <button type="submit" name="submit" class="btn btn-default">Register</button>
      </div>
    </div>
  </form>
</div>

    <div class="row">
        <div class="col-sm-10">
        </div>

        <div class="col-sm-2">
           
            <h5>Quick Links</h5>
            <ol>
                <li><a href="index.php">Main Index</a></li>
                <li><a href="appointment.php">Reception (Appointment)</a></li>
            </ol>
                
        </div>
             
    
    </div>
</body>
    
    <?php
    include('footer.php');
    ?>
</html>