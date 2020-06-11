<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    public function index(Request $request) {
        $users = new User();
        $users = $users->where('id', 'like', '%')->orderBy('id')->paginate(5);
        return view('user.index', compact('users'), ['user'=> Auth::user()]);
    }

    public function create(Request $request)
    {
        $user = new User;
        $route = ['users.store'];
        $create = true;
        return view('user.create_edit')->with(compact('user', 'route', 'create'), ['user'=> Auth::user()]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::query()->find($id);
        $route = ['users.update', $id];
        $create = false;
        return view('user.create_edit')->with(compact('user', 'route', 'create'), ['user'=> Auth::user()]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
            'is_admin' => '',
        ]);

        $userModel = new User;
        $userModel->setAttribute('email',  $validatedData['email']);
        $userModel->setAttribute('name',  $validatedData['name']);
        $userModel->setAttribute('password',  Hash::make($validatedData['password']));
        $userModel->setAttribute('is_admin',  isset($validatedData['is_admin']));
        $userModel->save();
        return redirect('users');
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => '',
            'is_admin' => '',
        ]);

        $userModel = User::query()->find($id);
        $userModel->setAttribute('email',  $validatedData['email']);
        $userModel->setAttribute('name',  $validatedData['name']);
        if (isset($validatedData['password']))
            $userModel->setAttribute('password',  Hash::make($validatedData['password']));
        $userModel->setAttribute('is_admin',  isset($validatedData['is_admin']));
        $userModel->save();
        return redirect('users');
    }

    public function destroy($id)
    {
        $user = User::query()->find($id);
        $user->delete();
        return redirect('users');
    }
}
