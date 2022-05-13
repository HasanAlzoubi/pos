<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        //
    }


    public function create(Client $client)
    {
        $categories=Category::with('products')->get();
        return view('dashboard.clients.orders.create',compact('client','categories'));
    }

    public function store(Request $request,Client $client)
    {
        $request->validate([
            'products'=>'required | array',
        ]);
        $order= $client->orders()->create();
        $order->product()->attach($request->products);
        $total_price=0;
        foreach ($request->products as $product_id => $quantities){
            $product=Product::FindOrFail($product_id);
            $total_price+=($product->sale_price) * $quantities['quantity'];

            $product->update([
                'stock'=>$product->stock - $quantities['quantity'],
            ]);
        }
        $order->update([
            'total_price'=>$total_price,
        ]);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    }


    public function show(Order $order)
    {
        //
    }


    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
