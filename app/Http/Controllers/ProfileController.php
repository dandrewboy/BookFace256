<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SessionHandler;
use App\Models;
use App\Models\CredentialsModel;
use App\Business\profileService;
use App\Models\ProfileModel;
use App\Models\UserModel;
use App\Utility\AppLogger;
use App\Data\userDataService;
use App\Utility\ProfileException;
use App\Models\JobHistoryModel;
use App\Models\EducationModel;
use App\Models\SkillModel;
use App\Business\securityService;


class ProfileController extends Controller
{
    
    public function onProfile(Request $request){
        /*
         * Creating a new instance of the profileService we make a request to retrive the users job history, education, and skills
         * information from the database. Once we have the information we pass that data along to the Profile view where it will be
         * displayed.
         */
        try
        {
           AppLogger::info("Entering ProfileController.onProfile()");
           $pros = new profileService();
           $jha = $pros->getJobHistory(Session::get('UserID'));
           $ea = $pros->getEducation(Session::get('UserID'));
           $sa = $pros->getSkills(Session::get('UserID'));
           $prof = $pros->findProfile(Session::get('UserID'));
           
           $data = ['JobHistoryArray' => $jha, 'EducationArray' => $ea, 'SkillsArray' => $sa, 'ProfileArray' => $prof];
           return View('Profile')->with($data);
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    public function onEditPro(Request $request) {
        /*
         * Create new instances of the Profile and User models to set all relevent information for the users profile. Afterward make
         * a new instance of the profileService and call the profileSearch method using the user id from the seesion. If no data is 
         * returned from the methos a new profile needs to be created otherwise the profile needs to be updated. To do these call the
         * 'update' and 'create' methods from the profileService using an if statement to call one or the other. Place all of the profile
         * data into the session.
         */
        try {
            AppLogger::info("Entering ProfileController.onEditPro()");
            $rules = ['Fname' => 'Required | Between:4,10 | Alpha',
                      'Lname' => 'Required | Between:4,10 | Alpha',
                      'email' => 'Required | Between:8,20 | Email',
                      'phone' => 'Required|regex:/[0-9]{10}/'];
            
            $this->validate($request, $rules);
            
            $pro = new ProfileModel();
            $user = new UserModel();
            $user->setFirstname($request->input('Fname'));
            $user->setLastname($request->input('Lname'));
            $pro->setEmail($request->input('email'));
            $pro->setPhonenumber($request->input('phone'));
            $pros = new profileService();
            AppLogger::info("Leaving ProfileController to profileService.profileSearch()");
            $id = $pros->profileSearch(Session::get('UserID'));
    
            if($id != null) {
                AppLogger::info("Leaving ProfileController to profileService.update()");
                $pros->update($pro, $user, $id);
            } else 
            {
                AppLogger::info("Leaving ProfileController to profileService.create()");
                $pros->create($pro);
            }
    
            \Session([
                'Firstname' => $user->getFirstname()
            ]);
            \Session([
                'Lastname' => $user->getLastname()
            ]);
           
            return view('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    public function onAddJobHistory(Request $request) {
        /*
         * Creating a new instance of the profileService we make a request to populate a new JobHistory Model with user inputed data 
         * and add it to the database.
         */
        try{
        AppLogger::info("Entering ProfileController.onAddJobHistory()");
        $jhm = new JobHistoryModel();
        $jhm->setTitle($request->input('Title'));
        $jhm->setCompany($request->input('Company'));
        $jhm->setDate($request->input('Date'));
        $jhm->setUserID(Session::get('UserID'));
        $pros = new profileService();
        $pros->addJobHistory($jhm);
        AppLogger::info("Exiting onAddJobHistory()");
        return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    public function onEditJobHistory(Request $request) {
        /*
         * Creating a new instance of the profile service we make a request to take an already exsisting job history entry and change it 
         * contents with user inputed data and save the changes to the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onEditJobHistory()");
            $jhm = new JobHistoryModel();
            $jhm->setTitle($request->input('Title'));
            $jhm->setCompany($request->input('Company'));
            $jhm->setDate($request->input('Date'));
            $id = $request->input('id');
            $pros = new profileService();
            $pros->editJobHistory($jhm, $id);
            
            AppLogger::info("Exiting onEditJobHistory()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    public function onDeleteJobHistory(Request $request) {
        /*
         * Creating a new instance of the profileService we make a request to delete a job history entry from the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onDeleteJobHistory()");
            $id = $request->input('id');
            $pros = new profileService();
            $pros->removeJobHistory($id);
            
            AppLogger::info("Exiting onDeleteJobHistory()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    public function onJobHistoryPass(Request $request) {
        $id = $request->input('id');
        $data = ['id' => $id];
        return View('EditJobHistory')->with($data);
    }
    
    public function onAddEducation(Request $request) {
        /*
         * Creating a new instance of the profileService we make a request to populate a new Education Model with user inputed data
         * and add it to the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onAddEducation()");
            $em = new EducationModel();
            $em->setSchool($request->input('School'));
            $em->setLevel($request->input('Level'));
            $em->setDate($request->input('Date'));
            $em->setUserID(Session::get('UserID'));
            $pros = new profileService();
            $pros->addEducation($em);
            
            AppLogger::info("Exiting onAddEducation()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    public function onEditEducation(Request $request) {
        /*
         * Creating a new instance of the profile service we make a request to take an already exsisting education entry and change it
         * contents with user inputed data and save the changes to the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onEditEducation()");
            $em = new EducationModel();
            $em->setSchool($request->input('School'));
            $em->setLevel($request->input('Level'));
            $em->setDate($request->input('Date'));
            $id = $request->input('id');
            $pros = new profileService();
            $pros->editEducation($em, $id);
            
            AppLogger::info("Exiting onEditEducation()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    public function onDeleteEducation(Request $request) {
        /*
         * Creating a new instance of the profileService we make a request to delete a education entry from the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onDeleteEducation()");
            $id = $request->input('id');
            $pros = new profileService();
            $pros->removeEducation($id);
            
            AppLogger::info("Exiting onDeleteEducation()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    public function onEducationPass(Request $request) {
        $id = $request->input('id');
        $data = ['id' => $id];
        return View('EditEducation')->with($data);
    }
    
    public function onAddSkill(Request $request) {
        /*
         * Creating a new instance of the profileService we make a request to populate a new Skill Model with user inputed data
         * and add it to the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onAddSkill()");
            $sm = new SkillModel();
            $sm->setTitle($request->input('Title'));
            $sm->setDescription($request->input('Description'));
            $sm->setUserID(Session::get('UserID'));
            $pros = new profileService();
            $pros->addSkill($sm);
            
            AppLogger::info("Exiting onAddSkill()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    public function onEditSkill(Request $request) {
        try{
            /*
             * Creating a new instance of the profile service we make a request to take an already exsisting skill entry and change it
             * contents with user inputed data and save the changes to the database.
             */
            AppLogger::info("Entering ProfileController.onEditSkill()");
            $sm = new SkillModel();
            $sm->setTitle($request->input('Title'));
            $sm->setDescription($request->input('Description'));
            $id = $request->input('id');
            $pros = new profileService();
            $pros->editSkill($sm, $id);
            
            AppLogger::info("Exiting onEditSkill()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    public function onDeleteSkill(Request $request) {
        /*
         * Creating a new instance of the profileService we make a request to delete a skill entry from the database.
         */
        try{
            AppLogger::info("Entering ProfileController.onDeleteSkill()");
            $id = $request->input('id');
            $pros = new profileService();
            $pros->removeSkill($id);
            
            AppLogger::info("Exiting onDeleteSkill()");
            return View('welcome');
        }
        catch(ProfileException $e)
        {
            AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
            throw new ProfileException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    public function onSkillPass(Request $request) {
        $id = $request->input('id');
        $data = ['id' => $id];
        return View('EditSkill')->with($data);
    }
}
    

