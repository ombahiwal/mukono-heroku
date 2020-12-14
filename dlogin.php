<?php
include('dbcon.php');
if(isset($_POST['pswd'])){
    $sql = "SELECT * from doctors where email='{$_POST['uname']}'";
    
    
    $result = $conn->query($sql);

    if($result->num_rows==1){
        $row = $result->fetch_assoc();
            if(password_verify($_POST['pswd'],$row['pwd'])){
        
        
      
//   
        session_start();
        
        $_SESSION["dnid"] = $row['dnid'];
        $_SESSION["docid"] = $row['docid'];
        $_SESSION["user"] = $row;
        
        $sql_update = "UPDATE doctors SET online_status = '1' where dnid = '{$_SESSION['dnid']}'";
        
        $res = $conn->query($sql_update);
        
        if($res){
            echo "Online Status Updated!<br>";
            echo "<p> Hi, Dr. ".$row['fname']." ".$row['lname']."</p>";
//    print_r($_SESSION['user']);
         $sqLoglogin = $conn->query("INSERT INTO login_stats (userid) values ('{$_SESSION['dnid']}')");
        
             echo "<h3> Logged in Successfully !
             <br> Redirecting...</h3>
             <script>  var timer = setTimeout(function() {
            window.location='doctor.php'
        }, 3000);
        </script>
             ";
            
        }else{
            echo "Couldn't Update Online Status!";
        }
    
    }else{
    echo "<h1>Invalid Login Credentials!</h1>";
                 echo "<h3>
             <br> Redirecting...</h3>
             <script>  var timer = setTimeout(function() {
            window.location='doctor.php'
        }, 3000);
        </script>
             ";
    }
    }else{
        echo "No Record Found!";
    }
    
    
}






?>