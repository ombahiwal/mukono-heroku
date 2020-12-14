<?php
session_start();
if(!isset($_SESSION['dnid'])  && $_SESSION['user']['secid'] !=4){
    echo "<script> window.location.href = \"doclogin.php\";</script>";
}else if($_SESSION['user']){
    
    $dnid = "0";
    
}else{
    $dnid = $_SESSION['dnid'];
}
include('dbcon.php');

// Keep Bootstrap 3 for This Page - Doctor
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Doctor's Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    
    <script src="search/typeahead.min.js"></script>

 <script>
     // Medicine Search Module
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search/search.php?key=%QUERY',
        limit : 10
    });
        
         $("input.typeahead").on('typeahead:selected',function(e, datum){
    //    window.location = "https://Google.com";
             console.log("Search Option Selected");
             addRow2(datum);
        return false;
        });
    });
    // $('input.typeahead').trigger('selected', {"id": id, "value": value}); 
    
    </script>
</head>
    
    <style type="text/css">
.bs-example{
	font-family: sans-serif;
	position: relative;
	margin: 25px;
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
	width: 150%;
}
.tt-suggestion {
	font-size: 15px;
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
        .medinput{
            max-width: 100px;
            margin: 10px;
        }
        table, th, td { border: solid 1px #DDD;
            border-collapse: collapse; padding: 2px 3px; text-align: center;
        }
</style>
    
<body>
<?php
    include('header.php');
    ?>
    
    
<div class="container-fluid">
    
  <center><h2>- Doctor's Patient Management Panel -</h2></center>
 <br><br>
    
    <div class="row">
        <div  class="col-sm-3">
            
        </div>
        <div class="col-sm-6"></div>
        <div class="col-sm-1">
       
        </div>
        <div class="col-sm-2">
        
            <?php 
            if($_SESSION['user'] !=4){
            echo "<h4>Hello, <br>Dr. {$_SESSION['user']['fname']} {$_SESSION['user']['lname']} </h4>";
                echo '  <a href="dlogout.php"><button class="btn-danger">Logout</button></a>';
            }else{
                echo "<pre>Admin</pre>";
            }
            ?>
           
        </div>
        
    </div>
    
    <br>
    <div class="row">
        
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Screened Patient Tokens</h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active ='2'";
    
    $result = $conn->query($sql);
                echo "<select name=\"doctoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['doctoken'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['doctoken']}'";
                     $result = $conn->query($sql);
//                    echo "Patient Token Updated !!<br>";
                }
                
    ?>
                    <input class="btn-info" type="submit" name="call_token" value="Call">
            </form>
<br><br>
            
              <form action="" method="post">
<h4>Waiting Patient Tokens</h4>
                
            <?php
                
         $sql = "SELECT * from tokens where active ='1'";
    
    $result = $conn->query($sql);
                echo "<select name=\"doctokenn\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
         if(isset($_POST['doctokenn'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['doctokenn']}'";
                     $result = $conn->query($sql);
//                    echo "Patient Token Updated !!<br>";
                }
                
    ?>
                    <input class="btn-info" type="submit" name="call_token" value="Call">
            </form>
<br><br>
            
            <form action="" method="post">
<h4>Lab Tested Patient Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='8'";
    
    $result = $conn->query($sql);
   echo "<select name=\"doctoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                if(isset($_POST['labcall']) && isset($_POST['doctoken'])){
                    
                    $sql = "UPDATE tokens set active='3' where refid='{$_POST['doctoken']}'";
                     $result = $conn->query($sql);
                }
                
            ?>
             <input class="btn-info" type="submit" name="labcall" value="Call">
        </form>
    
            
        </div>
        <div class="col-sm-1">
            <form action="" method="post">
