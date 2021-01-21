@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('users.create') }}" class="btn rounded-1 airforce dark-4">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class ="form-material" method="GET" action="search">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="search" id="search"class="form-control" />
                        <label for="search">Rechercher</label>
                    </div>
                    <button type ="submit" class="btn circle search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="grix xs1 mt-5 sm3 gutter-xs5">
        @foreach($users as $user)
        <div class="card shadow-1 rounded-2">
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
