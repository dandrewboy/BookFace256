<?php
namespace App\Data;
use \mysqli;

class Database
{
    public static $dbservername = "mysql://cpa2x3j50comoskq:vbgoptiv8b9fmfhn@u6354r3es4optspf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/yzfvhkd5t9795iqb:3306";
    public static $dbusername = "cpa2x3j50comoskq";
    public static $dbpassword = "vbgoptiv8b9fmfhn";
    public static $dbname = "yzfvhkd5t9795iqb";
    
    public function getConnection(){
        $conn =new mysqli($this->dbservername, $this->dbusername, $this->dbpassword, $this->dbname);
        if($conn->connect_error) {
            echo "Connection failed" .$conn->connect_error . "<br>";
            exit;
        } else
            return $conn;
    }
}

