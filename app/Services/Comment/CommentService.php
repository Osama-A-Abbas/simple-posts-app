<?php

namespace App\Services\Comment\CommentService;

use App\Http\Requests\Comment\IndexCommentsRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentService{

    public function __construct(
        protected Comment $comment,
        protected Post $post,
    ){}

    public function index(IndexCommentsRequest $request)
    {
        $validatedData = $request->validated();

        if(isset($validatedData['post_id'])){
            $postWithComments = $this->post->with('comments')->findOrFail($validatedData['post_id']);

            return response()->json([
                'post' => $postWithComments,
            ]);
        }

        $comment = $this->comment->with('post')->latest()->get();

        return response()->json([
            'post' => $comment,
        ]);
    }

    public function index2(IndexCommentsRequest $request)
    {
        $validatedData = $request->validated();

        if(isset($validatedData['post_id'])){
            $postWithComments = $this->post->with('comments')->findOrFail($validatedData['post_id']);

            return response()->json([
                'post' => $postWithComments,
            ]);
        }

        $comment = $this->comment->with('post')->latest()->get();

        return response()->json([
            'post' => $comment,
        ]);
    }
}
