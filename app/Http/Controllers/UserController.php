<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token', 'created_at', 'updated_at', 'password');
        $password = $request->input('password');
        $hashed = FacadesHash::make($password);
        $user = new User();
        foreach ($inputs as $key => $value) {
            $user->$key = $value;
        }
        $user->password = $hashed;
        $user->save();

        return redirect(route('users.index'))->with('toast', 'userStore');
    }

    public function show($id)
    {
        return view('users.show', ['user' => User::find($id)]);
    }

    public function edit($id)
    {
        return view('users.edit', ['user' => User::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at');
        $user = User::find($id);
        foreach ($inputs as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        return redirect(route('users.index'))->with('toast', 'userUpdate');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();


        return redirect(route('users.index'))->with('toast', 'userDelete');
    }
}
