<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
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
        return view('category.create');
    }
    /**
     * Add a new category
     */
    public function store()
    {
        $data = request()->validate([
            'category_name' => ['unique:categories,category_name', 'required', 'min:5', 'max:50'], //unique validation not working
            'category_description' => ['max:100', 'required']
        ]);
        $category = new Category($data);
        $category->save();
        return (redirect('/dashboard'));
    }

}
