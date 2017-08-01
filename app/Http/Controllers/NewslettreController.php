<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newsletter;
use Illuminate\Support\Facades\Auth;
class NewslettreController extends Controller
{
     public function show() {
     	$newslettre = Newsletter::where('user_id', Auth::id())->first();
     	$email = Auth::user()->email;
     	$string = 'newslettre';

    	return view('parametres.newslettre',compact('newslettre','email','string'));
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
            'email' => 'required|email'
    
        ]);
 
        $newslettre = Newsletter::where('user_id', Auth::id())->first();

 			if($request->periode_newslettre != $newslettre->periode_newslettre)
 				{
 					$date = date('Y-m-d');
 					if($request->periode_newslettre == 'chaque jour')
 						$dateend = date('Y-m-d', strtotime('+1 days'));
 					elseif ($request->periode_newslettre == 'chaque semaine')
 						$dateend = date('Y-m-d', strtotime('+7 days'));
 					elseif ($request->periode_newslettre == 'chaque mois')
 						$dateend = date('Y-m-d', strtotime('+30 days'));

 				}
 			else
 				$dateend = $newslettre->date_envoie_newslettre;
 				//dd($request->periode_newslettre);
            $newslettre->fill([
                'email' => $request->email,
                'periode_newslettre' => $request->periode_newslettre,
                'date_envoie_newslettre' => $dateend,
                'envoi_newslettre'=> $request->envoi_newslettre
            ])->save();
 
            $request->session()->flash('success', 'Vous avez bien changes les informations.');
 
 
        return back();
 
 
    }
}
