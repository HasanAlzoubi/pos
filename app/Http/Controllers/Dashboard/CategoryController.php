<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categories_create')->only('create');
        $this->middleware('permission:categories_read')->only('read');
        $this->middleware('permission:categories_update')->only('edit');
        $this->middleware('permission:categories_delete')->only('delete');
    }

    public function index(Request $request)
    {
        $categories=Category::when($request->search , function($query) use ($request){

                return $query->where('name','like','%'.$request->search.'%');

        })->latest()->paginate(5);


        return view('dashboard.categories.index',compact('categories'));
    }


    public function create()
    {
        return view('dashboard.categories.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required | unique:categories'
        ]);

        Category::create($request->all());
        session()->flash('success',__('site.added_successfully'));

        return redirect()->route('dashboard.categories.index');
    }

    public function show(Category $category)
    {

    }


    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category->id)]
        ]);

        $category->update($request->all());

        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}
