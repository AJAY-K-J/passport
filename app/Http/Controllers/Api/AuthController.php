<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function register(Request $request){

$request->validate([
'name'=> 'required',
'email'=>'required',
'password'=>'required',

]);

User::create([

    'name'=> $request->name,
    'email'=>$request->email,
'password'=>Hash::make($request->password) ,
]);

return 'success';



   }


   public function login(Request $request){

    $request->validate([
        
        'email'=>'required',
        'password'=>'required',
        
        ]);

if(Auth::attempt(['email'=>request('email'),'password'=> request('password')])){

$user= $request->user();

$tokenResult= $user->createToken('my token');


return response()->json([

    'acces_token'=> $tokenResult->accessToken,
    'token_type'=> 'Bearer',
    'test'=>$tokenResult,
]);


}



   }

   public function logout(Request $request)
   {
       $request->user()->token()->revoke();
       return response()->json([
   
          'message'=> 'Successfully logged out'
       ]);
       
   }


   public function users(){
return User::all();

   }



}
