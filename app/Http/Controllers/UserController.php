<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function show(User $user){
        return $user;
    }

  	public function store(Request $request)
    {
        $article = User::create($request->all());

        return response()->json($article, 201);
    }
}
