<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\User;

class UsermanagementController extends Controller {

  public function createAdminUser(Request $request) {
    $input = $request->input();

    if (User::where('email', $input['email'])->count() > 0) {
      return response()->json(['success' => false, 'error' => 'Email exist']);
    }

    $user = new User;

    $user->firstname = $input['firstname'];
    $user->lastname = $input['lastname'];
    $user->email = $input['email'];
    $user->password = bcrypt($input['password']);
    $user->role = "admin";
    $user->save();

    return response()->json([
      'success' => true
    ]);
  }

  public function getAdminList(Request $request) {

    $admins = User::where('role', 'admin')->get();

    return response()->json([
      'success' => true,
      'data' => $admins
    ]);

  }

  public function getAdminUser(Request $request) {
    $input = $request->input();
    $id = $input['id'];

    $admin = User::where('id', $id)->first();

    return response()->json([
      'success' => true,
      'data' => $admin
    ]);
  }


  public function updateAdminUser(Request $request) {
    $input = $request->input();
    $id = $input['id'];

    $admin = User::where('id', $id)->first();

    if ($input['changePassword']) {
      $admin->password = bcrypt($input['password']);
    }

    $admin->firstname = $input['firstname'];
    $admin->lastname = $input['lastname'];
    $admin->email = $input['email'];

    $admin->save();


    return response()->json([
      'success' => true
    ]);
  }

  public function deleteAdminUser(Request $request) {
    $input = $request->input();
    $id = $input['id'];

    User::where('id', $id)->delete();

    return response()->json([
      'success' => true
    ]);
  }
}