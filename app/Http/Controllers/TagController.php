<?php

namespace App\Http\Controllers;

use App\Models\Products\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index ()
    {
        $tags = Tag::all();
        return response()->json($tags , 200);
    }

    public function show ($id)
    {
        $tag = Tag::find($id);

        if( ! $tag) {
            return response()->json(['error' => 'Tag not found.'] , 404);
        }

        return response()->json($tag , 200);
    }

    public function store (Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name' ,
        ]);

        $tag = Tag::create(['name' => $request->name]);

        return response()->json($tag , 201); // 201 Created
    }

    public function update (Request $request , $id)
    {
        $tag = Tag::find($id);

        if( ! $tag) {
            return response()->json(['error' => 'Tag not found.'] , 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id ,
        ]);

        $tag->update(['name' => $request->name]);

        return response()->json($tag , 200); // 200 OK
    }

    public function destroy ($id)
    {
        $tag = Tag::find($id);

        if( ! $tag) {
            return response()->json(['error' => 'Tag not found.'] , 404);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted successfully.'] , 200); // 200 OK
    }
}