<h4>Active Patient Tokens</h4>
            <?php
         $sql = "SELECT * from tokens where active ='3'";
    
    $result = $conn->query($sql);
                         echo "<select name=\"forwardtoken\">";
    while($row = $result->fetch_assoc()){
        echo "<option value=\"{$row['refid']}\">{$row['refid']}</option>";
    }
                    echo "</select>";
                
                // Forward token to Pharmacy
                if(isset($_POST['call_token_pharm']) && isset($_POST['forwardtoken'])){
                    
                    $sql = "UPDATE tokens set active='4' where refid='{$_POST['forwardtoken']}'";
                     $result = $conn->query($sql);
//                    echo " <br>Patient Token Forwarded to Pharmacy!!<br>";
                }
                
               
       
                
    ?>
                
                <input class="btn-info" type="submit" name="call_token_pharm" value="Fwd->Phm">
            </form>    
        </div> 
    
        
        
    <div class="col-sm-4">
        
        <form class ="form-horizontal" action="doctor.php" method="post">
    
            <div class="form-group">
      <label class="control-label col-sm-3"> Token No. : </label>
      <div class="col-sm-5">
        <input type="text" class="form-control"  placeholder="Enter Token Number of the Patient" name="token">
      </div>
    </div>
      
            <div class="form-group">        
      <div class="col-sm-offset-3 col-sm-2">
        <button type="submit" name="submittoken" class="btn btn-default">Fetch Details</button>
      </div>
    </div>
            
        </form>
        
        
        <table class="table table-hover">
    
<?php
        if(isset($_POST['submittoken'])){    
            
         $token = $_POST['token'];
            $sql = "SELECT * FROM tokens where refid='{$token}' and active <> '0'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $pnid = $row['pnid'];
    
         
                $sql = "SELECT * from patient_info where pnid ='{$pnid}'";
                
                $result = $conn->query($sql);
     if($result){
                $row = $result->fetch_assoc();
                
                $cat = $row['pcategory'];
                if($cat == 0){
                    $cat = "National";
                }else if($cat == 1){
                    $cat = "Foriegner";
                }else{
                    $cat = "Refugee";
                }
                $gender = $row['pgender'];
                
                if($gender == 0){
                    $gender = "Male";
                }else{
                    $gender = "Female";
                }
         $height = $row['height'];
         $weight = $row['weight'];
         $bp = $row['bp'];
    
                 $birthDate = $row['dob'];
  //explode the date to get month, day and year
  $birthDate = explode("-", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
                
               echo  "<br>
               <h4>Token No. {$token}</h4>
    <tbody>
    
    <th>{$row['plname']}</th>
    <th>{$row['pfname']}</th>
    <th>{$gender}</th>
    
      <tr>
        <td>{$row['dob']} (Age : {$age})</td>
        <td>{$cat}</td>
        <td>{$row['paddress']}</td>
      </tr>
      
      <tr>  
      <td>BP : {$row['bp']} mmHg</td>
      <td>Weight : {$row['weight']} kg</td>
      <td>Height : {$row['height']} cm</td>
      </tr>
      <tr><td></td></tr>
    </tbody>";
        
        
        }else {
        echo "No Such Token found!";
            }
        }else{
                echo "No Such Token Found!";
//                include('footer.php');
                exit();
            }
        }else{
             echo '<h5 style="color:red">Please Patient Token  Number.</h5>';
            exit();
        }
