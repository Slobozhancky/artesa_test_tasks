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
            echo $category->title . ' > ';
        }
        // ==========================================================================================

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create ()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store (Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show (Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit (Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request , Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy (Product $product)
    {
        //
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
