<?php
namespace App\Business;

use App\Data\Database;
use App\Data\adminDataService;
use App\Utility\AppLogger;
use PDO;

class adminService
{
    function __construct() {
        
    }
    
    function getUsers() {
        /*
         * Creates a new instance of the adminDataService to call the method findAllUsers to retrive all the users from the database.
         * After receiving an array of users from the data service it returns it back to the controller.
         */
        AppLogger::info("Entering adminService.getUsers()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Leaving adminService to adminDataService.findAllUsers()");
        $ads = new adminDataService($db);
        $userArray = $ads->findAllUsers();
        
        //Close connection to the database
        $db = null;
        
        AppLogger::info("Exiting adminService with userArray");
        return $userArray;
        
    }
    function updateState($s, $id){
        /*
         * Creates a new instance of adminDataService to call the updateState method. We call this to change the state of a user in the
         * database between active an inactive.
         */
        AppLogger::info("Entering adminService.updateState");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Leaving adminService to adminDataService.updateState");
        $ads = new adminDataService($db);
        $ads->updateState($s, $id);
        
        //Close connection to the database
        AppLogger::info("Exiting adminService");
        $db = null;
    }
    
    function delete($id) {
        /*
         * Create a new instance of the adminDataService to call the deleteUserById method. This method gets called to delete a specific 
         * user and a data related to that user from the database
         */
        AppLogger::info("Entering adminService.delete()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Leaving adminService to adminDataService.deleteUserData()");
        $ads = new adminDataService($db);
        $ads->deleteUserById($id);
        
        //Close connection to the database
        AppLogger::info("Exiting adminService");
        $db = null;
    }
}

