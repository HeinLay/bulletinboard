<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class AuthController extends Controller
{
  public function authenticateByPassport(Request $request)
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $user  = Auth::user();
      $token = $user->createToken('authToken')->accessToken;
      return Response::json([
        'userData' => $user,
        'token'    => $token,
        'status'   => 200,
      ]);
    } else {
      return Response::json(['status' => 403]);
    }
  }

  public function logout(){
    auth()->logout();
    return ['status'=> "Successfully Logout."];
  }
}
