<?php

namespace App\Http\Middleware;

use App\Utility\AppLogger;
use Illuminate\Support\Facades\Session;
use Closure;

class SecurityMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        AppLogger::info("Entering My Security MIddleware in handle() at path: ". $path);
        
        $secureCheck = true;
        
        if($request->is('/') ||
            $request->is('reg') ||
            $request->is('onLogin') ||
            $request->is('onRegister') ||
            $request->is('onProfile') ||
            $request->is('doProEdit') ||
            $request->is('editpro') ||
            $request->is('doJobHistoryPass') ||
            $request->is('doEducationPass') ||
            $request->is('doSkillPass') ||
            $request->is('addgroup') ||
            $request->is('addjh') ||
            $request->is('addedu') ||
            $request->is('addskill') ||
            $request->is('community') ||
            $request->is('pro') ||
            $request->is('doJobPass') ||
            $request->is('doAddGroup') ||
            $request->is('doCommunityHub') ||
            $request->is('doDeleteGroup') ||
            $request->is('doJoinGroup') ||
            $request->is('doLeaveGroup') ||
            $request->is('doViewGroup') ||
            $request->is('doJobSearch') ||
            $request->is('doViewJob') ||
            $request->is('doAddJobHistory') ||
            $request->is('doEditJobHistory') ||
            $request->is('doDeleteJobHistory') ||
            $request->is('doAddEducation') ||
            $request->is('doEditEducation') ||
            $request->is('doDeleteEducation') ||
            $request->is('doAddSkill') ||
            $request->is('doEditSkill') ||
            $request->is('doDeleteSkill') ||
            $request->is('home') ||
            $request->is('search') ||
            $request->is('jobsrest') ||
            $request->is('jobsrest/*') ||
            $request->is('profilesrest') ||
            $request->is('profilesrest/*') ||
            $request->is('apply')
            ){
                $secureCheck = false;
        }
        if($request->is('doAdmin') || $request->is('stateChange') || $request->is('deleteUser') || $request->is('doJob') ||
            $request->is('doJobPost') || $request->is('doJobEdit') || $request->is('doJobDelete') && $request->session->get('Role') == "admin") {
                $secureCheck = false;
            }
        AppLogger::info($secureCheck ? "Security Middleware is handle()...Security Needed" :
            "Security Middleware is handle()...No Security Required");
        
        $enable = true;
        if($enable && $secureCheck)
        {
            AppLogger::info("Leaving Security Middleware and redirecting bakc to login");
            return redirect('/');
        }
        return $next($request);
    }
}
