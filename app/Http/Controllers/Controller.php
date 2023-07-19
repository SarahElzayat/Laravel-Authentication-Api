<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|max:255',
            'phone_number' => 'required|unique:users|max:10',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:3',
        ]);
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone_number' => $req->phone_number,
        ]);

        // $token = $user->createToken('auth_token')->accessToken;

        return response([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }


    public function login(Request $request)
    {

        // check if phone number exists
        $request->validate(
            [
                'phone_number' => 'required|exists:users,phone_number'
            ]
        );

        // Find the the user object associated with the sent phone number
        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user->otp == NULL || $user->otp == "") {
            $otp = rand(10000, 99999);
            $user->otp = $otp;
            $user->save();
            Mail::to($user->email)->send(new SendMail($user->email, $otp));

            // return 'New otp: ' . $otp;
        } else {
            Mail::to($user->email)->send(new SendMail($user->email, $user->otp));
            // return "OTP ALREADY SENT";

        }
        return response()->json(['error' => false, 'message' => 'OTP Sent Successfully'], 200);
    }

    public function verify_otp(Request $request)
    {
        // check if phone number exists
        $request->validate(
            [
                'phone_number' => 'required|exists:users,phone_number'
            ]
        );

        // Find the the user object associated with the sent phone number
        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user->otp == $request->otp) {

            $user->otp = null;
            $user->save();
            $token = $user->createToken('auth_token')->accessToken;
            return response()->json(['error' => false, 'message' => 'User logged in successfully.', 'data' => [
                'token' => $token,
                'user' => $user
            ]], 200);
        }
        return
            response()->json(['error' => true, 'message' => 'Invalid OTP'], 400);
    }


    public function logout(Request $request)
    {

        $result = $request->user()->token()->revoke();
        if ($result) {
            $response = response()->json(['error' => false, 'message' => 'User logout successfully.', 'result' => []], 200);
        } else {
            $response = response()->json(['error' => true, 'message' => 'Something is wrong.', 'result' => []], 400);
        }
        return $response;
    }
}
