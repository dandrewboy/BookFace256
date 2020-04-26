<?php
namespace App\Business;

use App\Data\Database;
use PDO;
use App\Data\jobDataService;
use App\Models\JobModel;

class jobBusinessService
{
    
    /**
     * Processes a request to find all the jobs in the databse
     * @param 
     */
    public function getJobs() {
        //Database credentials
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $ser = new jobDataService($db);
        $jobArray = $ser->findAllJobs();
        
        return $jobArray;
        
        //Close connection to the database
        $db = null;
    }
    /**
     * Processes a request to create a new job posting 
     * @param int $id, String $company, String $position, String $description
     */
    public function postJob(JobModel $job) {
        //Database credentials
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $ser = new jobDataService($db);
        $ser->createJob($job->getCompany(), $job->getPosition(), $job->getDescription());
        
        //Close connection to the database
        $db = null;
    }
    /**
     * Process a request to edit a pre-exsisting job via its jobID
     * @param int $id
     */
    public function editJob(JobModel $job, $id) {
        //Databse credentials
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $ser = new jobDataService($db);
        $ser->findJobById($id);
        $ser->updateJob($job->getCompany(), $job->getPosition(), $job->getDescription(), $id);
        
        //Close connection to the database
        $db = null;
    }
    /**
     * Processes a request to remove a pre-exsisiting job posting from the database
     * @param int $id
     */
    public function removeJob($id){
        //Databse credentials
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $ser = new jobDataService($db);
        $ser->deleteJob($id);
        
        //Close connection to the database
        $db = null;
    }
    
    /**
     * 
     * @param String $search
     * @return array
     */
    public function searchJob($search) {
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $ser = new jobDataService($db);
        $jobArray = $ser->findJobsBySearch($search);
        
        return $jobArray;
        
        //Close connection to the database
        $db = null;
    }
    
    /**
     * 
     * @param String $pos
     * @return Object
     */
    public function jobPosition($pos){
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $ser = new jobDataService($db);
        $job = $ser->findJobByPosition($pos);
        
        return $job;
        
        //Close connection to the database
        $db = null;
    }
}

