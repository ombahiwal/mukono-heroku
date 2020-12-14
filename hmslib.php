<?php
/*
Library for the function in MMC HMS.
Author : Omkar Bahiwal


*/




// Mysql database credentials. 
$token = 0;

 $user ="root";
 $password = 'root';
 $db = 'mukono-master';
 $host = 'localhost';
 $port = 8889;
 $servername = $host;
 $username = $user;
 $dbname = $db;
//$pname = $_POST['pname'];

// Create connection with the DB
 $conn = new mysqli($servername, $username, $password, $dbname);


class Tokens{

    private $user;
    private $password;
    private $db;
    private $host;
    private $post;
    private $servername;
    private $username;
    private $dbname;
    public $conn;
        
    
    
   function __construct(){
       
 $this->token = 0; 
 $this->user ="root";
 $this->password = 'root';
 $this->db = 'mukono-master';
 $this->host = 'localhost';
 $this->port = 8889;
 $servername = $this->host;
 $username = $this->user;
 $dbname = $this->db;
//$pname = $_POST['pname'];

// Create connection with the DB
 $this->conn = new mysqli($servername, $username, $this->password, $dbname);

   }

//echo "Connected!";
// Check connection


// init the values of connection.    
    
    function set_token_number($tkinput){
        $this->name = $tkinput;
    }
    
    // function to fetch the status of the token.
    function fetch_token_type($tkinput){
        $tokentypesql = "SELECT active from tokens where token = '{$tkinput}'";
        $row = $res->fetch_assoc();
        return $row['active'];
    } 
    
    // function to update token to a desired status.
    function update_token($tkinput, $updateto){
        
        $sql = "UPDATE tokens set active='{$updateto}' where refid='{$tkinput}'";
                     $result = $conn->query($sql);
        if($result){
            return 1;
        }else{
            return 0;
        }
    }
    
    // function to print tokens by its type. 
    function print_tokens($type){
        $sql = "SELECT * from tokens where active ='{$type}'";
        $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
        echo "<h4>".$row['refid']."<input type=\"radio\" name=\"doctoken\" value=\"{$row['refid']}\"> </h4>";
                    }
    }
    
    // Returns an assoc array of token numbers of particular type.
    
    function fetch_tokens($type){
        $sql = "SELECT * from tokens where active ='{$type}'";
        $arr = [];
        $result= $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
        array_push($arr, $row['refid']);
                    }
        return $arr;
    }

    function __destruct(){
        $this->conn->close();
    }
    
} //end of token class
    
//    $t1 = new Tokens();
    

//pharmacy 

?>