<?php
namespace App\Data;

use App\Models\CredentialsModel;
use App\Models\ProfileModel;
use App\Models\UserModel;
use App\Utility\AppLogger;
use Illuminate\Support\Facades\Session;
use PDO;
use PDOException;
use App\Utility\DatabaseException;
use App\Models\JobHistoryModel;
use App\Models\EducationModel;
use App\Models\SkillModel;

class userDataService
{   
    private $db;
    
    /**
     * Passes the connection established in the business layer
     * @param $db
     */
    function __construct($db) {
        $this->db = $db;
    }
    public function findByUserNameAndPassword(CredentialsModel $cred)
    {
        AppLogger::info("Entering findByUserNameAndPassword");
        try {
        // Sets username and password to the passed variables from the Credentials model
        $username = $cred->getUsername();
        $password = $cred->getPassword();
     
        // SQL statement that selects a user
        AppLogger::info("Preparing a SELECT SQL statement for the users table");
        $stmt = $this->db->prepare("SELECT `userID`, `firstName`, `lastName`, `username`, `password`,
            `ACTIVE`,`ROLE` FROM `user` WHERE `username` =:username AND `password` =:password");
        // Binds the SQL variables for username and password to the variables from the Credentials model
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        
        // Executes the SQL statement using the bind paramenters
        AppLogger::info("Executing SELECT statement to find a user by username and password");
        $stmt->execute();
        
        // If SQL statement returns a user it fills an array with the users information 
        // from the database then passes the array back up the chain to the controller
        // Otherwise the method returns a Database Exception.
        if($stmt->rowCount()){
            
            AppLogger::info("Adding found user to an array");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $userArray = array(
                    "userid" => $row['userID'],
                    "firstname" => $row['firstName'],
                    "lastname" => $row['lastName'],
                    "username" => $username,
                    "password" => $password,
                    "active" => $row['ACTIVE'],
                    "role" => $row['ROLE']
                );
                AppLogger::info("Exiting findByUserNameAndPassword and passing user array to the business layer");
                return $userArray;
            }
          }
        }
        catch(PDOException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            
        }
        
    }
    
