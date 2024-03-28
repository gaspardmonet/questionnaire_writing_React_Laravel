<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admins;

class AdminController extends Controller
{
    public function signup(Request $request)
    {
        // $valid_email = preg_quote($request->email, '/');
        // $reg_email = '/'.$valid_email.'/u';
        $admin = Admins::where('email', $request->email)->first();
        if ($admin) {
            return response()->json([
                "message" => "This email already exits.",
            ], 401);
        }
        $hashedPassword = Hash::make($request->password);
        $newAdmin = Admins::create([
            "email" => $request->email,
            "password" => $hashedPassword,
        ]);
        return response()->json([
            "message" => "Enter this site successfully.",
            "userInfo" => $newAdmin,
        ], 200);
    }

    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'role' => 'required',
        // ]);
        $admin = Admins::where('email', $request->email)->first();
        if (!$admin) {
            return response()->json([
                "message" => "Not exist this email.",
            ], 401);
        }
        $isMatch = Hash::check($request->password, $admin->password);
        if (!$isMatch) {
            return response()->json([
                "message" => "Incorrect password.",
            ], 401);
        }
        $token = $admin->createToken($request->email)->plainTextToken;
        return response()->json([
            "message" => "Login successfully",
            "payload" => [
                "token" => $token,
                "userInfo" => $admin,
            ],
        ], 200);
    }

    public function loginWithToken(Request $request)
    {
        $id = $request->user()->id;
        $admin = Admins::where('id', $id)->first();
        $token = $admin->createToken($admin->email)->plainTextToken;
        return response()->json([
            "message" => "Login with token successfully",
            "payload" => [
                "token" => $token,
                "userInfo" => $admin,
            ],
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $id = $request->user()->id;
        $newPassword = $request->newPassword;
        $oldPassword = $request->oldPassword;
        $admin = Admins::where('id', $id)->first();
        if(!Hash::check($oldPassword, $admin->password)) {
            return response()->json([
                "message"=>"Incorrect password",
            ], 401);
        }
        $admin->password = Hash::make($newPassword);
        $admin->save();
        return response()->json([
            "message"=>"Changed password successfully.",
            "userInfo"=>$admin,
        ], 200);
    }
}
