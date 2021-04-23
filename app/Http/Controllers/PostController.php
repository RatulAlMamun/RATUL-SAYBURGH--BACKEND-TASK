<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePutRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth:api');
    }

    public function index()
    {
        $posts = Post::where('user_id', Auth::user()->id)->get();
        foreach ($posts as $post)
        {
            $post->comments;
        }
        if(count($posts) > 0 )
        {
            return response()->json([
                'error' => false,
                'message' => $posts
            ]);
        } else {
            return response()->json([
                'error' => false,
                'message' => "You have no Post"
            ]);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
            $post->comments;
            if($post)
            {
                return response()->json([
                    'error' => false,
                    'message' => $post,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Unauthorized Access"
                ]);
            }
        } catch(Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(StorePostRequest $request)
    { 
        $image = $request->file('image')->store('postImages');
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $image;
        $post->save();
        return response()->json([
            'error' => false,
            "message" => "Post Created Successfully"
        ], 200);
    }

    public function update(UpdatePutRequest $request, $id)
    {
        $posts = Post::findOrFail($id);   
        if(Auth::user()->id == $posts->user_id)
        {
            if ($request->hasFile('image'))
            {
                Storage::delete($posts->image);
                $posts->image = $request->file('image')->store('postImages');
            }
            $posts->title = $request->title;
            $posts->description = $request->description;
            $posts->update();   
            return response()->json([
                'error' => false,
                'message' => 'Post Updated Successfully'
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized Access'
            ]);
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);   
        if(Auth::user()->id == $post->user_id) 
        {
            $post->delete();
            return response()->json([
                'error' => false,
                'message' => 'Post Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized Access'
            ]);
        }
    }
}