    public function makeNewUser($fn, $ln, $un, $pw, $ia, $rl) {
        
        
        AppLogger::info("Entering makeNewUser");
        
        // Using a SELECT statement we check to see if the new users username is valid. If the username is laready being used by another
        // user then the user will be instructed to pick a new username and try again.
        AppLogger::info("Checking if new users username is already in use.");
        $check = $this->db->prepare("SELECT `userID`, `firstName`, `lastName`, `username`, `password`,
            `ACTIVE`,`ROLE` FROM `user` WHERE `username` =:username");
        $check->bindParam(":username", $un);
        
        $check->execute();
        
        if($check->rowCount() == 0) {
        
        // Prepares a SQL statement to insert a new user into the users table of the database
        AppLogger::info("Prepairing a INSERT SQL statement for the users table");
        $stmt = $this->db->prepare("INSERT INTO `user` (`userID`, `firstName`, `lastName`, `username`, `password`,`ACTIVE`,`ROLE`)
                                     VALUES (NULL, '$fn', '$ln', '$un', '$pw','$ia','$rl')");
        
        // sets a variable result to equal the results of the executed SQL statement
        AppLogger::info("Executing INSERT SQL statement for adding a new user in the users table");
        $result = $stmt->execute();
        
        // Informs the user if they have succesfully created a new user or not
        if($result) {
            AppLogger::info("Leaving makeNewUser after successfully adding a new user");
            echo "Customer successfully added! <br>";
        } else
            AppLogger::info("Leaving makeNewUser after failing to add a new user");
            echo "Couldn't add a new customer.<br>";
        } else
        {
          AppLogger::info("Leaveing makeNewUser after user tired to use a pre-exsisting username");
          echo "username already exsists, please select a new username and try again.<br>";
            
        }
            
    }

    public function updateProfile($fn, $ln, $em, $pn, $id) 
    {
        // Using a UPDATE SQL Statement for the profile table searching with the id variable passed to the method we update a users profile
        // with the user provided data
        AppLogger::info("Entering userDataService.updateProfile()");
        AppLogger::info("Preparing SQL Statement");
        $stmt =$this->db->prepare("UPDATE `profile` SET `email` = :email,`phonenumber` = :phonenumber WHERE `profileID`= :id");
                
                $stmt->bindParam(":email", $em);
                $stmt->bindParam(":phonenumber", $pn);
                $stmt->bindParam(":id", $id);
                
                AppLogger::info("Executing SQL Statement");
                $stmt->execute();
                
        // Using a UPDATE SQL Statement for the user table searching with id varaible passed to the method we update the users 
        // first and last name 
        AppLogger::info("Preparing SQL Statement");
        $stmt_u = $this->db->prepare("UPDATE `user` SET `firstname` = :firstname,`lastname` = :lastname WHERE `userID`= :id");
        
        $stmt_u->bindParam(":firstname", $fn);
        $stmt_u->bindParam(":lastname", $ln);
        $stmt_u->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt_u->execute();
        AppLogger::info("Exiting userDataService");
    }
    
    public function findProfileIdByUserId($id) {
        // Searches the database for a users profile id by using the users id number. 
        //This will be used to search for the users profile information later

        AppLogger::info("Entering userDataSerive.findProfileIdByUserId()");

        $profileID = null;
        AppLogger::info("Preparing SQL statement in findProfileIdByUserId()");
        $stmt = $this->db->prepare("SELECT `profileID` FROM `profile` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $profileID = $row['profileID'];
        }
        AppLogger::info("Exiting userDataService with Profile Id");
        return $profileID;
        
    }
    public function makeNewProfile($em, $pn) {
        /*
         * Using an INSERT SQL statement in the profile table we create a new profile for a user using their firstname and lastname
         * from the users table getting the id from the session and the profile information email, phonenumber, jobhistory, skills, and
         * education
         */
        AppLogger::info("Entering userDataService.makeNewProfile()");
        $userID = Session::get('UserID');
        
        AppLogger::info("Preparing SQL Statement");
        $sql_query = $this->db->prepare("INSERT INTO `profile` (`user_userID`,`profileID`, `email`, `phonenumber`) 
                                         VALUES ($userID, NULL, '$em', '$pn')");
        
        AppLogger::info("Executing SQL Statement");
        $result = $sql_query->execute();
        
        if($result) {
            AppLogger::info("Exiting userDataService creating a profile");
            echo "Profile successfully created! <br>";
        } else
            AppLogger::info("Exiting userDataService failing to create a profile");
            echo "Couldn't create a new profile.<br>";
    }
    public function findProfileById($id) {
        AppLogger::info("Entering userDataService.findProfileById()");
        // using the Profile Id we got from findrofileIdByUserId() we are searching the database for the users profile information by
        // the profile id.
        AppLogger::info("Prepare SQL Statement in findProfileById()");
        $sql_query = $this->db->prepare("SELECT `email`, `phonenumber`, `profileID` FROM `profile` WHERE `user_userID` = :id");

        $sql_query->bindParam(":id", $id);
        
        AppLogger::info("Execute SQL Statement in findProfileById");
        $sql_query->execute();
        
            $profileArray = [];
            while ($pro = $sql_query->fetch(PDO::FETCH_ASSOC)) {
                array_push($profileArray, $pro);
            }
            AppLogger::info("Exiting userDataService with profileArray");
            return $profileArray;
            }
            
      public function findUserById($id) {
          /*
           * Using a SELECT SQL Statement at the user table the method searches the users table by the users id.
           * If a user is found it is placed into an array of users and sent back up the chain.
           */
          AppLogger::info("Entering userDataService.findUserById()");
          AppLogger::info("Preparing SQL Statement");
            $stmt = $this->db->prepare("SELECT `userID`, `firstName`, `lastName`, `username`, `password`,
            `ACTIVE`,`ROLE` FROM `user` WHERE `userID` =:id");
            
            $stmt->bindParam(":id", $id);
            
            AppLogger::info("Execute SQL Statement");
            $stmt->execute();
            $userArray = [];
            while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($userArray, $user);
            }
            AppLogger::info("Exiting userDataService with userArray");
            return $userArray;
            
      }
      function deleteProfileByUserId($id){
      /*
       * Using the DELETE SQL Statement in the user table we can delete a users account from the database
       */
      try{
          AppLogger::info("Entering userDataService.deleteProfileByUserId");
          AppLogger::info("Prepare SQL Statement");
          $sql_query = $this->db->prepare("DELETE FROM `profile` WHERE `user_userID` = :id");
          
          $sql_query->bindParam(":id", $id);
          
          AppLogger::info("Execute SQL Statement");
          $sql_query->execute();
          AppLogger::info("Exiting userDataService");
      }
      catch(PDOException $e)
      {
          AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
          throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
          
      }
}
public function findAllProfiles(){
    
    
    try{
        
        //Select username and password and see if this wor exists
        $stmt = $this->db->prepare('SELECT profileID, email, phonenumber, FROM PROFILE');
        // $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        //See if user existed and return true if found else return false if not found
        //BAD PRACTICE: This is a business ules in our DAO!
        if($stmt->rowCount() ==0){
            
            return array();
        }
        else {
            $index = 0;
            $users = array();
            while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
                $user= new ProfileModel($row["profileID"], $row["email"], $row["phonenumber"]);
                $users[$index++]= $user;
            }
            return $users;
        }
        
    }
    catch (PDOException $e){
        //BEST EPRACTICE: Catch a; exceptions (do not swallow exceptions),
        // log the exception, do not throw technology specific exceptions,
        // and throw a custom exception
        AppLogger::error("Exception:", array("message" => $e->getMessage()));
        throw new DatabaseException("Database Exception:" . $e->getMessage(), 0, $e);
    }
}


public function findJobHistoryById($id) {
    /*
     * Using a SELECT SQL Statement on the job history table searching for the job history of a user by searching for the userID foreign
     * key. The results get stored into an array and get sent back to the presentation layer through the business layer.
     */
    try{
        AppLogger::info("Entering userDataService().findJobHistoryByIdRest()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("SELECT * FROM `jobhistory` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        if($id != null) {
            AppLogger:info("Executing SQL Stamtement");
            $stmt->execute();
            
            $jhArray = array();
            $index = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $jh = new JobHistoryModel($row["HISTORYID"], $row["TITLE"], $row["COMPANY"], $row["DATE"], $row["user_userID"]);
                $jhArray[$index++] = $jh;
            }
            AppLogger::info("Leaving findJobHistoryByIdRest() with an array of job history of a user");
            return $jhArray;
        }
        AppLogger::info("Leaving findJobHistoryByIdRest() without an array of job history of a user");
        return $jhArray;
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function createJobHistory($t, $c, $d, $u){
    /*
     * Using an INSERT SQL Statement a user adds to their job history in their profile page
     */
    try{
    AppLogger::info("Entering userDataService.createJobHistory()");
    AppLogger::info("Preparing SQL Statement");
    $stmt = $this->db->prepare("INSERT INTO `jobhistory` (`TITLE`, `COMPANY`, `DATE`, `user_userID`, `HISTORYID`) 
                                VALUE ('$t', '$c', '$d', '$u', NULL)");
    AppLogger::info("Executing SQL Statement");
    $stmt->execute();
    AppLogger::info("Leaving createJobHistory()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}
public function updateJobHistory($t, $c, $d, $id) {
    /*
     * Using a UPDATE SQL Statement the user can make changes to their job history entries listed in their profile.
     */
    try{
    AppLogger::info("Entering userDataService.updateJobHistory()");
    AppLogger::info("Preparing SQL Statement");
    $stmt = $this->db->prepare("UPDATE `jobhistory` SET `TITLE` = :title, `COMPANY` = :company, `DATE` = :date WHERE `HISTORYID` = :id");
    
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":title", $t);
    $stmt->bindParam(":company", $c);
    $stmt->bindParam(":date", $d);
    
    AppLogger::info("Executing SQL Statement");
    $stmt->execute();
    AppLogger::info("Leaving updateJobHistory()");
    } 
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
    
}
public function deleteJobHistory($id) {
    /*
     * Using the DELETE SQL Statement the user can delete a job history entry they submitted based off of the entries history id number.
     */
    try {
        AppLogger::info("Entering userDataService.deleteJobHistory()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("DELETE FROM `jobhistory` WHERE `HISTORYID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Exiting deleteJobHistory()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function deleteAllJobHistory($id) {
    /*
     * Using the DELETE SQL Statement the user can delete a job history entry they submitted based off of the entries history id number.
     */
    try {
        AppLogger::info("Entering userDataService.deleteAllJobHistory()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("DELETE FROM `jobhistory` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Exiting deleteAllJobHistory()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}


public function findEducationById($id) {
    /*
     * Using a SELECT SQL Statement on the job history table searching for the education of a user by searching for the userID foreign
     * key. The results get stored into an array and get sent back to the presentation layer through the business layer.
     */
    try{
        AppLogger::info("Entering userDataService().findEducationByIdRest()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("SELECT * FROM `education` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        $eduArray = [];
        
        if($id != null) {
            AppLogger:info("Executing SQL Stamtement");
            $stmt->execute();
            
            $index = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $edu = new EducationModel($row["EDUCATIONID"],$row["SCHOOL"], $row["LEVEL"], $row["DATE"], $row["user_userID"]);
                $eduArray[$index++] = $edu;
            }
            AppLogger::info("Leaving findEducationByIdRest() with an array of education of a user");
            return $eduArray;
        }
        AppLogger::info("Leaving findEducationByIdRest() without an array of education of a user");
        return $eduArray;
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function createEducation($s, $l, $d, $u){
    /*
     * Using an INSERT SQL Statement a user adds to their education in their profile page
     */
    try{
        AppLogger::info("Entering userDataService.createEducation()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("INSERT INTO `education` (`SCHOOL`, `LEVEL`, `DATE`, `user_userID`, `EDUCATIONID`)
                                VALUE ('$s', '$l', '$d', '$u', NULL)");
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Leaving createEducation()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}
public function updateEducation($s, $l, $d, $id) {
    /*
     * Using a UPDATE SQL Statement the user can make changes to their education entries listed in their profile.
     */
    try{
        AppLogger::info("Entering userDataService.updateEducation()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("UPDATE `education` SET `SCHOOL` = :school, `LEVEL` = :level, `DATE` = :date WHERE `EDUCATIONID` = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":school", $s);
        $stmt->bindParam(":level", $l);
        $stmt->bindParam(":date", $d);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Leaving updateEducation()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
    
}
public function deleteEducation($id) {
    /*
     * Using the DELETE SQL Statement the user can delete a education entry they submitted based off of the entries history id number.
     */
    try {
        AppLogger::info("Entering userDataService.deleteEducation()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("DELETE FROM `education` WHERE `EDUCATIONID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Exiting deleteEducation()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function deleteAllEducation($id) {
    /*
     * Using the DELETE SQL Statement the user can delete a education entry they submitted based off of the entries history id number.
     */
    try {
        AppLogger::info("Entering userDataService.deleteAllEducation()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("DELETE FROM `education` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Exiting deleteAllEducation()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function findSkillsById($id) {
    /*
     * Using a SELECT SQL Statement on the job history table searching for the skills of a user by searching for the userID foreign
     * key. The results get stored into an array and get sent back to the presentation layer through the business layer.
     */
    try{
        AppLogger::info("Entering userDataService().findSkillsByIdRest()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("SELECT * FROM `skills` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        $skillArray = [];
        
        if($id != null) {
            AppLogger:info("Executing SQL Stamtement");
            $stmt->execute();
            
            $index = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $skill = new SkillModel($row["SKILLID"],$row["TITLE"], $row["DESCRIPTION"], $row["user_userID"]);
                $skillArray[$index++] = $skill;
            }
            AppLogger::info("Leaving findSkillByIdRest() with an array of skills of a user");
            return $skillArray;
        }
        AppLogger::info("Leaving findSkillByIdRest() without an array of skills of a user");
        return $skillArray;
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function createSkill($t, $d, $u){
    /*
     * Using an INSERT SQL Statement a user adds to their skill in their profile page
     */
    try{
        AppLogger::info("Entering userDataService.createSkill()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("INSERT INTO `skills` (`TITLE`, `DESCRIPTION`, `user_userID`, `SKILLID`)
                                VALUE ('$t', '$d', '$u', NULL)");
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Leaving createSkill()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}
public function updateSkill($t, $d, $id) {
    /*
     * Using a UPDATE SQL Statement the user can make changes to their skill entries listed in their profile.
     */
    try{
        AppLogger::info("Entering userDataService.updateSkill()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("UPDATE `skills` SET `TITLE` = :title, `DESCRIPTION` = :description WHERE `SKILLID` = :id");
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $t);
        $stmt->bindParam(":description", $d);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Leaving updateSkill()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
    
}
public function deleteSkill($id) {
    /*
     * Using the DELETE SQL Statement the user can delete a skill entry they submitted based off of the entries history id number.
     */
    try {
        AppLogger::info("Entering userDataService.deleteSkill()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("DELETE FROM `skills` WHERE `SKILLID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Exiting deleteSkill()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}

public function deleteAllSkills($id) {
    /*
     * Using the DELETE SQL Statement the user can delete a skill entry they submitted based off of the entries history id number.
     */
    try {
        AppLogger::info("Entering userDataService.deleteAllSkills()");
        AppLogger::info("Preparing SQL Statement");
        $stmt = $this->db->prepare("DELETE FROM `skills` WHERE `user_userID` = :id");
        
        $stmt->bindParam(":id", $id);
        
        AppLogger::info("Executing SQL Statement");
        $stmt->execute();
        AppLogger::info("Exiting deleteAllSkills()");
    }
    catch(PDOException $e)
    {
        AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
        throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        
    }
}
    }
