<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function check_login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validator->fails()){
            $error=$validator->errors()->first();
            return response()->json(['status'=>false,'message'=>$error]);
        }
        // User::create([
        //     'name'=>'Maulik',
        //     'email'=>'maulik@test.com',
        //     'password'=>bcrypt(123456),
        //     'user_type'=>0,
        // ]);
        $email=$request->email;
        $user=User::where('email',$email)->where('user_type',0)->first();
        if($user){
            $credentials=$request->only('email','password');
            if(Auth::attempt($credentials)){
                return response()->json(['status'=>true,'message'=>'Login successfull']);
            }
            else{
                return response()->json(['status'=>false,'message'=>'Invalid email or password']);
            }
        }
        else{
            return response()->json(['status'=>false,'message'=>'User not found']);
        }
    }

    public function user_register(Request $request){
        $email=$request->email;
        $password=$request->password;
        $user=User::where('email',$email)->where('user_type',0)->first();
        if($user){
            $credentials=$request->only('email','password');
            if(Auth::attempt($credentials)){
                return response()->json(['status'=>true,'message'=>'Login successfull']);
            }
            else{
                return response()->json(['status'=>false,'message'=>'Invalid email or password']);
            }
        }
        else{
            return response()->json(['status'=>false,'message'=>'User not found']);
        }
    }

    public function search_user(Request $request){
        $search_user=$request->search_user;
        if(isset($search_user)){
            $searched_user=User::where('name','LIKE',"%{$search_user}%")->select('id','name','email')->get();
            return response()->json(['status'=>true,'data'=>$searched_user,'message'=>'User found']);
        }
        else{
            return response()->json(['status'=>false,'message'=>'User not found']);
        }
    }

    public function dashboard(){
        return view('user.dashboard');
    }
}
