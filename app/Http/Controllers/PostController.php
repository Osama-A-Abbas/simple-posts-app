<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'data' => $posts
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $post = Post::create($request->validated());
        return response()->json([
            "message" => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
