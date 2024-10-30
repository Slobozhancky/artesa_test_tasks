<?php

namespace App\Http\Controllers;

use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index ()
    {

        // 1. For a given list of products, get the names of all categories that contain this products;
        $productIds = [1 , 7 , 3 , 4];

        $categories = Category::whereHas('products' , function ($query) use ($productIds) {
            $query->whereIn('product_id' , $productIds);
        })->get(['title']);

        dump($categories);

        // ==========================================================================================

        // 2. For a given category, get a list of offers for all products in this category and its
        //child categories.
        $categoryId = 1;

        $category = Category::with('children.products')->find($categoryId);

        $products = $category->products;

        foreach($category->children as $child) {
            $products = $products->merge($child->products);
        }

        dump($products);
        // ==========================================================================================

        // 3. For a given list of categories, get the number of product offers in each category;

        $categoryIds = [1 , 2 , 3];

        $categoriesWithProductCount = Category::with('children.products')
            ->whereIn('id' , $categoryIds)
            ->get();


        foreach($categoriesWithProductCount as $category) {

            $productCount = $category->products->sum('product_quantity');

            foreach($category->children as $child) {
                $productCount += $child->products->sum('product_quantity');
            }

            dump("Category: {$category->title}, Total Products: {$productCount}");
        }

        // ==========================================================================================

        // 4. For a given list of categories, get the total number of unique product offers;

        $categoryIds = [1 , 2 , 3];

        $uniqueProductIds = Category::whereIn('id' , $categoryIds)
            ->orWhereHas('children' , function ($query) use ($categoryIds) {
                $query->whereIn('parent_id' , $categoryIds);
            })
            ->with('products')
            ->get()
            ->pluck('products')
            ->flatten()
            ->unique('id')
            ->count();

        dump("Total unique Products: {$uniqueProductIds}");

        // ==========================================================================================

        // 5. For a given category, get its full path in the tree (breadcrumb).
        $breadcrumbPath = $this->getCategoryBreadcrumb(3);

        foreach($breadcrumbPath as $category) {
            dump($category->title . ' > ');
        }
        // ==========================================================================================

    }

    public function update (Request $request , $id)
    {

        $product = Product::find($id);

        if( ! $product) {
            return response()->json([
                'error' => 'Product not found.'
            ] , 404);
        }

        $request->validate([
            'product_name' => 'required|string|max:255' ,
            'product_price' => 'required|numeric|min:0' ,
            'product_quantity' => 'nullable|integer|min:0' ,
            'category_id' => 'nullable|exists:categories,id' ,
        ]);

        $product->update($request->only([
            'product_name' ,
            'product_price' ,
            'product_quantity' ,
            'category_id'
        ]));


        return response()->json($product->load('categories') , 200);
    }


    public function store (Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255' ,
            'product_price' => 'required|numeric|min:0' ,
            'product_quantity' => 'nullable|numeric' ,
            'category_ids' => 'array' ,
            'category_ids.*' => 'exists:categories,id' ,
        ]);

        $product = Product::create([
            'product_name' => $request->product_name ,
            'product_price' => $request->product_price ,
            'product_quantity' => $request->product_quantity ,
        ]);

        if($request->has('category_ids')) {
            $product->categories()->attach($request->category_ids);
        }

        return response()->json($product->load('categories') , 201);
    }

    public function showAllProducts (Request $request)
    {
        try {
            $perPage = $request->input('per_page' , 20); // За замовчуванням 20 товарів на сторінку
            $products = Product::paginate($perPage);
            return response()->json($products , 200);
        } catch(\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while retrieving products.' ,
                'message' => $e->getMessage() ,
            ] , 500);
        }
    }

    public function show ($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        return response()->json($product , 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy (Product $product , $id)
    {
        $product = Product::find($id);

        if( ! $product) {
            return response()->json([
                'error' => 'Product not found.'
            ] , 404); // Повертаємо помилку 404, якщо товар не знайдено
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.'
        ] , 200);
    }

    function getCategoryBreadcrumb ($categoryId)
    {
        $breadcrumbs = collect();

        // Починаємо з поточної категорії
        $category = Category::find($categoryId);

        while($category) {
            $breadcrumbs->prepend($category);
            $category = $category->parent;
        }

        return $breadcrumbs;
    }
}
