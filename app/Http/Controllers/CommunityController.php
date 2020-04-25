<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use SessionHandler;
use App\Models;
use App\Models\UserModel;
use App\Business\CommunityBusinessService;
use App\Models\AffinityGroupModel;
use App\Utility\AppLogger;
use App\Utility\CommunityException;



class CommunityController extends Controller
{
    
    /**
     * Method for pulling a list of Affinity Groups and displaying a list of them in a table when a user visits the Community Hub
     * @param Request $request
     */
    public function onCommunityHub(Request $request) {
        /*
         * Create a new instance of CommunityBusinessService and call getGroups() and getMembers() methods and save them to array variables.
         * Create a variable that holds the user id from the session along with a boolean variable called mTest and a int called mID. 
         * mTest start as false and becomes true if a member's user id is the same as the sessions user id. mID will hold that memebers 
         * user ID. Using a for each loop to check each memebers user id in a group then send the member and group arrays and the mTest 
         * and mID variables to the Community hub view where the information will be displayed.
         */
        try {
            AppLogger::info("Entering CommunityController.onCommunityHub()");
            $ser = new CommunityBusinessService();
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.getGroups()");
            $groupArray = $ser->getGroups();
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.getMembers()");
            $memberArray = $ser->getMembers();
            $id = session('UserID');
            $mTest = false;
            $mID = 0;
            $mGID = -1;
            AppLogger::info("Searching through members array for the current user id");
            foreach ($memberArray as $member){
                if($member['ID'] == $id)
                {
                    $mTest = true;
                    $mID = $member['ID'];
                    $mGID = $member['groups_GROUPID'];
                }
            }
            
            AppLogger::info("Exiting CommunityController with group and memebr data");
            return View('CommunityHub')->with(['groupArray' => $groupArray, 'member' => $mTest, 'memberID' => $mID, 'memberGID' => $mGID]);
        }
        catch(CommunityException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new CommunityException("Database Exception: " . $e2->getMessage(), 0, $e2);
        }
        
    }
    
    /**
     * Method for allowing a user to add an Affinity Group
     * @param Request $request
     */
    
        public function onAddGroup(Request $request) {
        /*
         * Create a new instance of AffinityGroupModel and use user provider information to fill out the variables. Then make a new
         * instance of CommunityBusinessService to call the addGroup method passing the AfinittyGroupModel to the business service
         */
        try {
            AppLogger::info("Entering CommunityController.onAddGroup()");
            $group = new AffinityGroupModel();
            $group->setName($request->input('name'));
            $group->setDiscription($request->input('discription'));
            $group->setOwnerID(Session::get('UserID'));
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.addGroup()");
            $ser = new CommunityBusinessService();
            $ser->addGroup($group);
            
            AppLogger::info("Exiting CommunityController");
            return View('welcome');
    }
    catch(CommunityException $e1)
    {
        throw $e1;
    }
    catch(Exception $e2)
    {
        AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
        throw new CommunityException("Database Exception: " . $e2->getMessage(), 0, $e2);
    }
        
        
    }
    
    /**
     * Method for allowing a user to join an exsisting Affinity Group
     * @param Request $request
     */
    public function onJoinGroup(Request $request) {
        /*
         * Create a new instance of CommunityBusinessService to call the findUser and joinGroup method. The find user method finds the
         * users information by searching the database with the user id from the session. It passes that information to the community 
         * service to add it to the group in the database.
         */
        try{
            AppLogger::info("Entering CommunityController.onJoinGroup");
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.findUser()");
            $ser = new CommunityBusinessService();
            $user = $ser->findUser(Session::get('UserID'));
            $id = ($request->input('id'));
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.joinGroup()");
            $ser->joinGroup($user[0]['firstName'], $user[0]['lastName'], $user[0]['userID'], $id);
            return View('welcome');
        }
        catch(CommunityException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new CommunityException("Database Exception: " . $e2->getMessage(), 0, $e2);
        }
        
        
    }
    
    /**
     * Method for allowing a user to leave an exsisting Affinity Group they have joined
     * @param Request $request
     */
    public function onLeaveGroup(Request $request) {
        /*
         * Create a new instance of the CommunityBusinessService to call the leave group method. 
         */
        try{
            AppLogger::info("Entering CommunityController.onLeaveGroup");
            $ser = new CommunityBusinessService();
            $id = $request->input('id');
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.leaveGroup()");
            $ser->leaveGroup($id);
    
            AppLogger::info("Exiting CommunityController");
            return View('welcome');
        }
        catch(CommunityException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new CommunityException("Database Exception: " . $e2->getMessage(), 0, $e2);
        }
        
        
    }
    
    /**
     * Method for allowing a user to delete an Affinity Group they had created
     * @param Request $request
     */
    public function onDeleteGroup(Request $request) {
        /*
         * Create a new instance of CommunityBusinessService to call the removeGroup method.
         */
        try{
            AppLogger::info("Entering CommunityController.onDeleteGroup()");
            $ser = new CommunityBusinessService();
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.leaveGroup()");
            $membersArray = $ser->getMembers();
            $id = $request->input('id');
            foreach($membersArray as $member){
                if($member['groups_GROUPID']  == $id) {
                    $ser->leaveGroup($member['ID']);
                }
            }
            $ser->removeGroup($id);
    
            AppLogger::info("Exiting CommunityController");
            return View('welcome');
        }
        catch(CommunityException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new CommunityException("Database Exception: " . $e2->getMessage(), 0, $e2);
        }
        
    }
    /**
     * Method for pulling a list of Affinity Groups and displaying a list of them in a table when a user visits the Community Hub
     * @param Request $request
     */
    public function onViewGroup(Request $request) {
        /*
         * Create a new instance of the CommunityBusinessService to call the getMemebersw method.
         */
        try{
            AppLogger::info("Entering CommunityController.onViewGroup");
            $ser = new CommunityBusinessService();
            AppLogger::info("Leaving CommunityController to CommunityBusinessService.getMemebers()");
            $memberArray = $ser->getMembers();
            $gId = $request->input('id');
            AppLogger::info("Exiting CommunityController");
            return view('ViewMembers')->with(['memberArray' => $memberArray, 'groupID' => $gId]);
        }
        catch(CommunityException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new CommunityException("Database Exception: " . $e2->getMessage(), 0, $e2);
        }
       
        }
}