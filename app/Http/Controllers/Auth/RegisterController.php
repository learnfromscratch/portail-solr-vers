<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Abonnement;
use App\Keyword;
use App\Newsletter;
use App\Miseforme;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users/all';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        //dd($data);
        if(empty($data['sous_groupe_id']))
            $sousgroupe = NULL;
        else
            $sousgroupe = $data['sous_groupe_id'];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'groupe_id' => $data['groupe_id'],
            'role_id' => $data['role_id'],
            'sous_groupe_id' => $sousgroupe
        ]);
        //dd($user->id);

        Newsletter::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'periode_newslettre' => 'chaque semaine',
            'date_envoie_newslettre' => date('Y-m-d', strtotime('+7 days')),
            'envoi_newslettre' => 1
        ]);

        Miseforme::create([
            'user_id' => $user->id

        ]);
        // if (isset($data['sous_groupe_id']))
        // {
        //     $user->sous_groupe_id = $data['sous_groupe_id'];
        //     $user->save();
        // }

        //return $user;

    }
}
