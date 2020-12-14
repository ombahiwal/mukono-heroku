
<h3>Find Associated Token Number</h3>
<form method="post">
    <p>Enter the UID</p>
<input type="text" name="gpnid" >
    <input type="submit" name="gettoken" value="Search Records">

</form>

<table>
<?php
include('dbcon.php');
$flag=0;
        if(isset($_POST['gettoken'])){    
            
         $pnid = $_POST['gpnid'];
            
                $sql = "SELECT * from patient_info where pnid ='{$pnid}'";
                
                $result = $conn->query($sql);
            
            if($result->num_rows !=0){
                echo "<h3>Records -</h3>";
                
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
    
               echo  "
    <tbody>
    
    <th>{$row['plname']}</th>
    <th>{$row['pfname']}</th>
    <th>{$gender}</th>
    
      <tr>
        <td>{$row['dob']}</td>
        <td>{$cat}</td>
        <td>{$row['paddress']}</td>
      </tr>
      
      <tr>
      <td>{$row['phone']} </td>
      </tr>
    </tbody>";
    
    $flag = 1;
    }else{
                echo "No Such Registration Found!";
                exit();
                $flag = 0;
            }
    
if($flag==1){   
    $sqltoken = "SELECT * from tokens where pnid='{$pnid}'";
    $res = $conn->query($sqltoken);
    $row = $res->fetch_assoc();
    if($res->num_rows != 0){
    echo "Token Found : <h1>{$row['refid']}</h1> Created At - {$row['created_at']}";

}else{
    echo "<p style=\"color:red\"><br>Couldnt find associated token! Try creating a new token!<br><br></p>";
}
        }
        }
$conn->close();
?>
    </table>