
@extends('layouts.app')

@section('content')
<!-- ADMIN VIEW -->
    @if(Auth()->user()->is_admin)
    <div class="container mt-5">
        <div class="grix xs1 sm2 mt-5">
            <a href="{{route('users.index')}}" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Gestion utilisateurs</a>
            <a href="" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Interventions</a>
        </div>
    </div>
    
<!-- USER VIEW -->
    @else
    <div class="container mt-5">
        <div class="grix xs1 sm3 mt-5">
            <form class="form-material" method="POST" action="{{ route('interventions.store') }}">
                @csrf
                <button type="submit" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Nouvelle</button>
            </form>
            <a href="" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Rejoindre</a>
            <a href="" class="btn press airforce dark-4 rounded-1 shadow-1 w100">Reprendre</a>
        </div>
    </div>
    @endif
@endsection
