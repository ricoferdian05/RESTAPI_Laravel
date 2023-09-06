<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //get all data
    public function index()
    {
        $posts = Post::all();
        // return response()->json(['data' => $posts]);
        return PostDetailResource::collection($posts->loadMissing('writer:id,username'));
    }

    // show by id
    public function show($id)
    {
        $post = Post::with('writer:id,username')->findOrFail($id);
        // return response()->json(['data' => $post]);
        return new PostDetailResource($post);
    }

    // show by id
    public function show2($id)
    {
        $post = Post::findOrFail($id);
        // return response()->json(['data' => $post]);
        return new PostDetailResource($post);
    }

    // create a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    // update
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);

        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    // delete
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
