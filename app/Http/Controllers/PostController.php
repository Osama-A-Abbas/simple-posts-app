<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct(
        protected Post $post,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->post::with('comments')->get();
        return response()->json([
            'data' => $posts
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        return response()->json([
            "message" => 'Post created Successfully',
            'data' => $post,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update($request->validated());

        return response()->json([
            "message" => 'Post Updated Successfully',
            'data' => $post,
        ]);

        //This approach allows more customization
        // $response = Gate::inspect('update', $post);

        // if ($response->allowed()){
        //     $post->update($request->validated());

        //     return response()->json([
        //         "message" => 'Post Updated Successfully',
        //         'data' => $post,
        //     ]);
        // } else {
        //     return response()->json([
        //         "message" => 'Unauthorized only the owner of the post can update it',
        //     ],403);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json([
            "message" => 'Post Deleted Successfully',
        ]);
    }
}
