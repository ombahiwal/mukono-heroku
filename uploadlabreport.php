<html>
<?php
    session_start();
include('dbcon.php');
    $uid = 0;
if(!isset($_SESSION['unid'])){
    
     echo "
             <br> Redirecting...</h3>
             <script> window.location='userlogin.php'
        </script>
             ";
}else{
    $uid = $_SESSION['user']['uid'];
}
if(isset($_POST["submit"])) {
    
// Credentials
    $recid = $_POST['recid'];
    $pnid = $_POST['pnid'];
    $token = $_POST['token'];
    $inference = $_POST['inference'];
// Check Directory of PNID, If not then create
    $path = "labreports/{$pnid}";
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
    
// Code for File Upload 
    
    $uploadOk = 1;
    $target_dir = "labreports/{$pnid}/";
    $countfiles = count($_FILES['file']['name']);
//    echo $countfiles;
//    print_r($_FILES['file']['name']);
    if($countfiles !=0 && $_FILES['file']['name'][0] ){
        
        for($i=0;$i<$countfiles;$i++){
        // Check file size
            
        if ($_FILES["file"]["size"][$i] > 500000) {
          echo "<br>Sorry, your file is too large.<br>";
          $uploadOk = 0;
        }
        // Check if file already exists

            // Allow certain file formats
        
        $target_file = $target_dir . basename($_FILES["file"]["name"][$i]);
           echo "<br>Target File : ".$target_file;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType !='xls') {
          echo "<br>Sorry, only PDF, Doc, DOCX & XLS Type of files are allowed!<br>";
          $uploadOk = 0;
        }

        // Check Upload OK Flag
           if($uploadOk == 1){

               $filename = $recid."_".$pnid."_".date('dmYhis')."_".($i+1).".".pathinfo($target_file,PATHINFO_EXTENSION);
//              $filename = $_FILES['file']['name'][$i];
              // Upload file
              if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$target_dir.$filename)){
                  // File Upload Success
                echo "<p><b>Report File -".($i+1)." Uploaded Successfully!</b></p>";   
              }else{
                  // File Upload Failure;
                  echo "<p class=\"smallerror\" style=\"color:red\"><b>Couldnot Upload File. Due to some System Error.</b></p>";
              }

           }
        }
    }else{
         echo "<b>No Files Selected to Upload.</b>";
            $uploadOk = 0;
        }
    
    
// Code for Database Interaction.
    //- Upload and path 2. Update Token to active = '8' 3. Update Lab rec active = '0', Add Inference notes and Report Path.
    
    // Update Token to 8 - report ready
    if($uploadOk ==1){
        
        if($conn->query("UPDATE opd_prescription SET labtestinference='{$inference}', labrecid='{$recid}' WHERE  pnid ='{$pnid}' and ptoken = '{$token}' and active='1' ")){
            echo "<h4>Prescription Record Updated!</h4>";
        }else{
            echo "<h4>Couldnt Update Prescription!</h4>";
        }
        
        
        if($conn->query("UPDATE tokens set active='8' where refid='{$token}'")){
         echo "<p><b>Token Updated to 'Report Ready'!</b></p>";
            // Add Inference Notes and report path to labrec and
                // Update Lab Record active to 0 - Complete
                if($conn->query("UPDATE lab_records set active='0', inference='{$inference}', report='{$target_dir}', tested_by='{$uid}' where recid='{$recid}'")){
                    echo "<h3>Lab Record Complete!</h3>";
                }else{
                    echo "Couldnot Complete Record, still active.";
                }

        }else{
            echo "<br>Couldnot update token.";
        }
    }else{
        echo "<br>Token not Updated due to some issues.";
    }
    
    
}else{
    echo "Requests Not Set! ";
}

?>
<h4><a href="lab.php">Go_Back</a></h4>
</html>