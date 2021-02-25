<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\Profile;


class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = Profile::all();
        
        return view('profile.index', ['profiles' => $profiles]);
    }
}
