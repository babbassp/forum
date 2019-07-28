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
            'activities'  => $this->getActivities($user)
        ]);
    }

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param \App\Models\User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getActivities(User $user)
    {
        return $user->activity()
            ->with('subject')
            ->latest()->limit(50)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
