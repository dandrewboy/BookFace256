<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobModel;
use App\Business\jobBusinessService;



class JobController extends Controller
{
    
    /**
     * Method for pulling a list of jobs from the database and sending it to the Job Admin page
     * @param Request $request
     */
    public function onJob(Request $request) {
        
        $ser = new jobBusinessService();
        $jobArray = $ser->getJobs();
        
        $data = ['jobArray' => $jobArray];
        
        return View('Job')->with($data);
       
    }
    
    /**
     * Sending a request the the database to create a new Job posting
     * @param Request $request
     */
    public function onJobPost(Request $request) {
        
        $job = new JobModel();
        $job->setCompany($request->input('company'));
        $job->setPosition($request->input('position'));
        $job->setDescription($request->input('description'));
        
        $ser = new jobBusinessService();
        $job = $ser->postJob($job);
        
        return view('welcome');
    }
    
    /**
     * sending a request to Update a pre-exsisting job in the database
     * @param Request $request
     */
    public function onJobEdit(Request $request) {
        $id = $request->input('id');
        $job = new JobModel();
        $job->setCompany($request->input('company'));
        $job->setPosition($request->input('position'));
        $job->setDescription($request->input('description'));
        $ser = new jobBusinessService();
        $ser->editJob($job, $id);
        
        return View('welcome');
    }
    
    /**
     * Sending a request to delete a pre-exsisitng Job posting from the database
     * @param Request $request
     */
    public function onJobDelete(Request $request) {
        $jobID = $request->input('id');
        $ser = new jobBusinessService();
        $ser->removeJob($jobID);
        
        return View('welcome');
        
    }
    
    public function onJobPass(Request $request) {
        $id = $request->input('id');
        $data = ['id' => $id];
        return View('EditJob')->with($data);
    }
    
    public function onJobSearch(Request $request) {
        $ser = new jobBusinessService();
        $search = $request->input('search');
        $jobArray = $ser->searchJob($search);
        $data = ['jobArray' => $jobArray];
        return View('JobSearchResults')->with($data);
    }
    
    public function onJobView(Request $request) {
      $ser = new jobBusinessService();
      $job = $ser->jobPosition($request->input('pos'));
      $data = ['job' => $job];
      return View('ViewJob')->with($data);
    }
    
    
}
