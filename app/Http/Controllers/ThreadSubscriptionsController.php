<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\ThreadSubscription;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Channel $channel
     * @param \App\Models\Thread  $thread
     * @return void
     */
    public function store(Channel $channel, Thread $thread)
    {
        $thread->subscribe();

        if (request()->wantsJson()) {
            return response(['status' => 'Subscribed to thread.']);
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ThreadSubscription $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function show(ThreadSubscription $threadSubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ThreadSubscription $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreadSubscription $threadSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request       $request
     * @param \App\Models\ThreadSubscription $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreadSubscription $threadSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Channel $channel
     * @param \App\Models\Thread  $thread
     * @return void
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $thread->unsubscribe();

        if (request()->wantsJson()) {
            return response(['status' => 'Unsubscribed from thread.']);
        }

        return back();
    }
}
