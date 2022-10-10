<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        # code...
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ]);
        
        $check = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($check){
            $user = Auth::user();
            return $user->createToken($request->password)->plainTextToken;
        }else {
            return json_encode(false);
        }
            
        
        
    }

    public function register(Request $request)
    {
        # code...
        $request->validate([
            'name'=> "required|min:3|string|max:20",
            'email'=> "required|min:8|email",
            'password'=> "required|min:3|string",
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if($user){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }
}
