<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function checkrole()
    {
        if (auth()->user()->role_id == 1) {
            return redirect()->route('dashboards.admin');
        }
    }
}
