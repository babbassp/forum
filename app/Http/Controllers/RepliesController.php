<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['store', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param Thread  $thread
     * @return mixed
     */
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(10);
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
     * @param Channel      $channel
     * @param ReplyRequest $request
     * @param Thread       $thread
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Channel $channel, Thread $thread, ReplyRequest $request)
    {
        $newReply = $thread->addReply([
            'body'    => $request->input('body'),
            'user_id' => auth()->id()
        ]);

        if ($request->expectsJson()) {
            return $newReply->load('owner');
        }

        return back()->with('flash', 'The reply has been saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ReplyRequest $request
     * @param \App\Models\Reply               $reply
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ReplyRequest $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(
            $request->validated()
        );

        if (request()->wantsJson()) {
            return response(['status' => 'The reply has been updated.']);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reply $reply
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $message = 'The reply has been deleted.';
        try {
            $reply->delete();

            if (request()->wantsJson()) {
                return response(['status' => $message]);
            }
        }catch(\Exception $e) {
            $message = 'The reply could not be deleted.';
        }

        return back()->with('flash', $message);
    }
}
