<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resources\Users;

class UsersController extends Controller
{
    //
    protected $Users;

    public function __construct(){
        $this->Users = new Users();
    }

    protected function index(){
        $data['response'] =  $this->Users->_getUsers();
        // pr($user); die;
        return view('users.index', $data );
    }
    
    
    protected function create(){
        $data['accountTypes'] = getUsersAccountTypes();
        return view('users.create', $data);
    }

    protected function store(Request $request){
        $validated = $request->validate([
            'accountType' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        list($username, $domain) = explode("@", $request->input('email') );
        $userArray = [
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'username' => $username,
            'accountType'   =>  'STAFF'
        ];
        
        $userResponse = $this->Users->_createUsers($userArray);
        if(isset($userResponse['message'])){
            return redirect()->route('users.create')->withInput()->with('error', $userResponse['message']);
        }else{
            return redirect()->route('users')->with('message', 'User has been created successfully.');
        }
    }
    
    protected function edit($userId){
        $data['response'] =  $this->Users->_getUsers(['id' => $userId]);
        dd($data);
        return view('users.edit', $data );
    }
}
