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
        // dd($data);
        return view('users.index', $data );
    }
    
    
    protected function create(){
        return view('users.create');
    }

    protected function store(Request $request){
        dd($request->all());
    }
    
    protected function edit($userId){
        $data['response'] =  $this->Users->_getUsers(['id' => $userId]);
        dd($data);
        return view('users.edit', $data );
    }
}
