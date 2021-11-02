<?php

namespace App\Http\Controllers\Api;

use App\Libs\GoogleAuthenticator;
use App\Mail\ForgotPasswordMail;
use App\Mail\VerificationMail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Failed', 'success' => false]);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'token error'], 500);
        }

        //$currentTime = date('Y-m-d g:i:s');
        
        $user = Auth::user();

        $user->lastlogin = now();
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user,
            'token' => $token
        ]);
    }

    public function sendVerifyEmail(Request $request) {

        $input = $request->input();

        $user = User::where('email', $input['email'])->first();

        if ($user == null) {
            return response()->json([
                'success' => false,
            ]);
        } else {
            $confirm_code = str_random(30);
            Mail::to($input['email'])->send(new VerificationMail($confirm_code));

            $user->confirm_code = $confirm_code;
            $user->save();

            return response()->json([
                'success' => true,
            ]);
        }
    }

    public function verifyMail($confirm_code, Request $request) {
        $count = User::where('confirm_code', $confirm_code)->count();

        if ($count == 0) {
            return 'Invalid code';
        } else {
            User::where('confirm_code', $confirm_code)->update(['verified' => 1]);

            return ("<script>location.href = '".env('CLIENT_URL')."/login'</script>");
        }
    }

    public function loadBusinessUsers(Request $request) {
        $users = User::where([['businessUser', 1], ['verified', 1]])->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function register(Request $request) {
        return User::create([
            'name' => 'kss',
            'email' => 'aaa@aaa.com',
            'password' => Hash::make('aaa'),
            'api_token' => Str::random(60),
        ]);
    }
}
