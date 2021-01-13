@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3 gutter-xs5">
        @foreach($users as $user)
        <div class="card shadow-1">
            <div class="card-header">
                {{$user->name}}
            </div>
            <div class="card-content">
               <p>{{$user->email}}</p>
               @if($user->is_admin)
                <p>Admin</p>
                @else
                <p>Membre</p>
                @endif
            </div>
            <div class="card-footer">
                <div class="flex grix xs3 gutter-xs0 center ">
                    <a href="{{route('users.show', ['user' => $user->id])}}" class="btn circle airforce dark-4 txt-white ml-auto  push"><i class="fas fa-info"></i></a>
                    <a class="btn circle airforce dark-4 txt-white push" href="{{route('users.edit', ['user' => $user->id])}}"><i class="fas fa-pen"></i></a>
                    <div class="mr-auto">
                        <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle airforce dark-4 txt-white push"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection
