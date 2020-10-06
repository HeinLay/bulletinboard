<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
   */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
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
    $this->middleware('guest')->except('logout');
  }

  public function register(Request $request){

		$request->validate([
			'email'=>'required',
			'name'=>'required',
			'password'=>'required'
		]);

		$user=new User();
		$user->email=$request->email;
		$user->name=$request->name;
		$user->email=$request->email;
		$user->password=bcrypt($request->password);
    $user->profile=$request->profile;
    $user->create_user_id=$request->create_user_id;
    $user->updated_user_id=$request->create_user_id;
		$user->save();


		$http = new Client;

		$response = $http->post(url('oauth/token'), [
		    'form_params' => [
		        'grant_type' => 'password',
		        'client_id' => '2',
		        'client_secret' => 'cK13jXYdcIjETs7yKO8wpkvFGoZhN6WgEex9eCbB',
		        'username' => $request->email,
		        'password' => $request->password,
		        'scope' => '',
		    ],
		]);


		return response(['auth'=>json_decode((string) $response->getBody(), true),'user'=>$user]);

	}

	public function login(Request $request){

		$request->validate([
			'email'=>'required',
			'password'=>'required'
		]);

		$user= User::where('email',$request->email)->first();

		if(!$user){
			return response(['status'=>'error','message'=>'User not found']);
		}

		if(Hash::check($request->password, $user->password)){

				$http = new Client;

			$response = $http->post(url('oauth/token'), [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => '2',
					'client_secret' => 'cK13jXYdcIjETs7yKO8wpkvFGoZhN6WgEex9eCbB',
					'username' => $request->email,
					'password' => $request->password,
					'scope' => '',
				],
			]);
			return response(['auth' => json_decode((string)$response->getBody(), true), 'user' => $user]);


		}else{
			return response(['message'=>'password not match','status'=>'error']);
		}


	}

	public function refreshToken() {

		$http = new Client;

		$response = $http->post(url('oauth/token'), [
		    'form_params' => [
		        'grant_type' => 'refresh_token',
		        'refresh_token' => request('refresh_token'),
		        'client_id' => '2',
		        'client_secret' => 'cK13jXYdcIjETs7yKO8wpkvFGoZhN6WgEex9eCbB',
		        'scope' => '',
		    ],
		]);

		return json_decode((string) $response->getBody(), true);

	}
  //
  // public function login(Request $request)
  // {
  //
  //   if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
  //     // Authentication passed...
  //     Log::info("Login succeeded");
  //
  //     return redirect()->intended('user');
  //   }
  //   Log::info("Login failed");
  //   return redirect()->intended('login')
  //     ->with('loginError', 'User name or password is incorrect!');
  //
  // }
}
