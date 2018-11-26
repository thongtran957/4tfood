<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request){
    	$credentials = $request->only(['email', 'password']);

    	try{
            if (!auth()->attempt($credentials)) {
                return \Response::json(['status' => 'fail user or password']);
           
            }
            elseif(auth()->user()->status != 1){
            	return \Response::json(['status' => 'fail active']);
            }
          
        } catch (\Exception $e){
             return \Response::json(['status' => 'fail']);
        }

        $data = [
        	'access_token' => auth()->user()->access_token,
            'user' => auth()->user(),
        ];

        return \Response::json(['data' => $data]);
    }
}

