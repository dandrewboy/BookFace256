<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\DTO;
use App\Utility\AppLogger;
use App\Business\securityService;
use App\Business\jobBusinessService;


class JobRestController extends Controller
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
            $service = new jobBusinessService();
            $users = $service->getJobs();
            
            
            //Create a DTO
            $dto = new DTO(200,"Returned all jobs", $users);
            
            // Serialize the DTO to JSON
            $json = json_encode($dto);
            
            
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
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($search)
    {
        try{
            // Call Service to get all users
            $service = new jobBusinessService();
            $user = $service->searchJob($search);
            
            //Create a DTO
            if($user == null)
                $dto = new DTO(400,"Job Not Found", "");
                else
                    $dto = new DTO(201,"Found Specified job", $user);
                    
                    // Serialize the DTO to JSON
                    $json = json_encode($dto);
                    
                    
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