//$conn->close();
            
         
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
        
             
    <!-- Area for Prescription and Diagnosis -->
    <div class="col-sm-6">
        <h3>Diagnosis and Treatment -</h3>
        <br>
    <form id="prescription" action="doc_prescription.php" class="form-horizontal" method="post">
            
    <div class="form-group">
          <label class="control-label col-sm-3" >Diagnosis :  </label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="diagnosis" placeholder="Diagnosis of the Patient">
          </div>
        </div>
        
        <div class="form-group"  >
          <label class="control-label col-sm-3" >Treatment notes :  </label>
          <div class="col-sm-6">
          <textarea name="treatmentnotes" class="form-control" placeholder="Enter Treatment Notes..."> </textarea>
          </div>
        </div>
        
        <br>
            <h4>Prescription : </h4>
            <p>
                  <!-- Search Bar -->
                
                 <input type="text" name="typeahead" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Search Medicine">

                <br><br>
                
    <input class="btn-info" type="button" id="addRow" value="Add Medicine" onclick="addRow1()"/>
    </p><br>
            
            <div id="cont"></div>   <!--the container to add the table.-->
            <br>
         <div class="form-group">
          <div class="col-sm-4">
            <p><input class="form-control btn-success" type="button" id="bt" name="submitprescription" value="Submit Prescription" onclick="submit()" /></p>
          </div>
        </div>
            
    <!-- Hidden Element of the Form -->

            <input type="hidden" value="<?php echo $token;?>" name="token">
            <input type="hidden" value="<?php echo $pnid; ?>" name="pnid">
            <input type="hidden" value="<?php echo $dnid; ?>" name="dnid">
            <input type="hidden" value="<?php echo $bp; ?>" name="bp">
            <input type="hidden" value="<?php echo $height; ?>" name="height">
            <input type="hidden" value="<?php echo $weight; ?>" name="weight">
            
        
        </form>
        
    <!-- End of Precription form -->    
    </div>
    <div>
        
    </div>
    
    </div>
        
    <div class="row">
        <div class="col-sm-6"></div>
        
        
        <div class="col-sm-5">
            <h5>Previous Diagnostics : </h5>
    
        </div>
        
        
        
    </div>
    <br>
    <br>
    
    
    
    
    <div class="row">
        <div class="col-sm-6">.</div>
        <div class="col-sm-4">
        <h3>Laboratory Tests and Reports -</h3>
        </div>
        <br>
       <br>
    </div>
    
    
    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-1">
          
        <!--Put  The Queue of LAb Tokens -->
        
         
        
        </div>
        
    
        <div class="col-sm-4">
            <form id="select1" action="doc_lab_update.php" method="post">
            <div class="form-group" style="<?php if(!isset($_POST['submittoken']))echo "display:none";?>"> 
                <label for="select1">Select Lab Tests : </label>
      
        <select class="form-control" name="tests[]" multiple>
            <option disabled>Select Labtests</option>
        <?php
        if(isset($_POST['submittoken'])){
            
        // fetch tests
            $sql_for_tests = "SELECT * from labtests";
            $result = $conn->query($sql_for_tests);
            $count = 1;
            while($row3 = $result->fetch_assoc()){
                
                echo "<option value=\"{$row3['testid']}\"> {$count}) T{$row3['testid']} -- {$row3['test']}</option>";
                $count++;
                
            }
             
        }
        ?>
            </select>
         
          
               <input type="hidden" name="token" value="<?php  echo $_POST['token'];?>">
                <input type="hidden" name="pnid" value="<?php echo $pnid;?>">
          <br>
              <input class="btn-warning"type="submit" value="send for labtest" name="sendlabtest">
            </div>
                
                 </form>
        </div>
        
        <div class="col-sm-1"></div>
    </div>
    
    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-1"></div>
        
        <div class="col-sm-5">
          <br>
            <?php
            
            // Previous Test
            if(isset($_POST['token'])){
             $sql_check_prev_test = "SELECT * from lab_records where pnid = '{$pnid}' order by time_updated desc";
                    $res_check_prev_test = $conn->query($sql_check_prev_test);
                        
                        // Check Number of Samples
                        if($res_check_prev_test->num_rows > 0){
                        echo"<b>Patient Lab Records : </b>";             
                    echo '<div class="list-group">';
                        $act = "NOT COMPLETED";
                        // report variable has the path to view reports
                        $report = "";
                        while($rowlabrec = $res_check_prev_test->fetch_assoc()){
                            if($rowlabrec['active'] == 0){
                                $act = 'COMPLETED';
                                $report = "<a href=\"./patient.php?ref={$pnid}\" target=\"_blank\">View Report</a>";
                            }else{
                                $act = "NOT COMPLETED";
                                $report = "";
                            }
                            echo "<div style=\"float:left\" class=\"list-group-item\">Lab Ref.{$rowlabrec['recid']}<br>Test Ids : {$rowlabrec['testids']}<br>
                            <b>{$report}</b><br>
                            {$rowlabrec['timestamp']}<br> <b>{$act}</b></div>";  
                        
                                }
                        }
                
            }
            echo "</div>";
            ?>
                
        </div>
    </div>
    
    
</div>
<p id="testp"></p>
</body>
    
    <script>
        
            // Script for Creating Dynamic Table
        
          window.onload = (event) =>{
              createTable();
          };
            
        
    var arrHead = new Array();
    arrHead = ['M-Id', 'Medicine' , 'Type','Strength', 'Course', '']; 
        // table headers.
