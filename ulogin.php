<?php
include('dbcon.php');
if(isset($_POST['pswd'])){
    $sql = "SELECT * from users where email='{$_POST['uname']}'";
    
    
    $result = $conn->query($sql);

    if($result->num_rows==1){
        $row = $result->fetch_assoc();
            if(password_verify($_POST['pswd'],$row['pwd'])){
        
        
      
//   
        session_start();
        
        $_SESSION["unid"] = $row['unid'];
        $_SESSION["uid"] = $row['uid'];
        $_SESSION["user"] = $row;
        
        $sql_update = "UPDATE users SET online_status = '1' where unid = '{$_SESSION['unid']}'";
        
        $res = $conn->query($sql_update);
        
        if($res){
            echo "Online Status Updated!<br>";
            echo "<p> Hi, ".$row['fname']." ".$row['lname']." !</p>";
//    print_r($_SESSION['user']);
         $sqLoglogin = $conn->query("INSERT INTO login_stats (userid) values ('{$_SESSION['user']['uid']}')");
        
             echo "<h3> Logged in Successfully !
             <br> Redirecting...</h3>
             <script>  var timer = setTimeout(function() {
            window.location='index.php'
        }, 3000);
        </script>
             ";
            
        }else{
            echo "Couldn't Update Online Status!";
        }
    
    }else{
    echo "<h1>Invalid Login Credentials!</h1>";
    }
    }else{
        echo "No Record Found!";
    }
    
    
}






?>