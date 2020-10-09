<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
   */

  use ResetsPasswords;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = '/user';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }
  
  public function changePassword(Request $request)
  {
    $validatedData = $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|different:old_password',
        'confirm_password' => 'required|same:new_password',
    ]);

    if (!(Hash::check($validatedData['old_password'], Auth::user()->password))) {
        return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
    }

    $user = Auth::user();
    $user->password = $validatedData['new_password'];
    $user->save();
    return response()->success('Success');
  }
}
