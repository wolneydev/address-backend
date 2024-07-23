<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function verifyPermission(Request $request)
    {
      
         $user_key = Auth::user()->user_key;       
         $model = $request->route;                          
         return response()->json(['message'=>"autenticado","user_key"=> $user_key],200);
           
    }     

}
