<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models;
use App\Models\CredentialsModel;
use App\Models\UserModel;
use App\Business\securityService;
use App\Models\ProfileModel;
use App\Utility\AdminException;
use App\Utility\AppLogger;
use App\Business\profileService;
use App\Business\adminService;
use App\Business\CommunityBusinessService;



class AdminController extends Controller
{
    public function onAdmin(Request $request) {
        try{
            /*
             * Create a new instance of the adminService to call the getUsers() method, passing an array of users to a Users page where
             * the data will be displayed.
             */
            AppLogger::info("Entering AdminController.onAdmin()");
            $user = new UserModel();
            $sec = new adminService();
            AppLogger::info("Leaving AdminController to adminService.getUsers()");
            $userArray = $sec->getUsers();
    
            $data = ['userArray' => $userArray];
            
            AppLogger::info("Exiting AdminController to Users page");
            return view('Users')->with($data);
        }
        catch(AdminException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new AdminException("Admin Exception: " . $e2->getMessage(), 0, $e2);
        }
        
    }
    
    public function stateChange(Request $request) {
        /*
         * Create a new instance of the adminService to call the updateStatus method to change the activity status of a user. Afterwards
         * the user is sent back to the welcome screen
         */
        try{
            AppLogger::info("Entering AdminController.statusChange()");
           $userStatus = $request->input('status');
           $userId = $request->input('id');
          
           $sec = new adminService();
          
           if($userStatus == 1){
               $userStatus = 0; 
           }
           else {
               $userStatus =1;
           }
           AppLogger::info("Leaving AdminController to adminService.updateState");
           $sec->updateState($userStatus,$userId);
           
           AppLogger::info("Exiting AdminController");
           return view('welcome');
        }
        catch(AdminException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new AdminException("Admin Exception: " . $e2->getMessage(), 0, $e2);
        }
       
    }
    
    public function deleteUser(Request $request) {
        /*
         * Create a new instance of adminService to call the delete method. This will remove a user and all relevent data in the database
         */
        try{
            AppLogger::info("Entering AdminController.deleteUser()");
            $userID = $request->input('id');
            $sec = new adminService();
            $csec = new CommunityBusinessService();
            $psec = new profileService();
            AppLogger::info("Leaving AdminController to adminService.delete()");
            $csec->leaveGroup($userID);
            $psec->removeProfile($userID);
            $sec->delete($userID);
            AppLogger::info("Exiting AdminController");
            return view('welcome');
        }
        catch(AdminException $e1)
        {
            throw $e1;
        }
        catch(Exception $e2)
        {
            AppLogger::error("Exception: ", array("message" => $e2->getMessage()));
            throw new AdminException("Admin Exception: " . $e2->getMessage(), 0, $e2);
        }
    }
}