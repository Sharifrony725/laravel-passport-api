<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required | email',
            'password' => 'required | min:6'
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'failed' , 'validattion_errors' => $validator->errors()]);
        }
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if($user){
            return response()->json(['status' => 'successful','message' => 'User Regsitration Successfully Completed' , 'data' => $user]);
        }else{
            return response()->json(['status' => 'failed' ,'message' => 'User Regsitration Failed']);
        }
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required | email',
            'password' => 'required | min:6'
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'failed' , 'validattion_errors' => $validator->errors()]);
        }
        //login
        if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('usertoken')->accessToken;
            return response()->json(['success' => 'success','login'=>true , 'token'=> $token , 'data' => $user]);
        }else{
            return response()->json(['status' => 'failed', 'message' => 'Whoops! email or password failed']);
        }
    }
    public function userDetail(){
        $user = Auth::user();
        if($user){
            return response()->json(['status' => 'success' , 'user' => $user]);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'Whoops! User Not Found']);
        }
    }
}
