<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckPermisionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $route)
    {
        
        $permision = DB::table('permisions')->select('id')->where('route', $route)->first();
        if(count($permision) == 1){
            $permision_id = $permision->id;
            $user_id = Auth::id();
            $credentail = DB::table('users_permisions')->select('id')->where(['user_id'=>$user_id, 'permision_id'=>$permision_id])->first();
            if(count($credentail) == 1){
                return $next($request);
            }else{
                echo "no permision allowed."; die;
            }
        }else{
            echo "invalide route: ".$route; die;
        }
        
       
    }
}
