<?php
namespace App\Data;

use App\Data\Database;
use App\Utility\AppLogger;
use App\Utility\DatabaseException;
use PDO;
use PDOException;

class adminDataService
{
    private $db;
    
    /**
     * Passes the connection established in the business layer
     * @param $db
     */
    function __construct($db) {
        $this->db = $db;
    }

function findAllUsers() {
    /*
     * Using a SELECT SQL Statement in the user table to select all of the users from the database. Then returnd an array of users back to 
     * the business service
     */
    try{
        AppLogger::info("Entering adminDataService.findAllUsers()");
        AppLogger::info("Preparing SQL Statement");
        $sql_query = $this->db->prepare("SELECT * FROM `user`");
        
        AppLogger::info("Executing SQL Statement");
        $sql_query->execute();
        
        $userArray = [];
            while ($user = $sql_query->fetch(PDO::FETCH_ASSOC)) {
                array_push($userArray, $user);
            }
            AppLogger::info("Exiting adminDataService with userArray");
            return $userArray;
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
}
function updateState($s, $id) {
    /*
     * Using the UPDATE SQl Statement in the user table we can change the ACTIVE variable for a specific user
     */
    try{
        AppLogger::info("Entering adminDatService.updateState()");
        AppLogger::info("Preparing SQL Statement");
        $sql_query = $this->db->prepare("UPDATE `user` SET `ACTIVE` = :state WHERE `userID`= :id");
        
        $sql_query->bindParam(":id", $id);
        $sql_query->bindParam(":state", $s);
        
        AppLogger::info("Executing SQL Statement");
        $sql_query->execute();
        AppLogger::info("Exiting adminDataService");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
    }
    
    function deleteUserById($id) {
        /*
         * Using the DELETE SQL Statement in the user table we can delete a users account from the database
         */
        try{
            AppLogger::info("Entering adminDataService.deleteUserById");
            AppLogger::info("Prepare SQL Statement");
            $sql_query = $this->db->prepare("DELETE FROM `user` WHERE `userID` = :id");
            
            $sql_query->bindParam(":id", $id);
            
            AppLogger::info("Execute SQL Statement");
           $sql_query->execute();
           AppLogger::info("Exiting adminDataService");
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
}
    
    

