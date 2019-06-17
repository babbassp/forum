<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

/**
 * Class ThreadsController
 *
 * @package App\Http\Controllers
 */
class ThreadsController extends Controller
{

    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')
            ->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::all();

        return view('threads.index')->with('threads', $threads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => $request->input('channel_id'),
            'title'      => $request->input('title'),
            'body'       => $request->input('body')
        ]);

        return redirect(route('threads.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param                     $channel
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread)
    {
        return view('threads.show')->with([
            'channel' => $channel,
            'thread'  => $thread
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Thread       $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
