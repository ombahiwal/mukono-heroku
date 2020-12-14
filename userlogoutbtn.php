 <div class="row">
        <div  class="col-sm-3">
            
        </div>
        <div class="col-sm-6"></div>
        <div class="col-sm-1">
       
        </div>
        <div class="col-sm-2">
        
            <?php 
            if(isset($_SESSION['uid'])){
                echo "<h4>Hello, {$_SESSION['user']['fname']} </h4>"; 
            echo '<a href="ulogout.php"><button class="btn-danger">Logout</button></a>';
            }else if(!isset($_SESSION['docid'])){
                echo '<p style="color:red"><center><b>Please Login to Access!</b></center></p>';
                exit();
            }
            ?>
             
        </div>
        
    </div>