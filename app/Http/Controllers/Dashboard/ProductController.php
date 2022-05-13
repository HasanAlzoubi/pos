<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Traits\image_trait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    use image_trait;

    public function index(Request $request)
    {

        $categories = Category::all();

        $products = Product::when($request->search, function ($query) use ($request) {

            return $query->where('name', 'like', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories', 'products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ]);

        $data = $request->except('image');

        if ($request->image) {

            Image::make($request->image)->resize(300, null, function ($constant) {

                $constant->aspectRatio();

            })->save(public_path('uploads/product_images/' . $this->File_name($request->image)));

            $data['image'] = $this->File_name($request->image);
        }


        Product::create($data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    }


    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('dashboard.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ]);

        $data = $request->except('image');

        if ($request->image) {

            Storage::disk('public_auplods')->delete('product_images/' . $product->image);

            Image::make($request->image)->resize(300, null, function ($constant) {

                $constant->aspectRatio();

            })->save(public_path('uploads/product_images/' . $this->File_name($request->image)));

            $data['image'] = $this->File_name($request->image);
        }


        $product->update($data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');

    }


    public function destroy(Product $product)
    {

        if ($product->image != 'default.png') {

            Storage::disk('public_auplods')->delete('product_images/' . $product->image);

        }
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
