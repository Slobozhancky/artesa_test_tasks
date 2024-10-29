<?php

namespace App\Http\Controllers;

use App\Models\Products\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $existingCategory = Category::where('title', $request->title)
            ->where('parent_id', $request->parent_id)
            ->first();

        if ($existingCategory) {
            return response()->json([
                'error' => "Category {$request->title} exists"
            ], 409);
        }

        $category = Category::create([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json($category, 201);
    }
    public function storeChildCategory(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $parentCategory = Category::findOrFail($id);

        $subcategory = Category::create([
            'title' => $request->title,
            'parent_id' => $parentCategory->id,
        ]);

        return response()->json($subcategory, 201);
    }

    public function show($id)
    {

        try {
            $category = Category::findOrFail($id);
            return response()->json($category, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "Category {$id} not found"
            ], 404); // 404 Not Found
        }
    }
    public function showSubcategory($id)
    {

        try {
            $category = Category::findOrFail($id);
            return response()->json($category, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "Category {$id} not found"
            ], 404); // 404 Not Found
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);

        $existingCategory = Category::where('title', $request->title)
            ->where('parent_id', $request->parent_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingCategory) {
            return response()->json([
                'error' => "Category {$request->title} already exists"
            ], 409);
        }

        $category->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Перевірка на наявність дочірніх категорій
        if ($category->children()->exists()) {
            return response()->json([
                'error' => "Can`t be delete. Category {$id} has subcategory"
            ], 400); // 400 Bad Request
        }

        $category->delete();

        return response()->json([
            'message' => "Category {$id} delete"
        ], 200);
    }

    public function destroySubcategory($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json([
            'message' => "Category {$id} delete"
        ], 200);
    }
}
