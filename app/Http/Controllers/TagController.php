<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        try {
            $tags = Tag::all();
            return response()->json([
                'error' => false,
                "message" => $tags
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function store(StoreTagRequest $request)
    {
        try {
            $tag = new Tag();
            $tag->name = $request->name;
            $tag->save();
            return response()->json([
                'error' => false,
                "message" => "Tag Created Successfully"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(UpdateTagRequest $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->name = $request->name;
            $tag->update();   
            return response()->json([
                'error' => false,
                'message' => 'Tag Updated Successfully'
            ], 200);
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
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return response()->json([
                'error' => false,
                'message' => 'Tag Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
