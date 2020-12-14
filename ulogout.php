<?php
session_start();

include('dbcon.php');
$sql_update = "UPDATE users SET online_status = '0' where unid = '{$_SESSION['unid']}'";
        
        $res = $conn->query($sql_update);
        
        if($res){
            echo "Online Status Updated!<br>";
            echo "<p> Bye, ".$_SESSION['user']['fname']." ".$_SESSION['user']['lname']."</p>";
//    print_r($_SESSION['user']);
        
            // Put Log of SignOut
            
            $sqLoglogout = $conn->query("INSERT INTO login_stats (userid, status) values ('{$_SESSION['unid']}','0')");
            
        
             echo "<h3> Logged Out Successfully !
             <br> Redirecting...</h3>
             <script>  var timer = setTimeout(function() {
            window.location='index.php'
        }, 3000);
        </script>
             ";
            
        }else{
            echo "Couldn't Update Online Status!";
        }

session_destroy();
?>
    
    
    
    
    