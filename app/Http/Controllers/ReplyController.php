<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReplyController extends Controller
{
    public function store(StoreReplyRequest $request)
    {
        try {
            $reply = new Reply();
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->comment_id;
            $reply->reply = $request->reply;
            $reply->save();
            return response()->json([
                'error' => false,
                "message" => "Reply Submission Successful"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(UpdateReplyRequest $request, $id)
    {
        try {
            $reply = Reply::findOrFail($id);   
            if(Auth::user()->id == $reply->user_id)
            {
                $reply->reply = $request->reply;
                $reply->update();   
                return response()->json([
                    'error' => false,
                    'message' => 'Reply Updated Successfully'
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
            $reply = Reply::findOrFail($id);   
            if(Auth::user()->id == $reply->user_id) 
            {
                $reply->delete();
                return response()->json([
                    'error' => false,
                    'message' => 'Reply Deleted Successfully'
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
