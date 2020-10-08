<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Log;
use Response;

class UserController extends Controller
{

  private $userInterface;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(UserServiceInterface $userInterface)
  {

    $this->middleware('auth');
    $this->userInterface = $userInterface;
  }

  /**
   * Get User List
   * @param
   * @return
   */
  public function getUserList()
  {
    $userList = $this->userService->getUserList();
    return Response::json($userList);
  }


  /**
   * Create User
   * @param
   * @return
   */
   public function register(Request $request){

    $validateData = $request->validate([
 			'email'=>'email|required|unique:users',
 			'name'=>'required|max:55',
 			'password'=>'required'
 		]);

    $user = User::create($validateData);

    $accessToken = $user->createToken('authToken')->accessToken;

    return response(['user'=>$user, 'access_token'=>$accessToken]);
    
 		$user=new User();
 		$user->email=$request->email;
 		$user->name=$request->name;
 		$user->email=$request->email;
 		$user->password=bcrypt($request->password);
    $user->profile=$request->profile;
    $user->create_user_id=$request->create_user_id;
    $user->updated_user_id=$request->create_user_id;
    if($user->save()){
      return response(['auth'=>json_decode((string) $response->getBody(), true),'user'=>$user]);
    }

 	}
}
