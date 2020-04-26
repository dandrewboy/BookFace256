<?php

namespace App\Http\Middleware;

use App\Utility\AppLogger;
use Illuminate\Support\Facades\Session;
use Closure;

class AdminSecurityMiddleWare
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
        AppLogger::info("Entering Admin Security MIddleware in handle() at path: ". $path);
        
        $secureCheck = true;
        
        if($request->is('doAdmin') || $request->is('stateChange') || $request->is('deleteUser') || $request->is('addjob') || 
            $request->is('doJob') || $request->is('doJobPost') || $request->is('doJobEdit') || $request->is('doJobDelete')) {
                $secureCheck = false;
            
            AppLogger::info($secureCheck ? "Admin Security Middleware is handle()...Security Needed" :
                " Admin Security Middleware is handle()...No Security Required");
            
            if($request->session()->get('Role') != "admin" || $secureCheck)
            {
                AppLogger::info("Leaving Admin Security Middleware and redirecting back to login");
                return redirect('/');
            }
            }
    return $next($request);
  }
}