<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index( Request $request )
    {
        $clients=Client::all();

        $clients=Client::when($request->search,function($q) use ($request) {

            return $q->where('name','like','%'.$request->search.'%')
                      ->orWhere('phone','like','%'.$request->search.'%')
                      ->orWhere('address','like','%'.$request->search.'%');

        })->latest()->paginate(5);
//        return response()->json($clients);

       return view('dashboard.clients.index',compact('clients'));


    }

    public function create()
    {
        return view('dashboard.clients.create');

    }


    public function store(Request $request)
    {
//        return $request;
        $request->validate([
           'name'=>'required' ,
           'phone'=>'required | array',
           'phone.0'=>'required',
           'address'=>'required',
        ]);

        $client_request=$request->all();
        $client_request['phone']=array_filter($request->phone);
        Client::create($client_request);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function edit(Client $client)
    {
       return view('dashboard.clients.edit',compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'=>'required' ,
            'phone'=>'required | array',
            'phone.0'=>'required',
            'address'=>'required',
        ]);

        $client_request=$request->all();
        $client_request['phone']=array_filter($request->phone);
        $client->update($client_request);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }


    public function destroy(Client $client)
    {
        $client->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}
