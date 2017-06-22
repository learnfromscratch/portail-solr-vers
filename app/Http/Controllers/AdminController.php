<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserKeyword;
use App\Keyword;
use App\Repositories\Solarium;

class AdminController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->middleware('auth');
    	$this->middleware('admin');
    }

    public function index(\Solarium\Client $client)
    {
        $nbrUser = count(User::all());
        $notIndexed = 10;
    	return view('admin.dashboard', compact('nbrUser', 'notIndexed'));
    }
    
    public function delete(\Solarium\Client $client) {
        $update = $client->createUpdate();

        // add the delete id and a commit command to the update query
        $update->addDeleteById('170208TestWP114');
        $update->addCommit();

        // this executes the query and returns the result
        $result = $client->update($update);
    }

    public function indexing(\Solarium\Client $client)
    {
        (new Solarium($client))->indexing();

        return redirect()->route('dashboard');
    }

    public function showUsers()
    {
        $users = User::paginate('10');

        return view('admin.users', compact('users'));
    }

    public function addUsers()
    {
        $keywords = Keyword::all();
        return view('admin.addUsers', compact('keywords'));
    }

}
