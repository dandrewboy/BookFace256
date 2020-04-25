<?php
namespace App\Business;
use App\Data\Database;
use App\Data\userDataService;
use App\User;
use App\Models\CredentialsModel;
use App\Models\UserModel;
use App\Utility\AppLogger;
use PDO;


class securityService
{
    

    public function __construct()
    {
        
    }
    
    function authenticate(CredentialsModel $cred)
    {
        AppLogger::info("Entering securityService.authenticate()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       // Checking for if the user netered information in not an empty string. If so we return false
        if ($cred->getUsername() == "" || $cred->getPassword() == "") {
            return false;
        }
        
        // Create an instance of userDataService and pass the connection to the database. We call the findByUserNameAndPassword method
        // from the data service and get an array. If the array is not empty we create a user out of the information in the array
        // and send it back to the controller. Otherwise we return null.
        AppLogger::info("Calling the userDataService.findByUserNameAndPassword()");
        $uds = new userDataService($db);
        $userArray = $uds->findByUserNameAndPassword($cred);
        
        if($userArray != null){
            $user = new UserModel(
                $userArray['userid'],
                $userArray['firstname'],
                $userArray['lastname'],
                new CredentialsModel($userArray['username'], $userArray['password']),
                $userArray['active'],
                $userArray['role']
                );
            // Check to see if the user has there account blocked. If it has been, then prevent the user from logging in
            // and inform them that their account has been blocked.
            AppLogger::info("Checking if the user account is blocked");
            if($userArray['active'] != 1) {
                AppLogger::info("Leaving securityService and informing the user that their account is blocked");
                echo "Your acount is temperarily inactive.";
                return null;
            }
            AppLogger::info("Leaving securityService and passing a user to the controller");
            return $user;
        }
        else{
            AppLogger::info("Leaving securityService without a user");
            return null;
        }
        //Close connection to the database
        $db = null;
    }
}

