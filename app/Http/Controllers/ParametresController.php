<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Miseforme;
use Illuminate\Support\Facades\Auth;


class ParametresController extends Controller
{
    public function show() {
    	$user = User::find(Auth::id());
    	$string = 'account';
    	return view('parametres.account', compact('string','user'));
    }

     /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required'
    
        ]);
 
         $user = User::find(Auth::id());

 			
            $user->fill([
                'name' => $request->name,
                'email' => $request->email
            ])->save();
 
            $request->session()->flash('success', 'Vous avez bien modifié les informations.');
 
 
        return back();
 
 
    }

    public function view() {
        $miseforme = Miseforme::where('user_id', Auth::id())->first();
        //dd($miseforme);
        $string = 'miseforme';
        return view('parametres.miseforme', compact('string','miseforme'));
    }

    public function updatemiseforme(Request $request)
    {

        $this->validate($request, [
            'article_par_page' => 'required',
    
        ]);
 
         $miseforme = Miseforme::where('user_id', Auth::id())->first();

            //dd($miseforme);
            $miseforme->fill([
                'nombre_sidebar' => $request->nombre_sidebar,
                'article_par_page' => $request->article_par_page,
                'color_background' => $request->color_background,
                'color_widget' => $request->color_widget
            ])->save();
 
            $request->session()->flash('success', 'Vous avez bien modifié les informations.');
 
 
        return back();
 
 
    }
}
