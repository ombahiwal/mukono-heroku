<?php
    $key=$_GET['key'];
    $array = array();
    $con=mysqli_connect("localhost","root","root","mukono-master", "8889");
    $query=mysqli_query($con, "SELECT * from medicines where medicine LIKE '%".$key."%'");
    while($row=mysqli_fetch_assoc($query))
    {
      $array[] =$row['mid']. ",". $row['medicine']. ",".$row['type'].",".$row['dosage'] ;
    }
    echo json_encode($array);
    mysqli_close($con);
?>