var count  = 0;
    // first create a TABLE structure by adding few headers.
        var cnt = document.createElement('input');
        var formpres = document.getElementById('prescription');
        
    function createTable() {
        
        cnt.setAttribute('value', count);
        cnt.setAttribute('type', 'hidden');
        cnt.setAttribute('name', 'countmeds');
        formpres.appendChild(cnt);
        
        
        var empTable = document.createElement('table');
        empTable.setAttribute('id', 'empTable');  // table id.

        var tr = empTable.insertRow(-1);

        for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th'); // the header object.
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        }

        var div = document.getElementById('cont');
        div.appendChild(empTable);    // add table to a container.
    }

    // function to add new row.
        
    function addRow1(){
        var empTab = document.getElementById('empTable');
        count = count +1;
        cnt.setAttribute('value', count);
        console.log(count);
        var rowCnt = empTab.rows.length;    // get the number of rows.
        var tr = empTab.insertRow(rowCnt); // table row.
        tr = empTab.insertRow(rowCnt);
var ele,td;
        
        for (var c = 0; c < arrHead.length; c++) {
            td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {   // if its the first column of the table.
                ele = document.createElement('input');
                  ele.setAttribute('type', 'hidden');
                ele.setAttribute('value', '0');
                ele.setAttribute('name','mid[]');
//                ele.innerHTML = "";
                td.appendChild(ele);
                 ele = document.createElement('b');
                ele.innerHTML = "n/a";
                td.appendChild(ele);
            }else if(c==1){
                // the 2nd will have search.
                ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', '');
                ele.setAttribute('name','searchmed[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
                
            
            }else if(c == 2){
                     ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', '');
                ele.setAttribute('name','typeofmed[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
                
            }else if(c == 3){
                ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', '');
                ele.setAttribute('name','dosage[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
                
            }else if(c == 4){
                  ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', '');
                ele.setAttribute('name','course[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
            }else if(c == 5){
                // add a button control.
                var button = document.createElement('input');

                // set the attributes.
                button.setAttribute('type', 'button');
                button.setAttribute('value', 'Remove');
                button.setAttribute('class', 'btn-danger')
                // add button's "onclick" event.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);
            }
        }
    }

    
    // function to delete a row.
    function removeRow(oButton){
        var empTab = document.getElementById('empTable');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex); 
        // buttton -> td -> tr
        count = count -1;
        cnt.setAttribute('value', count);
    } 
        
    // Add Row 2 for the Search Items
        
        function addRow2(selectedoption){
            count = count +1;
        cnt.setAttribute('value', count);
            console.log(selectedoption);
        var data = selectedoption['value'].split(',');
            console.log(data);
        var empTab = document.getElementById('empTable');   
        //   count = count +1;
        var rowCnt = empTab.rows.length;    // get the number of rows.
        var tr = empTab.insertRow(rowCnt); // table row.
        tr = empTab.insertRow(rowCnt);
var ele,td;
        
        for (var c = 0; c < arrHead.length; c++) {
            td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {   // if its the first column of the table.
                ele = document.createElement('input');
                ele.setAttribute('type', 'hidden');
                ele.setAttribute('value', data[0]);
                ele.setAttribute('name','mid[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
                ele = document.createElement('b');
                ele.innerHTML = data[0];
                td.appendChild(ele);
                
                
            }else if(c==1){
                
                ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', data[1]);
                ele.setAttribute('name','searchmed[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
                
            }else if(c == 2){
                ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', data[2]);
                ele.setAttribute('name','typeofmed[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
        
            }else if(c == 3){
                ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', data[3]);
                ele.setAttribute('name','dosage[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
                
            }else if(c == 4){
                  ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', '');
                ele.setAttribute('name','course[]');
                ele.setAttribute('class', 'medinput');
                td.appendChild(ele);
            }else if(c == 5){
                // add a button control.
                var button = document.createElement('input');

                // set the attributes.
                button.setAttribute('type', 'button');
                button.setAttribute('value', 'Remove');
                button.setAttribute('class', 'btn-danger')
                // add button's "onclick" event.
                button.setAttribute('onclick', 'removeRow(this)');

                td.appendChild(button);
            }
        }
    }

        
    // function to extract and submit table data.
    function submit() {
        var myTab = document.getElementById('empTable');
        var arrValues = new Array();

        // loop through each row of the table.
        for (row = 1; row < myTab.rows.length - 1; row++) {
            // loop through each cell in a row.
            for (c = 0; c < myTab.rows[row].cells.length; c++) {
                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'text') {
                    arrValues.push("'" + element.childNodes[0].value + "'");
                }
            }
        }
        
        // finally, show the result in the console.
        console.log(arrValues);
    }
</script>
    
    <?php
    include('footer.php');
    ?>
</html>