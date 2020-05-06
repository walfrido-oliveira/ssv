<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        $reponse = $next($request);

        $userType = auth()->user()->getType();

        if ($userType == $type)
        {
            return $reponse;
        }

        return redirect('login');
    }
}
