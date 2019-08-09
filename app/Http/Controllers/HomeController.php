<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->guest()) {
            return view('auth.login');
        }

        return redirect(
            route('profile', auth()->user())
        );
    }
}
