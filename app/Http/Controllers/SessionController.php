<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
	public function __construct(){
		$this->middleware('guest', ['except' => 'destroy']);
	}
    public function create() {
    	return view('auth.login');
    }
    public function store(Request $request) {

        $this->validateLogin($request);
    	
        if (!auth()->attempt(request(['email','password']))) {
    		 return $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    	} 
         //session(['language' => request('language')]);
    	//dd(request('lang'));
    	return redirect('/'.request('language'));
    }
    public function destroy(){
    	auth()->logout();
    	return redirect()->home();
    }
}
