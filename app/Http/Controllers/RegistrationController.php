<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\registrationService;
use App\Models\UserModel;
use App\Models\CredentialsModel;
use App\Utility\AppLogger;
use App\Utility\RegistrationException;


class RegistrationController extends Controller
{
  
    public function onRegister(Request $request) {
        
        try {
            AppLogger::info("Entering RegistrationController.onRegister()");
            // Rules for data validation
            $rules = ['Fname' => 'Required | Between:4,10 | Alpha',
                      'Lname' => 'Required | Between:4,10 | Alpha',
                      'Uname' => 'Required | Between:4,10 | Alpha',
                      'pw' => 'Required | Between:4,10 | Alpha'];
            
            $this->validate($request, $rules);
            
            
            // Creates new instances of the User and Credential models and sets the firstname, lastname, username and password
            // from user input in the registration form
            $user = new UserModel();
            $cred = new CredentialsModel();
            $user->setFirstname($request->input('Fname'));
            $user->setLastname($request->input('Lname'));
            $cred->setUsername($request->input('Uname'));
            $cred->setPassword($request->input('pw'));
            
            AppLogger::info("Leaving Registration Controller to the registration business service");
            // Creates a new instance of the registrationService and passes the new models to the business service
            $rs = new registrationService(); 
            $rs->register($user,$cred);
        
            AppLogger::info("Exiting Registration controller");
            // returns to the logn page
            return view('Login');
            }
            catch(RegistrationException $e)
            {
                AppLogger::error("Exception: ", array("message: " => $e->getMessage()));
                throw new RegistrationException("Database Exception: " . $e->getMessage(), 0, $e);
            }
    }
}
