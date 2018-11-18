<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加

class UsersController extends Controller
{
     public function index()
    {
        $users = User::paginate(10);
    }
    
     public function show($id)
    {
        $user = User::find($id);

        return view('users.show', [
            'user' => $user,
        ]);
    }
 
}        
        return view('users.index', [
            'users' => $users,
        ]);

