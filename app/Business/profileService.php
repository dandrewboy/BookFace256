<?php
namespace App\Business;
use App\Data\Database;
use App\Data\userDataService;
use App\User;
use App\Models\CredentialsModel;
use App\Models\SkillModel;
use App\Models\UserModel;
use App\Models\ProfileModel;
use App\Utility\AppLogger;
use PDO;
use App\Models\JobHistoryModel;
use App\Models\EducationModel;


class profileService
{
    

    public function __construct()
    {
        
    }
    
    function update(ProfileModel $pro, UserModel $user, $id)
    {
        AppLogger::info("Entering profileService.update()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
        // Checking to see if the user left any feilds blank that they where updating. If any feilds are left as empty string the method
        // returns false.
        AppLogger::info("Checking if any variables are empty");
        if ($user->getFirstname() == "" || $user->getLastname() == "" || $pro->getEmail() == ""||
            $pro->getPhonenumber() == "") {
                return false;
            }
            
            // Create a new instance of the userDataService and pass the database connection. Then the method set a proArray variable equal
            // to the results of the userDataServices updateProfile method. Then uses that information to populate a new profile method and
            // passes it back to the controller.
            $uds = new userDataService($db);
            AppLogger::info("Leaving profileService to the userDataService.updateProfile()");
            $proArray = $uds->updateProfile($user->getFirstname(), $user->getLastname(), $pro->getEmail(), 
                $pro->getPhonenumber(), $id);
            
            if($proArray != null) {
                $prof = new ProfileModel(
                    $proArray['profileID'],
                    $proArray['email'],
                    $proArray['phonenumber']
                    );
                AppLogger::info("Exiting profileService with an updated profile");
                return $prof;
            }
        //Close connection to the database
        $db = null;
    }
    
    function create(ProfileModel $pro) {
        /*
         * This method creates a new user profile. After checking if any relivent data variable is left empty,
         * if none are empty then the method calls a new instance of the userDataService and calls the makeNewProfile method
         * where a new profile is added to the database.
         */
        AppLogger::info("Entering profileService.create()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Checking for empty variables");
        if($pro->getEmail() == ""|| $pro->getPhonenumber() == "") {
            
            return false;
        }
        
        $uds = new userDataService($db);
        AppLogger::info("Leaving profileService to userDataService.makeNewProfile()");
        $uds->makeNewProfile($pro->getEmail(), $pro->getPhonenumber());
            //Close connection to the database
        AppLogger::info("Exiting profileService");
            $db = null;
                
    }
    function profileSearch($id) {
        // Searches for a profile id searching with the users id and retunr the profile id. This will be used in findProfile to use the 
        // profile id to search for a users profile.
        AppLogger::info("Entering profileService.profileSearch()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create a new instance of the userDataService to call findProfileIdByUserId
        $uds = new userDataService($db);
        
        AppLogger::info("Leaving profileService to call the findProfileIdByUserId() at userDataService");
        $profileID = $uds->findProfileIdByUserId($id);
 
        AppLogger::info("Exiting profileService with the Profile Id");
        return $profileID;
        //Close connection to the database
        $db = null;
    }
    function findProfile($id) {
        // Searches the database using the profile id to find a users profile information if they have any.
        AppLogger::info("Entering profileService.findProfile");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create a new instance of the userDataService to call the findProfilebyId method
        AppLogger::info("Leaving profileService to call findProfileById() at userDataService");
        $uds = new userDataService($db);
        return $uds->findProfileById($id);
        
        
        //Close connection to the database
        AppLogger::info("Exiting profileService with the users profile");
        $db = null;
    }
    
    function removeProfile($id) {
        /*
         * Create a new instance of the userDataService and call the method deleteProfileByUserId(). This allows either the user of the
         * account or an Admin to delete a user account
         */
        AppLogger::info("Entering profileService.removeProfile");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create a new instance of the userDataService to call the findProfilebyId method
        AppLogger::info("Leaving profileService to call deleteProfileByUserId() at userDataService");
        $uds = new userDataService($db);
        $uds->deleteProfileByUserId($id);
        
        
        //Close connection to the database
        AppLogger::info("Exiting profileService");
        $db = null;
    }
    public function getAllProfiles(){
        /*
         * This responds to a request from the presentaion layer to retrive and send back all of the profiles in the database
         */
        AppLogger::info("Entering profileService.getAllProfiles()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $service = new userDataService($db);
        AppLogger::info("Exiting findAllProfile()");
        return $service->findAllProfiles();
        
        $db = null;
        
    }

    
    public function getJobHistory($id) {
        /*
         * Handles a request from the presentation layer to retrive a users job history and send it back to the presentation layer.
         */
        AppLogger::info("Entering profileService.getJobHistory()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $service = new userDataService($db);
        AppLogger::info("Exiting getJobHistory()");
        return $service->findJobHistoryById($id);
        
        $db = null;
        
    }
    function addJobHistory(JobHistoryModel $jh) {
        /*
         * Create a new instance of the userDataService and call the method createJobHistory. This lets the user add a new entry in their 
         * job history for their profile.
         */
        AppLogger::info("Entering profileService.addJobHistory()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Checking for empty variables");
        if($jh->getTitle() == ""|| $jh->getCompany() == "" || $jh->getDate() == "" || $jh->getUserID() == "") {
            
            return false;
        }
        
        $uds = new userDataService($db);
        AppLogger::info("Leaving profileService to userDataService.createJobHistory()");
        $uds->createJobHistory($jh->getTitle(), $jh->getCompany(), $jh->getDate(), $jh->getUserID());
        //Close connection to the database
        AppLogger::info("Exiting profileService");
        $db = null;
        
    }
    public function editJobHistory(JobHistoryModel $jh, $id)
    {
        /*
         * Handles a request made by the presentation layer to update the information in a users job history
         */
        AppLogger::info("Entering profileService.update()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Checking to see if the user left any feilds blank that they where updating. If any feilds are left as empty string the method
        // returns false.
        AppLogger::info("Checking if any variables are empty");
        if ($jh->getTitle() == "" || $jh->getCompany() == "" || $jh->getDate() == "" || $id == "") {
                return false;
            }
            
            // Create a new instance of the userDataService and pass the database connection. Then the method set a proArray variable equal
            // to the results of the userDataServices updateProfile method. Then uses that information to populate a new profile method and
            // passes it back to the controller.
            $uds = new userDataService($db);
            AppLogger::info("Leaving profileService to the userDataService.updateJobHistory()");
            $uds->updateJobHistory($jh->getTitle(), $jh->getCompany(), $jh->getDate(), $id);
            
            
    }
    public function removeJobHistory($id){
    /*
     * Create a new instance of the userDataService and call the method deleteJobHistory(). This allows either the user of the
     * account to remove an entry in their job history
     */
    AppLogger::info("Entering profileService.removeJobHisroty");
    $servername = Database::$dbservername;
    $username = Database::$dbusername;
    $password = Database::$dbpassword;
    $dbname = Database::$dbname;
    
    //Get connection to the database
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create a new instance of the userDataService to call the findProfilebyId method
    AppLogger::info("Leaving profileService to call deleteJobHistory() at userDataService");
    $uds = new userDataService($db);
    $uds->deleteJobHistory($id);
    
    
    //Close connection to the database
    AppLogger::info("Exiting profileService");
    $db = null;
    }
    
    public function getEducation($id) {
        /*
         * Handles a request from the presentation layer to retrive a users education and send it back to the presentation layer.
         */
        AppLogger::info("Entering profileService.getEducation()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $service = new userDataService($db);
        AppLogger::info("Exiting getEducation()");
        return $service->findEducationById($id);
        
        $db = null;
        
    }
   
    function addEducation(EducationModel $em) {
        /*
         * Create a new instance of the userDataService and call the method createEducation. This lets the user add a new entry in their
         * job history for their profile.
         */
        AppLogger::info("Entering profileService.addEducation()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Checking for empty variables");
        if($em->getSchool() == ""|| $em->getLevel() == "" || $em->getDate() == "" || $em->getUserID() == "") {
            
            return false;
        }
        
        $uds = new userDataService($db);
        AppLogger::info("Leaving profileService to userDataService.createEducation()");
        $uds->createEducation($em->getSchool(), $em->getLevel(), $em->getDate(), $em->getUserID());
        //Close connection to the database
        AppLogger::info("Exiting profileService");
        $db = null;
        
    }
    public function editEducation(EducationModel $em, $id)
    {
        /*
         * Handles a request made by the presentation layer to update the information in a users Education
         */
        AppLogger::info("Entering profileService.update()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Checking to see if the user left any feilds blank that they where updating. If any feilds are left as empty string the method
        // returns false.
        AppLogger::info("Checking if any variables are empty");
        if ($em->getSchool() == "" || $em->getLevel() == "" || $em->getDate() == "" || $id == "") {
            return false;
        }
        
        // Create a new instance of the userDataService and pass the database connection. Then the method set a emArray variable equal
        // to the results of the userDataServices updateEducation method. Then uses that information to populate a new education model and
        // passes it back to the controller.
        $uds = new userDataService($db);
        AppLogger::info("Leaving profileService to the userDataService.updateEducation()");
        $uds->updateEducation($em->getSchool(), $em->getLevel(), $em->getDate(), $id);
        AppLogger::info("Exiting profileService with an updated education");
            
        
    }
    public function removeEducation($id){
        /*
         * Create a new instance of the userDataService and call the method deleteEducation(). This allows either the user of the
         * account to remove an entry in their job history
         */
        AppLogger::info("Entering profileService.removeEducation");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create a new instance of the userDataService to call the findProfilebyId method
        AppLogger::info("Leaving profileService to call deleteEducation() at userDataService");
        $uds = new userDataService($db);
        $uds->deleteEducation($id);
        
        
        //Close connection to the database
        AppLogger::info("Exiting profileService");
        $db = null;
    }
    
    public function getSkills($id) {
        /*
         * Handles a request from the presentation layer to retrive a users skills and send it back to the presentation layer.
         */
        AppLogger::info("Entering profileService.getSkills()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $service = new userDataService($db);
        AppLogger::info("Exiting getSkills()");
        return $service->findSkillsById($id);
        
        $db = null;
        
    }
    
    function addSkill(SkillModel $sm) {
        /*
         * Create a new instance of the userDataService and call the method createSkill. This lets the user add a new entry in their
         * job history for their profile.
         */
        AppLogger::info("Entering profileService.addSkill()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        AppLogger::info("Checking for empty variables");
        if($sm->getTitle() == ""|| $sm->getDescription() == "" || $sm->getUserID() == "") {
            
            return false;
        }
        
        $uds = new userDataService($db);
        AppLogger::info("Leaving profileService to userDataService.createSkill()");
        $uds->createSkill($sm->getTitle(), $sm->getDescription(), $sm->getUserID());
        //Close connection to the database
        AppLogger::info("Exiting profileService");
        $db = null;
        
    }
    public function editSkill(SkillModel $sm, $id)
    {
        /*
         * Handles a request made by the presentation layer to update the information in a users Education
         */
        AppLogger::info("Entering profileService.update()");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Checking to see if the user left any feilds blank that they where updating. If any feilds are left as empty string the method
        // returns false.
        AppLogger::info("Checking if any variables are empty");
        if ($sm->getTitle() == "" || $sm->getDescription() == "" || $id == "") {
            return false;
        }
        
        // Create a new instance of the userDataService and pass the database connection. Then the method set a smArray variable equal
        // to the results of the userDataServices updateSkill method. Then uses that information to populate a new skill model and
        // passes it back to the controller.
        $uds = new userDataService($db);
        AppLogger::info("Leaving profileService to the userDataService.updateSkills()");
        $uds->updateSkill($sm->getTitle(), $sm->getDescription(), $id);
        AppLogger::info("Exiting profileService with an updated skills array");
       
    }
    public function removeSkill($id){
        /*
         * Create a new instance of the userDataService and call the method deleteSkill(). This allows either the user of the
         * account to remove an entry in their job history
         */
        AppLogger::info("Entering profileService.removeSkill");
        $servername = Database::$dbservername;
        $username = Database::$dbusername;
        $password = Database::$dbpassword;
        $dbname = Database::$dbname;
        
        //Get connection to the database
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create a new instance of the userDataService to call the findProfilebyId method
        AppLogger::info("Leaving profileService to call deleteSkill() at userDataService");
        $uds = new userDataService($db);
        $uds->deleteSkill($id);
        
        
        //Close connection to the database
        AppLogger::info("Exiting profileService");
        $db = null;
    }
}

