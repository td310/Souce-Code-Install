<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Enums\AuthStatus;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $topUser = User::firstWhere('first_name', 'Super');
        return view('home', compact('users','topUser'));
    }
}
