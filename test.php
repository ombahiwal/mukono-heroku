<?php 
//if(isset($_POST['submit'])){
// 
// // Count total files
// $countfiles = count($_FILES['file']['name']);
//
// // Looping all files
// for($i=0;$i<$countfiles;$i++){
//  $filename = $_FILES['file']['name'][$i];
// 
//  // Upload file
//  move_uploaded_file($_FILES['file']['tmp_name'][$i],'labreports/'.$filename);
// 
// }
//} 
?>
<!--
<form method='post' action='' enctype='multipart/form-data'>
 <input type="file" name="file[]" id="file" multiple>

 <input type='submit' name='submit' value='Upload'>
</form>-->

<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `medicines` WHERE CONCAT(`mid`, `medicine`, `dosage`) LIKE '%".$valueToSearch."%'";
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
<html>
    <head>
        <title>PHP HTML TABLE DATA SEARCH</title>
        <style>
            table,tr,th,td
            {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        
        <form action="test.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['mid'];?></td>
                    <td><?php echo $row['medicine'];?></td>
                    <td><?php echo $row['lname'];?></td>
                    <td><?php echo $row['age'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
        <br>
        <table id="myTable">
    <thead>
        <tr>
            <th>My Header</th>
            <th>H2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>aaaaa</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>My footer</td>
        </tr>
            </tfoot>
        </table>
            
    </body>
        
        <script>
    
    var tableRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];

// Insert a row in the table at the last row
var newRow   = tableRef.insertRow();

// Insert a cell in the row at index 0
var newCell  = newRow.insertCell(0);

// Append a text node to the cell
var newText  = document.createTextNode('New row');
newCell.appendChild(newText);


    </script>
    
</html>





// Doctor Page Shit

<form method="post">
        <h4> Analysis : </h4>
        <input id="medic" type="text" name="typeahead" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Search Medicine..">
        
        
        </form>
        
    <form <?php if(!isset($_POST['token'])){echo 'style="display:none"';} ?> class="form-horizontal" action="docprescription.php" method="post">  
      <input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
        <input type="hidden" name="ptoken" value=" <?php if(isset($_POST['token'])){echo "{$_POST['token']}";}?>" >
      <?php
        
        // for now rely on token setting, later change it to the connection result and doctor's session
        if(isset($_POST['token'])){
        
        $docnid = "T123";
            
        
        echo "<input type=\"hidden\" name=\"bp\" value=\"{$row['bp']}\">
        <input type=\"hidden\" name=\"height\" value=\"{$row['height']}\">
        <input type=\"hidden\" name=\"weight\" value=\"{$row['weight']}\">
        <input type=\"hidden\" name=\"dnid\" value=\"{$docnid}\">
    
        ";
            
            // Later Input Doc Id also, right now, putting Id of the only registered Doctor's NID - T123 ! 
        }
        ?>
    
     
        
        
<table class="table table-bordered">
      <thead>
      <tr>
          <th>SNo.</th>
        <th>M-ID</th>
        <th>Medicine</th>
        <th>Dose</th>
          <th>Stock</th>
          <th>Desc</th>
          <th>Dosage</th>
          <th>Confirm?</th>
           <tr>
       
        
      
      </tr>
    </thead>
      <tbody>
          <?php 
          
      // Think about expiry of medicines
          
$sql = "SELECT * FROM medicines";

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
          <td>{$row['stock']}</td>
          <td>{$row['notes']}</td>
        
          <td><input type=\"number\" name=\"{$row['mid']}\"></td>
          <td><input type=\"checkbox\" name=\"medicines[]\" value=\"{$row['mid']}\">  </td>
      </tr>
      ";
}
   
        ?>
       </tbody>
  </table>
        
     <div class="form-group">
  <label for="comment">Other Medicines : </label>
  <textarea name="medicines" class="form-control" rows="4" id="comment"></textarea>
</div>
        
      
      <div class="form-group">
  <label for="comment">Diagnosis : </label>
  <textarea name="diagnosis" class="form-control" rows="4" id="comment"></textarea>
          
</div>
        
         <div class="form-group">
  <label for="comment">Treatment Notes : </label>
  <textarea name="tnotes" class="form-control" rows="4" id="comment"></textarea>
          
</div>
        
     
        
      
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
        <button type="submit" name="submit" class="btn btn-default">Generate Prescription</button>
      </div>
    </div>
  </form>
        
         