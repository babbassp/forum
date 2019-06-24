<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Requests\ThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
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
     * @param \App\Models\Channel        $channel
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Filters\ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, Request $request, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if ($request->wantsJson()) {
            return $threads;
        }

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
     * @throws
     * @param  \App\Http\Requests\ThreadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $thread = Thread::create($validated);

        return redirect(route('threads.show', $thread->getUrlParams()));
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
            'thread'  => $thread,
            'replies' => $thread->replies()->paginate(10)
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

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param \App\Models\Channel        $channel
     * @param \App\Filters\ThreadFilters $filters
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters)->latest();

        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        }

        return $threads->get();
    }
}
