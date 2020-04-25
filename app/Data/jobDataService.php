<?php
namespace App\Data;

use App\Data\Database;
use PDO;
use App\Models\JobModel;

class jobDataService
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
     * Selects all the jobs in the database and sends them back to the controller as a array of jobs
     * @param String $company, String $position, String $description
     */
    function createJob($c, $p, $d) {
        $stmt = $this->db->prepare("INSERT INTO `job` (`ID`, `COMPANY`, `POSITION`, `DESCRIPTION`) 
                                    VALUES (NULL, '$c', '$p', '$d')");
        $stmt->execute();        
    }
    
    /**
     * Selects all the jobs in the database and sends them back to the controller as a array of jobs
     * @param 
     */
    function findAllJobs() {
        
        $stmt = $this->db->prepare("SELECT * FROM `job`");
        $stmt->execute();
        
        $index = 0;
        $jobArray = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $job = new JobModel($row["ID"], $row["COMPANY"], $row["POSITION"], $row["DESCRIPTION"]);
            $jobArray[$index++] = $job;
        }
            return $jobArray;
        }
    
    /**
     * Updates a job posting in the database at the given jobID
     * @param int $id
     */
    function updateJob($c, $p, $d, $id){
        
        $stmt = $this->db->prepare("UPDATE `job` SET `COMPANY` = :company,`POSITION` = :position, `DESCRIPTION` = :description WHERE `ID`= :id");
        
        $stmt->bindParam(":company", $c);
        $stmt->bindParam(":position", $p);
        $stmt->bindParam(":description", $d);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
    
    /**
     * Deletes a job posting in the database at the given jobID
     * @param int $id
     */
    function deleteJob($id){
        $stmt = $this->db->prepare("DELETE FROM `job` WHERE `ID` = :id");
 
        $stmt->bindParam(":id", $id);
        
        $stmt->execute();
    }
    function findJobById($id) {
        $stmt = $this->db->prepare("SELECT `COMPANY`,`POSITION`,`DESCRIPTION` FROM `job` WHERE `ID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        $job = $stmt->execute();
        
        return $job;
    }
    
    /**
     * Selects all the jobs in the database and sends them back to the controller as a array of jobs
     * @param
     */
    function findJobsBySearch($search) {
        
        $stmt = $this->db->prepare("SELECT * FROM `job` WHERE `POSITION` LIKE '%$search%' OR `DESCRIPTION` LIKE '%$search%'");
        $stmt->execute();
        
        $jobArray = [];
        while ($job = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($jobArray, $job);
        }
        
        return $jobArray;
    }
    
    function findJobByPosition($pos) {
        $stmt = $this->db->prepare("SELECT * FROM `job` WHERE `POSITION` = :position");
        $stmt->bindParam(":position", $pos);
        $stmt->execute();
        $job = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($job, $row);
        }
        return $job;
    }
}
    

    