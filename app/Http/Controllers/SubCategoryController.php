<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
class SubCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Create a new category form
     */
    public function create()
    {
        $categories = (Category::all());
        // dd($categories);
        return view('sub_category.create', [
            'categories' => $categories
        ]);
    }
    /**
     * Add a new category
     */
    public function store()
    {
        $data = request()->validate([
            'category_id' => 'exists:categories,id',
            'sub_category_name' => ['required', 'min:4', 'max:20'], //unique validation not working
        ]);
        $sub_category = new SubCategory($data);
        $sub_category->save();
        return (redirect('/dashboard'));
    }
}
