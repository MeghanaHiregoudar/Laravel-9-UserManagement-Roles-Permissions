<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use DB;
use App\Helpers\Core;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenticationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function authenticated(Request $request){

        // Decode the email and password values
        $username = $username; 
        $password = $password; 
        $captcha = $request->input('captcha');

        $validator = Validator::make([
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha
        ], [
            'username' => 'required',
            'password' => 'required|min:5|max:30',
            'captcha' => 'required|captcha'
        ], 
        [
            'username.required' => "Username field caanot be empty",
            'password.required' => "Password field caanot be empty",
            'captcha.required' => "Captcha field caanot be empty",
            'captcha.captcha' => 'Invalid captcha', // trans('message.invalid-captcha'),
        ]
        );

        if ($validator->fails())
        {
            return response()->json([
                'status'=>0, 
                'errors'=>$validator->errors()->toArray()
            ]);
        }

        $creds = array(
            'user_name' => $username,
            'password' => $password,
        );
        
        if( Auth::attempt($creds) ){
            return response()->json([
                'status' => 1,
                'msg' => trans('message.login-successfull'),
                'redirect'=> route('dashboard')
            ]);
           
        }else{
            return response()->json([
                'status' => 2,
                'msg' => trans('message.incorrect-credentials'),
                'redirect'=> route('login')
            ]);
        }

    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('flat')]);
    }
        

    public function showProfile(){
        $id = Auth::user()->id;
        $data['profile_data'] = User::find($id);
        
        return view('profile.profile',$data);
    }

    public function logout(Request $request) {
        Session::flush();
        return redirect()->route('login');
    }
    
}
