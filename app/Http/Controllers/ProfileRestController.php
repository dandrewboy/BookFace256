<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\DTO;
use App\Utility\AppLogger;
use App\Business\securityService;
use App\Business\profileService;


class ProfileRestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            // Call Service to get all users
            $service = new profileService();
            $users = $service->getAllProfiles();
            
            
            //Create a DTO
            $dto = new DTO(200,"OK", $users);
            
            // Serialize the DTO to JSON
            $json = json_encode($dto);
            
            
            //Return JSON back to the caller
            return $json;
        }
        catch(Exception $e1){
            
            //Log exception
            AppLogger::error("Exception: ", array("message"=> $e1->getMessage()));
            // Return an error back to the user in the DTO
            $dto = new DTO(400, $e1->getMessage(),"");
            return json_encode($dto);
            
        }
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            // Call Service to get all users
            $service = new profileService();
            $user = $service->findProfile($id);
            $jh = $service->getJobHistory($id);
            $edu = $service->getEducation($id);
            $skills = $service->getSkills($id);
            $json = array_merge($user, $jh, $edu, $skills);
            //Create a DTO
            if($user == null)
                $dto = new DTO(400,"Profile Not Found", "");
                else
                    
                    $dto = new DTO(201,"OK", $json);
                    
                    // Serialize the DTO to JSON
                    $json = json_encode($dto);;
                    //Return JSON back to the caller
                    return $json;
        }
        catch(Exception $e1){
            
            //Log exception
            AppLogger::error("Exception: ", array("message"=> $e1->getMessage()));
            
            // Return an error back to the user in the DTO
            $dto = new DTO(-2, $e1->getMessage(),"");
            return json_encode($dto);
            
        }
    }
    
    
}
