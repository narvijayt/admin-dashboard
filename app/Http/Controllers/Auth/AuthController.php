<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Resources\Authentication;


class AuthController extends Controller
{
    //
    
    protected $Auth;

    public function __construct(){
        $this->Auth = new Authentication();
    }
    /**
     * Show the login form to access the dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index(){

        if (session()->has('access_token')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Validate user login details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doLogin(Request $request){
        $validated = $request->validate([
            'user_name' => 'required',
            'user_password' => 'required',
        ]);


        $responseBody = $this->Auth->_authenticate([
            'login' => $request->input('user_name'),
            'password' => $request->input('user_password'),
        ]);

        if( isset($responseBody['accessToken']) ){
            $request->session()->put('access_token', $responseBody['accessToken'] );
            $request->session()->put('accountType', $responseBody['user']['accountType'] );
            return redirect()->route('dashboard')->with('message', "Welcome to Dashboard!");
        }else{
            return redirect()->route('login')->withInput()->with('error', $responseBody['message']);
        }
    }
}
