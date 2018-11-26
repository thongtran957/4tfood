<?php

namespace App\Http\Controllers\API\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\ActivationUser as ActivationUserNotification;
use App\Mail\VerifyEmail;
use App\Mail\activationEmail;

class RegisterController extends Controller
{

	use RegistersUsers;


    protected function create(Request $request)
    {

        $access_token = $this->generateUniqueAccessToken();

        $user = User::create([
            'name' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'access_token' => $access_token
        ]);


        //send mail to verify
        $data = array(
            'name'=> $request['username'],
            'access_token' => $access_token,
        );
   
       \Mail::to($request['email'])->send(new activationEmail($data));  
    

    }

    protected function generateUniqueAccessToken(){
    	do{
    		$token = str_random(64);
    	}while($user = User::where('access_token', $token)->first());

    	return $token;
    }

    protected function changeStatus(Request $request){
        $input = $request->all() ;

        $access_token = $input['access_token'];

        $array = [
            'status' => 1
        ];

        $result = User::where('access_token',$access_token)->update($array);

        return redirect('/#/login');

    }


    
}
