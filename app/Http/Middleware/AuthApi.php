<?php namespace App\Http\Middleware;

use Closure;

class AuthApi {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( ! \Auth::check() )
        {
            return response( [  
                'success'   => false, 
                'code'      => 401, 
                'message'   => 'Unauthorized action'
            ], 401 );
        }

        return $next($request);
    }

}
