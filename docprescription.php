<?php

include('dbcon.php');

$pheight = $_POST['height'];
$pbp = $_POST['bp'];
$pweight = $_POST['weight'];
$pnid =$_POST['pnid'];
$ptoken = $_POST['ptoken'];

$medicines = $_POST['medicines'];
$diagnosis = $_POST['diagnosis'];
$tnotes = $_POST['tnotes'];
$dnid = $_POST['dnid'];

$sql = "insert into opd_prescription (height, weight, pnid, ptoken, bp, dnid, diagnosis, medicines, treatment_notes) values ('{$pheight}', '{$pweight}', '{$pnid}', '{$ptoken}', '{$pbp}', '{$dnid}', '{$diagnosis}', '{$medicines}', '{$tnotes}')";

if($conn->query($sql) == TRUE){
    
    echo "Patient Prescription Generated Successfully!<br>";
   $req_data = $_POST;
    
    echo "<table>";
foreach($req_data as $key=>$row) {
    echo "<tr>";
    foreach($row as $key2=>$row2){
        echo "<td>" . $row2 . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
    
 $sql = "UPDATE tokens set active='4' where refid='{$ptoken}'";
           $result = $conn->query($sql);
    echo "Patient Forwarded to Pharmacy! ";
    
    
}else{
    echo "Some error has orrcured,<br>Details Not Updated!<br>";
    print_r($_POST);
    echo $conn->query($sql);
    echo $sql;
}


?>