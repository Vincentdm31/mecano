@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3 container">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('users.create') }}" class="btn rounded-1 orange dark-1 txt-white">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchUser">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchUser" id="searchUser" class="form-control" />
                        <label for="searchUser">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange txt-white search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!--  -->
    <div class="grix xs1 sm2 gutter-xs5 container mt-5 container">
        @foreach($users as $user)
        <?php

        $roleArr = ['Mecanicien', 'Magasinier', 'Admin', 'Root'];
        $role = $user->role;

        $displayRole = $roleArr[$role];

        ?>
        <div class="card shadow-1 dark overflow-visible rounded-2 p-3 m-3">
            <a class="btn circle blue dark-1 txt-white small absolute-pos" style="top:0;left:0;transform:translate(-50%, -50%)" href="{{route('users.edit', ['user' => $user->id])}}"><i class="fas fa-pen"></i></a>
            @if(Auth()->user()->role > 2)
            <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                @method('DELETE')
                @csrf
                <button type="submit" onclick="return confirm('Confirmer la suppression ?')" style="top:0;right:0;transform:translate(50%, -50%)" class="btn circle red dark-1 txt-white small absolute-pos"><i class="fas fa-trash"></i></button>
            </form>
            @endif
            <div class="grix xs2">
                <div>
                    <p class="txt-orange m-0">Nom</p>
                    <p class="txt-white m-0">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="txt-orange m-0">Statut</p>
                    <p class="txt-white m-0">{{ $displayRole }}</p>
                </div>
            </div>
            <div>
                <p class="txt-orange m-0">Email</p>
                <p class="txt-white m-0">{{ $user->email }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection