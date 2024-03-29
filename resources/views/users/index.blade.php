@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="container mt-5 txt-right">
        <a href="{{ route('users.create') }}" class="btn hoverable-1 rounded-1 orange dark-1 txt-white small mb-2">Nouvel utilisateur <i class="fas fa-plus white txt-orange p-1 rounded-1"></i></a>
        <div class="responsive-table bg-blue3 shadow-2 rounded-2">
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
                    @if(Auth()->user()->role >= $user->role)

                    <?php

                    $roleArr = ['Mecanicien', 'Magasinier', 'Facturation', 'Admin', 'Root'];
                    $role = $user->role;

                    $displayRole = $roleArr[$role];

                    ?>
                    <tr class="txt-white">
                        <td class="txt-orange">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $displayRole }}</td>
                        <td>
                            @if(Auth()->user()->role > 3)
                            <div class="grix xs2">
                                <div>
                                    <a class="btn circle orange dark-1 txt-white small" href="{{route('users.edit', ['user' => $user->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle red dark-1 txt-white small"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <a class="btn circle orange dark-1 txt-white small" href="{{route('users.edit', ['user' => $user->id])}}"><i class="fas fa-pen"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection