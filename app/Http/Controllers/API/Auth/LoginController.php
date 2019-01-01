<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function login(Request $request){
    	$credentials = $request->only(['email', 'password']);

    	try{
            if (!Auth::attempt($credentials)) {
                return \Response::json(['msg' => 'email or password incorrect']);
           
            }
            elseif(auth()->user()->status != 1){
            	return \Response::json(['msg' => 'please login gmail to active your account']);
            }
          
        } catch (\Exception $e){
             return \Response::json(['status' => 'fail']);
        }

        $data = [
        	'access_token' => auth()->user()->access_token,          
            // 'user' => auth()->user(),
        ];

        return \Response::json(['data' => $data]);
    }
}

