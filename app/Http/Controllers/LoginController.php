<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models;
use App\Models\CredentialsModel;
use App\Models\UserModel;
use App\Business\securityService;
use App\Models\ProfileModel;
use App\Utility\AppLogger;
use App\Business\profileService;
use App\Utility\ILoggerService;



class LoginController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }
   
    public function onLogin(Request $request) {
        try {
        // Create new instances of the Credentials and Profile models and the security and profile Services. The Credentials model is
        // populated with user entered data and the Profile model is populated by the users profile data found from the data base. 
        // This information is saved to the session for use in later parts of the application.
        
            $rules = ['login-name' => 'Required | Between:4,10 | Alpha',
                      'login-password' => 'Required | Between:4,10 | Alpha'];
            
            $this->validate($request, $rules);
            
        AppLogger::info("Entering LoginController.onLogin()");
        $cred = new CredentialsModel();
        $cred->setUsername($request->input('login-name'));
        $cred->setPassword($request->input('login-password'));
        
        $sec = new securityService();
        AppLogger::info("Leaving LoginController to call authenticate() at the securityService");
        $user = $sec->authenticate($cred);
        if($user != null) {
            \Session([
               'UserID' => $user->getUserID()
            ]);
            \Session([
                'Firstname' => $user->getFirstname()
            ]);
            \Session([
                'Lastname' => $user->getLastname()
            ]);
            
            \Session([
                'Role' => $user->getRole()
            ]);
       
        }
        if($user != null) {
            AppLogger::info("Exiting LoginController to the welcome page");
            return view('welcome');
        } else {
            AppLogger::info("Exiting LoginController to the login page");
            return view('login');
        }
    }
    catch(ValidationException $e1)
    {
        throw $e1;
    }
    catch(Exception $e2)
    {
        $this->logger->error("Exception: ", array("message" => $e2->getMessage()));
        throw new ValidationException("Database Exception: " . $e2->getMessage(), 0, $e2);
    }
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
