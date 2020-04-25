<?php
namespace App\Business;

use App\Data\Database;
use App\Data\CommunityDataService;
use PDO;
use App\Models\AffinityGroupModel;
use App\Data\userDataService;
use App\Models\UserModel;
use App\Utility\AppLogger;

class CommunityBusinessService
{
    
    /**
     * Processes a request to retrive all groups in the databse
     * @param
     */
    function getGroups()
    {
        /*
         * Create a new instance of the CommunityDataService to call the findAllGroups method to retrive all the groups from the database.
         * Then store the information into an array and pass it back up the chain.
         */
        AppLogger::info("Entering CommunityBusinessService.getGroups()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $cds = new CommunityDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.findAllGroups()");
        $groupArray = $cds->findAllGroups();
        
        //Close connection to the database
        $db = null;
        AppLogger::info("Exiting CommunityBusinessService with groupArray");
        return $groupArray;
        
    }
    
    /**
     * Processes a request to retrive all members in the databse
     * @param
     */
    function getMembers()
    {
        /*
         * Create a new instance of the CommunityDataService to call the findAllMemebers method to retrive all the memebrs for a group
         * and saving them to an array. Then passing the array back up the chain.
         */
        AppLogger::info("Entering CommunityBusinessService.getMemebers()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        $cds = new CommunityDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.findAllMemebers()");
        $memberArray = $cds->findAllMembers();
        
        //Close connection to the database
        $db = null;
        
        AppLogger::info("Exiting CommunityBusinessService with memebersArray");
        return $memberArray;
        
    }
    
    
    
    /**
     * Processes a request to add a group in the databse
     * @param
     */
    function addGroup(AffinityGroupModel $group)
    {
        /*
         * Create a new instance of CommunityDataService to call the createGroup method to add a new group to the database. 
         */
        AppLogger::info("Entering CommunityBusinessService.addGroup()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $cds = new CommunityDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.createGroup()");
        $cds->createGroup($group->getOwnerID(), $group->getName(), $group->getDiscription());
        
        AppLogger::info("Exiting CommunityBussinessService");
        $db = null;
        
    }
    
    /**
     * Processes a request to delete a group in the databse
     * @param
     */
    function removeGroup($id)
    {
        /*
         * Create a new instance of the CommunityDataService to call the deleteGroup method.
         */
        AppLogger::info("Entering CommunityBusinessService.removeGroup()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $cds = new CommunityDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.deleteGroup()");
        $cds->deleteGroup($id);
        
        AppLogger::info("Exiting CommunityBusinessService");
        $db = null;
    }
    
    /**
     * Processes a request to join a group in the databse
     * @param
     */
    function joinGroup($fname, $lname, $userID, $id)
    {
        /*
         * Create a new instance of the CommuintyDataService to call the createMember method.
         */
        AppLogger::info("Entering CommunityBussinessService.joinGroup()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $cds = new CommunityDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.createMember()");
        $cds->createMember($fname, $lname, $id, $userID);
        
        AppLogger::info("Exiting CommunityBussinessService");
        $db = null;
    }
    
    /**
     * Processes a request to leave a group in the databse
     * @param
     */
    function leaveGroup($id)
    {
        /*
         * Create a new instance of CommunityDataService to call the deleteMember method.
         */
        AppLogger::info("Entering CommunityBusinessService.leaveGroup()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $cds = new CommunityDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.deleteMemeber()");
        $cds->deleteMember($id);
        
        AppLogger::info("Exiting CommunityBusinessService");
        $db = null;
    }
    
    function findUser($id) {
        /*
         * Create new instance of CommunityDataService to call the findUserById method.
         */
        AppLogger::info("Entering CommunityBussinessService.findUser()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $uds = new userDataService($db);
        AppLogger::info("Leaving CommunityBusinessService to CommunityDataService.findUserById()");
        $user = $uds->findUserById($id);
        return $user;
        
        
        //Close connection to the database
        AppLogger::info("Exiting CommunityBusinessService");
        $db = null;
    }
}

