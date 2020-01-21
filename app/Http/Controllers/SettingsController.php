<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveSettingsPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function update(SaveSettingsPost $request)
    {
        $user = Auth::user();
        if($request->username && strcasecmp($request->username, $user->name) != 0){
            $user->name = $request->username;
            $user->save();
        }
        
        if($request->changePassword){
            $user->password = Hash::make($request->newPassword);
            $user->save();
        }

        return ['status' => 'success'];
    }
}
