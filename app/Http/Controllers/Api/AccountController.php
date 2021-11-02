<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\User;

class AccountController extends Controller {

    public function getAccount(Request $request) {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    public function getProfile(Request $request) {
        $user = Auth::user();
        
        $user_location_id = array();
        $user_location_locality_id = array();
        
        $user_location = User_location::where('user_id',$user->id)->first();

        if(!empty($user_location)){
            $user_location_id = explode(',',$user_location->location_id);
            $user_location_locality_id = explode(',',$user_location->location_locality_id);
            $user['location_id'] = $user_location_id;
            $user['location_locality_id'] = $user_location_locality_id;
        }else{
            $user['location_id'] = $user_location_id;
            $user['location_locality_id'] = $user_location_locality_id;
        }
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function saveProfile(Request $request) {
        $input = $request->input();

        $user = Auth::user();

        $user = User::where('id', $user->id)->first();

        $user->name = $input['name'];
        $user->phone = $input['phone'];
        $user->address = $input['address'];
        $user->site = $input['site'];
        $user->birthday = $input['birthday'];
        $user->gender = $input['gender'];
        $user->photo = $input['photo'];
        if ($input['photo'] == '') $user->photo = env('APP_URL').'/storage/profile.jpg';

        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ]);

    }
}