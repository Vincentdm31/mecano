<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('users.show', ['user' => User::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit', ['user' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at');
        $user = User::find($id);
        foreach ($inputs as $key => $value){
            $user->$key = $value;
        }
        $user->save();
        return redirect(route('users.index'))->with('toast', 'userUpdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        
        
        return redirect(route('users.index'))->with('toast', 'userDelete');
    }

    public function searchUser(Request $request)
    {
        $search = $request->get('searchUser');

        $users = User::Where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('is_admin', 'like', '%'.$search.'%')
                    ->get();
        return view('users.index', ['users' => $users]);
    }
}
