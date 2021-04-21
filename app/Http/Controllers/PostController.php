<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePutRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth:api');
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
        dd($request->all());
        // $post = Post::findOrFail($id);   
        // if(Auth::user()->id == $post->user_id)
        // {
        //     if ($request->hasFile('image'))
        //     {
        //         Storage::delete($request->image);
        //         $post->image = $request->file('image')->store('postImages');
        //     }
        //     $post->title = $request->title;
        //     $post->description = $request->description;
        //     $post->update();   
        //     return response()->json([
        //         'error' => false,
        //         'message' => 'Post Updated Successfully'
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'Unauthorized Access'
        //     ]);
        // }
    }
}
