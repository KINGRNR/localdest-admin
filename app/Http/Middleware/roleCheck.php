<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class roleCheck
{
    public function handle(Request $request, Closure $next, $role)
    {

        $userRole = session('role');
        // dd($userRole);

        // Check if the user role is in the allowed roles
        if (in_array($userRole, explode('|', $role))) {
            return $next($request);
        } else {
            // If the user role is 1, redirect to index
            // dd($userRole);

            if ($userRole == 1) {
                return redirect()->route('index')->with('message', 'ok.');
            }

            // Redirect to login if access is denied
            return redirect()->route('viewlogin')->with('message', 'no access.');
        }
        // if (Auth::check()) {

        // } else {
        //     $userRole = session('role');

        //     return $next($request);
        // }
    }
}
