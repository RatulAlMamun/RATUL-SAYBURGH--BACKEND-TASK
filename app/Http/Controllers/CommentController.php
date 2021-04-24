<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::where('user_id', Auth::user()->id)->get();
        foreach($comments as $comment)
        {
            $comment->post;
        }
        if(count($comments) > 0 )
        {
            return response()->json([
                'error' => false,
                'message' => $comments
            ]);
        } else {
            return response()->json([
                'error' => false,
                'message' => "You have no Comments on any post"
            ]);
        }
    }

    public function store(StoreCommentRequest $request)
    {
        try {
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $request->post_id;
            $comment->comment = $request->comment;
            $comment->save();
            return response()->json([
                'error' => false,
                "message" => "Comment Submission Successful"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(UpdateCommentRequest $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);   
            if(Auth::user()->id == $comment->user_id)
            {
                $comment->comment = $request->comment;
                $comment->update();   
                return response()->json([
                    'error' => false,
                    'message' => 'Comment Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Unauthorized Access'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);   
            if(Auth::user()->id == $comment->user_id) 
            {
                $comment->delete();
                return response()->json([
                    'error' => false,
                    'message' => 'Comment Deleted Successfully'
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Unauthorized Access'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
