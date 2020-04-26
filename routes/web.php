<?php

use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Login');
});

    Route::get('/reg', function() {
        return view('Registration');
    });
        Route::get('/pro', function() {
            return view('Profile');
        });
            Route::get('/home', function() {
                return view('welcome');
            });
                Route::get('/editpro', function() {
                    return view('EditProfile');
                });
                    Route::get('/editjob', function() {
                        return view('EditJob');
                    });
                        Route::get('/addjob', function() {
                            return view('AddJob');
                        });
                            Route::get('/addgroup', function() {
                                return view('AddGroup');
                            });
                                Route::get('/editgroup', function() {
                                    return view('EditGroup');
                                });
                                Route::get('/community', function() {
                                    return view('CommunityHub');
                                });
                                    Route::get('/search', function() {
                                        return view('JobSearch');
                                    });
                                        Route::get('/apply', function() {
                                            return view('Applied');
                                        });
                                            Route::get('/addjh', function() {
                                                return view('AddJobHistory');
                                            });
                                                Route::get('/addedu', function() {
                                                    return view('AddEducation');
                                                });
                                                    Route::get('/addskill', function() {
                                                        return view('AddSkill');
                                                    });
                                                        

Route::post('onLogin', 'LoginController@onLogin');
Route::post('onRegister', 'RegistrationController@onRegister');
Route::get('onProfile', 'ProfileController@onProfile');
Route::post('doProEdit', 'ProfileController@onEditPro');
Route::post('doAddJobHistory', 'ProfileController@onAddJobHistory');
Route::post('doEditJobHistory', 'ProfileController@onEditJobHistory');
Route::post('doDeleteJobHistory', 'ProfileController@onDeleteJobHistory');
Route::post('doAddEducation', 'ProfileController@onAddEducation');
Route::post('doEditEducation', 'ProfileController@onEditEducation');
Route::post('doDeleteEducation', 'ProfileController@onDeleteEducation');
Route::post('doAddSkill', 'ProfileController@onAddSkill');
Route::post('doEditSkill', 'ProfileController@onEditSkill');
Route::post('doDeleteSkill', 'ProfileController@onDeleteSkill');
Route::post('doJobHistoryPass', 'ProfileController@onJobHistoryPass');
Route::post('doEducationPass', 'ProfileController@onEducationPass');
Route::post('doSkillPass', 'ProfileController@onSkillPass');
Route::get('doAdmin', 'AdminController@onAdmin');
Route::post('stateChange', 'AdminController@stateChange');
Route::post('deleteUser', 'AdminController@deleteUser');
Route::get('doJob', 'JobController@onJob');
Route::post('doJobPost', 'JobController@onJobPost');
Route::post('doJobEdit', 'JobController@onJobEdit');
Route::post('doJobDelete', 'JobController@onJobDelete');
Route::post('doJobPass', 'JobController@onJobPass');
Route::post('doGroupPass', 'CommunityController@onGroupPass');
Route::post('doAddGroup', 'CommunityController@onAddGroup');
Route::post('doEditGroup', 'CommunityController@onEditGroup');
Route::get('doCommunityHub', 'CommunityController@onCommunityHub');
Route::post('doDeleteGroup', 'CommunityController@onDeleteGroup');
Route::post('doJoinGroup', 'CommunityController@onJoinGroup');
Route::post('doLeaveGroup', 'CommunityController@onLeaveGroup');
Route::get('doViewGroup' , 'CommunityController@onViewGroup');
Route::get('doJobSearch' , 'JobController@onJobSearch');
Route::get('doViewJob' , 'JobController@onJobView');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::resource('/jobsrest','JobRestController');
Route::resource('/profilesrest','ProfileRestController');
