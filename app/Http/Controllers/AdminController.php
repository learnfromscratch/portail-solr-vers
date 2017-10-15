<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Keyword;
use App\Repositories\Solarium;
use App\Repositories\Alert;
use App\Groupe;

class AdminController extends Controller
{
    protected $client;

    public function __construct(\Solarium\Client $client)
    {
        $this->middleware('auth');
    	$this->middleware('admin');
        $this->client = $client;
    }

    public function index()
    {
        $nbrUser = count(User::where('groupe_id', '<>', 1)->get());
        $nbrGroupe = count(Groupe::where('id', '<>', 1)->get());
            $query = $this->client->createSelect();
            $query->setQuery('*:*');
            $resultset = $this->client->select($query);            
            $indexed = $resultset->getNumFound();
        $nbrKeyword = count(Keyword::all());
    	return view('admin.dashboard', compact('nbrGroupe', 'nbrUser', 'indexed', 'nbrKeyword'));
    }

    public function theme(){
        
        return view('admin.theme');
    }

    public function indexing(\Solarium\Client $client)
    {
        (new Solarium($client))->indexing();

        (new Alert($client))->index();

        return redirect()->route('admin.dashboard');
    }

    public function showUsers()
    {
        $users = User::paginate('10');

        return view('admin.users', compact('users'));
    }

}
