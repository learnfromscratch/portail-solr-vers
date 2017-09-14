<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Groupe;
use App\Theme;
use App\User;
use App\Miseforme;
use App\Newsletter;
use App\Abonnement;
use Gate;
use Carbon\Carbon;

class GroupeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
         
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupes = Groupe::where('id', '<>', 1)->orderBy('updated_at', 'desc')->get();

        return view('admin.groupes', compact('groupes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create', Groupe::class))
        {
            return redirect()->back()->with('error', 'Vous n êtes pas autorisé à éffectuer cette action');
        }

        $groupes = Groupe::all();
        $themes = Theme::all();

        return view('admin.createGroupe', compact('groupes', 'themes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        if(isset($request['sous_groupe_id']))
            $sousgroupe = $request['sous_groupe_id'];
        else
            $sousgroupe = NULL;
        $groupe = new Groupe();
        $groupe->name = $request['name'];
        $groupe->nbrUser = $request['nbrUser'];
        $groupe->tel = $request['tel'];
        $groupe->address = $request['address'];

        $groupe->save();

        //dd($groupe->id);

        $groupe->themes()->attach($request['themes'] === null ? [] : $request['themes']);

        Abonnement::insert([
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'groupe_id' => $groupe->id,
            ]);

        User::insert([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'groupe_id' => $groupe->id,
            'sous_groupe_id' => $sousgroupe,
            'role_id' => 2,
        ]);

        Miseforme::insert([
            'user_id' => $groupe->id,
            'nombre_sidebar'=> 2,
            'article_par_page' => 5,
            'color_background' => '#f5f8fa',
            'color_widget' => '#f5f8fa'
        ]);

        Newsletter::insert([
            'user_id' => $groupe->id,
            'email' => $request['email'],
            'periode_newslettre' => 'chaque jour',
            'date_envoie_newslettre' => '2017-09-13',
            'envoi_newslettre' => false
        ]);

        return redirect()->back()->with('success', 'Client créé avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('read', Groupe::class))
        {
            return redirect()->back()->with('error', 'Vous n êtes pas autorisé à éffectuer cette action');
        }

        $groupe = Groupe::findOrFail($id);
        $users = $groupe->users;
        $sousGroupes = $groupe->sousGroupes;
        $themes = Theme::all();

        return view('admin.groupeInfo', compact('groupe', 'themes', 'users', 'sousGroupes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('update', Groupe::class))
        {
            return redirect()->back()->with('error', 'Vous n êtes pas autorisé à éffectuer cette action');
        }

        $groupe = Groupe::findOrFail($id);
        $groupe->nbrUser = $request['nbrUser'];
        $groupe->tel = $request['tel'];
        $groupe->address = $request['address'];
        $groupe->abonnement->update(['end_date' => $request['end_date']]);

        $groupe->themes()->detach();
        $groupe->themes()->attach($request['themes'] === null ? [] : $request['themes']);

        $groupe->updated_at = Carbon::now();

        $groupe->save();

        return redirect()->back()->with('success', 'Modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('create', Groupe::class))
        {
            return redirect()->back()->with('error', 'Vous n êtes pas autorisé à éffectuer cette action');
        }

        $groupe = Groupe::findOrFail($id);
        $groupe->delete();

        return redirect()->route('groupes.index')->with('success', 'Le client a été supprimer avec succès');
    }

    public function admin($id)
    {
        $groupe = Groupe::findOrFail($id);
        $sousGroupes = $groupe->sousGroupes;
        $users = $groupe->users;

        return view('clientAdmin', compact('groupe', 'sousGroupes', 'users'));
    }
}
