<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfilesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'threads'     => $user->threads()->simplePaginate(15)
        ]);
    }
}
