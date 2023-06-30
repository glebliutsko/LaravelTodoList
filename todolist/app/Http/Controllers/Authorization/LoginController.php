<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function view(): View
    {
        return view('login.index');
    }

    public function login(Request $request): RedirectResponse
    {
        
    }
}
