<?php
namespace App\Data;

use App\Utility\AppLogger;
use PDO;
use PDOException;
use App\Utility\DatabaseException;

class CommunityDataService
{
        private $db;
        
        /**
         * Passes the connection established in the business layer
         * @param $db
         */
        function __construct($db) {
            $this->db = $db;
        }
    
    /**
     * creates a new group and adds it to the database
     * @param String $company, String $position, String $description
     */
    public function findAllGroups()
    {
        /*
         * Using a SELECT SQL Statement in the groups table to find all of the groups and save them to an array
         */
        try{
        AppLogger::info("Entering CommunityDataService.findAllGroups()");
        AppLogger::info("Preparing SQL Statement");
        $sql_query = $this->db->prepare("SELECT * FROM `groups`");
        
        AppLogger::info("Executing SQL Statement");
        $sql_query->execute();
        
        $groupArray = [];
        while ($user = $sql_query->fetch(PDO::FETCH_ASSOC)) {
            array_push($groupArray, $user);
        }
        AppLogger::info("Exiting CommunityDataService with groups array");
        return $groupArray;
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
    
    /**
     * creates a new group and adds it to the database
     * @param String $company, String $position, String $description
     */
    public function createGroup($id, $name, $discrption)
    {
        /*
         * Using an INSERT SQL Statement int he groups table to create a new group
         */
        try {
            AppLogger::info("Entering CommunityDataService.createGroup()");
            AppLogger::info("Preparing SQL Statement");
            $stmt = $this->db->prepare("INSERT INTO `groups` (`GROUPID`, `NAME`, `user_userID`, `DISCRIPTION`)
                                        VALUES (NULL, '$name', '$id', '$discrption')");
            AppLogger::info("Executing SQL Statemet");
            $stmt->execute();
            AppLogger::info("Leaving CommunityDataService");
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
    
    /**
     * deletes a group and adds it to the database
     * @param String $company, String $position, String $description
     */
    public function deleteGroup($id)
    {
        /*
         * Using the DELETE SQL Statement in the groups table to delete a group from the database
         */
        try {
            AppLogger::info("Entering CommunityDataService.deleteGroup()");
            AppLogger::info("Preparing SQL Statement");
            $stmt = $this->db->prepare("DELETE FROM `groups` WHERE `GROUPID` = :id");
            
            $stmt->bindParam(":id", $id);
            
            AppLogger::info("Executing SQL Statement");
            $stmt->execute();
            AppLogger::info("Exiting CommunityDataService");
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
    
    /**
     * updates the members of a group and commits the changes to the database
     * @param String $company, String $position, String $description
     */
    public function createMember($fname, $lname, $gid, $id)
    {
        /*
         * Using the INSERT SQL Statement in the members table to add a new memeber to a group
         */
        try {
            AppLogger::info("Entering CommunityDataService.createMember()");
            AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("INSERT INTO `members` (`FIRSTNAME`, `LASTNAME`, `groups_GROUPID`, `ID`)
                                    VALUES ('$fname', '$lname', '$gid','$id')");
        AppLogger::info("Executing SQL Statement");
        $stmt->execute(); 
        AppLogger::info("Exiting CommunityDataService");
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
    
    /**
     * updates the members of a group and commits the changes to the database
     * @param String $company, String $position, String $description
     */
    public function deleteMember($id)
    {
        /*
         * Using the DELETE SQL Statement in the members table to delete a memeber from the group.
         */
        try {
            AppLogger::info("Entering CommunityDataService.deleteMemeber()");
            AppLogger::info("Preparing SQL Statement");
            $stmt = $this->db->prepare("DELETE FROM `members` WHERE `ID` = :id");
            
            $stmt->bindParam(":id", $id);
            
            AppLogger::info("Executing SQL Statement");
            $stmt->execute();
            AppLogger::info("Exiting CommunityDataService");
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
    /**
     * finds all the members of a group
     * @return $memebersArray
     */
    public function findAllMembers()
    {
        /*
         * Using a SELECT Statement in the memebers table to find all the memebers of a group. Then save the data into an array and pass
         * it back up the chain.
         */
        try{
            AppLogger::info("Entering CommunityDataService.findAllMembers()");
            AppLogger::info("Preparing SQL Statement");
        $sql_query = $this->db->prepare("SELECT * FROM `members`");
        
        AppLogger::info("Executeing SQL Statement");
        $sql_query->execute();
        
        $memberArray = [];
        while ($user = $sql_query->fetch(PDO::FETCH_ASSOC)) {
            array_push($memberArray, $user);
        }
        AppLogger::info("Exiting CommunityDataService with MembersArray");
        return $memberArray;
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
    }
}

