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

    <div class="container mt-5">
        <div class="responsive-table dark rounded-2">
            <table class="table striped centered">
                <thead>
                    <tr class="txt-orange">
                        <th class="txt-white">#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <?php

                    $roleArr = ['Mecanicien', 'Magasinier', 'Admin', 'Root'];
                    $role = $user->role;

                    $displayRole = $roleArr[$role];

                    ?>
                    <tr class="txt-white">
                        <td class="txt-orange">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $displayRole }}</td>
                        <td>
                            <div class="grix xs2">
                                <div>
                                    <a class="btn circle blue dark-1 txt-white small" href="{{route('users.edit', ['user' => $user->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    @if(Auth()->user()->role > 2)
                                    <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle red dark-1 txt-white small"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- test -->
</div>

@endsection