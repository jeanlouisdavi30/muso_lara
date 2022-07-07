<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileMusoCtr extends Controller
{
     public function showProfile() {
        return view('auth.profile');
    }
    public function showChangePasswordGet() {
        return view('auth.passwords.change-password');
    }

    public function changePasswordPost(Request $request) {
        
    
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(['status'=>0, 'error'=>"Your current password does not matches with the password."]);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return response()->json(['status'=>0, 'error'=>"New Password cannot be same as your current password."]); 
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);
        
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();
            return response()->json(['status'=>1, 'msg'=>"Password successfully changed!"]);
           // return redirect()->back()->with("success","Password successfully changed!");
      
     
    }
}