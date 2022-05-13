<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Traits\image_trait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    use image_trait;

    public function __construct()
    {
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_read')->only('read');
        $this->middleware('permission:users_update')->only('edit');
        $this->middleware('permission:users_delete')->only('delete');
    }

    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {

                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');

            });
        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));


    }

    public function create()
    {

        return view('dashboard.users.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required | unique:users',
            'password' => 'required|confirmed',

        ]);
        $data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $data['password'] = bcrypt($request->password);

        if ($request->image) {

            Image::make($request->image)->
            resize(300, null, function ($constant) {
                $constant->aspectRatio();
            })->save(public_path('uploads/user_images/' . $this->File_name($request->image)));

            $data['image'] = $this->File_name($request->image);
        }


        $user = User::create($data);
        $user->attachRole('admin');

        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');

    }


    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {

        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'image' => 'image',

        ]);

        $data = $request->except(['permissions', 'image']);

        if ($request->image) {
            Storage::disk('public_auplods')->delete('/user_images/' . $user->image);

            Image::make($request->image)->
            resize(300, null, function ($constant) {
                $constant->aspectRatio();
            })
                ->save(public_path('uploads/user_images/' . $this->File_name($request->image)));

            $data['image'] = $this->File_name($request->image);

        }

        $user->update($data);
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_auplods')->delete('/user_images/' . $user->image);
        }
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    }
}
