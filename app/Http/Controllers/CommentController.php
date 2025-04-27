<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\IndexCommentsRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct(
        protected Comment $comment,
        protected Post $post,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCommentsRequest $request)
    {
        $validatedData = $request->validated();

        $postWithComments = $this->post->with('comments')->findOrFail($validatedData['post_id']);

        return response()->json([
            'post' => $postWithComments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $validatedData = $request->validated();

        $post = $this->post->findOrFail($validatedData['post_id']);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validatedData['content'],
        ]);

        return response()->json([
            "message" => 'Post created Successfully',
            'data' => $comment,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'data' => $comment,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $comment->update($request->validated());

        return response()->json([
            "message" => 'Post Updated Successfully',
            'data' => $comment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'message' => 'Comment Deleted Successfully',
        ]);
    }
}
