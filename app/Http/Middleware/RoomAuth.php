<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoomAuth
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
        $roomName = $request->route('id');
        $user = Auth::user();
        
        if(!$user){
            return (url()->previous() == '') ? 
                redirect()->route('welcome')->withErrors(['auth-error' => 'you need to be logged in to get access this room'])->with('auth-error', $roomName) :
                redirect()->back()->withErrors(['auth-error' => 'you need to be logged in to get access this room'])->with('auth-error', $roomName);
        }
        if(!$user->canJoinRoom($roomName)){
            return abort(403);
        }
        return $next($request);
    }
}
