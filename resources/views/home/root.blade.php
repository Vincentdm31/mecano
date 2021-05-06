@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <p class="mb-5 pb-4 bd-b-solid bd-orange bd-3 bd-dark-1 txt-airforce txt-dark-4 font-s8 lh-4">Espace Super Admin</p>
    <div class="grix xs1 md6 gutter-xs4 mt-5 h100">
        <div>
            <a href="{{ route('adminIntervention') }}" class="btn blue txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Interventions</a>
        </div>
        <div>
            <a href="{{ route('users.index') }}" class="btn blue dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion utilisateurs</a>
        </div>
        <div>
            <a href="{{ route('vehicules.index') }}" class="btn blue dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion véhicules</a>
        </div>
        <div>
            <a href="{{ route('piecesList.index') }}" class="btn blue dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion pièces</a>
        </div>
        <div>
            <a href="{{ route('operationsList.index') }}" class="btn blue dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion opérations</a>
        </div>
        <div>
            <a href="{{ route('getVehicles') }}" class="btn red dark-2 hoverable-1 txt-white rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">API</a>
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