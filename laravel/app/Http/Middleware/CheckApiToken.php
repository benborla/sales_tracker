<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty(trim($request->input('api_token')))){

            $user = User::where('id', Auth::guard('api')->id())->exists();
            if ($user){
                return $next($request);
            }
        }

        return response()->json('Invalid Token', Response::HTTP_UNAUTHORIZED);
    }
}
