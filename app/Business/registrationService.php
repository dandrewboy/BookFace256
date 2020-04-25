<?php
namespace App\Business;

use App\Data\Database;
use App\Data\userDataService;
use App\Models\UserModel;
use App\Models\CredentialsModel;
use PDO;
use App\Utility\AppLogger;


class registrationService
{  
    function __construct() {
        
    }
    
    function register(UserModel $user, CredentialsModel $cred) {
        
        AppLogger::info("Entering registrationService");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Checking if fitstname, last name, username, or password are entered as an empty string and if so returns false to the controller
        if($user->getFirstname() == "" || $user->getLastname() == "" || $cred->getUsername() == "" || $cred->getPassword() == "") {
            return false;
        }
        
        // If all inputed variable are valid, then we create a new instance of the userDataService and connect to the database
        // where we pass the user entered firstname, lastname, username, and password to the userDataService to register a new 
        // user in the databse
        $uds = new userDataService($db);
        $uds->makeNewUser($user->getFirstname(), $user->getLastname(), $cred->getUsername(), $cred->getPassword(),
            $user->getIsActive(),$user->getRole());
        AppLogger::info("Exiting the registrationService and passing user variables to the user data service");
        //Close connection to the database
        $db = null;
    }
}

