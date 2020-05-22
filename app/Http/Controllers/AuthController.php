<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 

use Validator;
use App\User; 


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public $successStatus = 200;

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 

            $success['token'] =  $user->createToken('MyApp')->accessToken; 

            return response()->json(['success' => $success], $this->successStatus); 
        } 
        else { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = $request->all(); 
        $data['password'] = bcrypt($data['password']); 

        $user = User::create($data); 

        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus); 
    }

    public function me() 
    {
        $user = Auth::user(); 

        return response()->json(['success' => $user], $this->successStatus); 
    } 

    public function logout()
    {
        $user = Auth::user(); 

        $user->token()->revoke();

        return response()->json(['success'=>'Successfully logged out'], $this->successStatus); 
    }
}
