<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token', 'created_at', 'updated_at');
        $user = new User();
        foreach ($inputs as $key => $value) {
            $user->$key = $value;
        }
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
        return view('user.show', ['user' => User::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit', ['user' => User::find($id)]);
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

  // public function searchCar(Request $request)
  //     {
  //         $search = $request->get('search');
  //         $cars = Car::where('idgps', 'like', '%'.$search.'%')
  //                     ->orWhere('immat', 'like', '%'.$search.'%')
  //                     ->orWhere('numsupgeo', 'like', '%'.$search.'%')
  //                     ->orWhere('numligne', 'like', '%'.$search.'%')
  //                     ->orWhere('numsimviergereafect', 'like', '%'.$search.'%')
  //                     ->orWhere('F', 'like', '%'.$search.'%')
  //                     ->orWhere('state', 'like', '%'.$search.'%')
  //                     ->get();

  //         return view('car.index', ['cars' => $cars]);
  //     }
}
