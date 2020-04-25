<?php
namespace App\Data;
use \mysqli;

class Database
{
    public static $dbservername = "localhost:3306";
    public static $dbusername = "root";
    public static $dbpassword = "root";
    public static $dbname = "cst-256-clc";
    
    public function getConnection(){
        $conn =new mysqli($this->dbservername, $this->dbusername, $this->dbpassword, $this->dbname);
        if($conn->connect_error) {
            echo "Connection failed" .$conn->connect_error . "<br>";
            exit;
        } else
            return $conn;
    }
}

