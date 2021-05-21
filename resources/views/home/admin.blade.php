@extends('layouts.app')
@section('content')
<div class="container">
    <p class="mb-5 pb-4 bd-b-solid bd-orange bd-3 bd-dark-1 txt-gl4 font-s8">Espace Admin</p>
    <div class="grix xs2 md6 gutter-xs4 mt-5 h100">
        <div class="home-btn">
            <a href="{{ route('adminIntervention') }}" class="btn orange txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Interventions</a>
        </div>
        <div class="home-btn">
            <a href="{{ route('users.index') }}" class="btn blue txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion utilisateurs</a>
        </div>
        <div class="home-btn">
            <a href="{{ route('vehicules.index') }}" class="btn blue txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion véhicules</a>
        </div>
        <div class="home-btn">
            <a href="{{ route('piecesList.index') }}" class="btn blue txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion pièces</a>
        </div>
        <div class="home-btn">
            <a href="{{ route('operationsList.index') }}" class="btn blue txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion opérations</a>
        </div>
    </div>
</div>
@endsection

@section('extra-js')

<script>
    let toast = new Axentix.Toast();
</script>

@if(session('error') == 'restrictAccess')
<script>
    toast.change("Vous n'avez pas accés à cette page", {
        classes: "rounded-1 red txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif

@endsection