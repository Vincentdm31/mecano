@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ADMIN VIEW -->
@if(Auth()->user()->is_admin)
<div class="container home">
    <div class="grix xs1 md6 gutter-xs4 mt-5 home h100">
        <div>
            <a href="" class="btn orange dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Interventions</a>
        </div>
        <div>
            <a href="{{ route('users.index') }}" class="btn red dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion utilisateurs</a>
        </div>
        <div>
            <a href="{{ route('vehicules.index') }}" class="btn airforce dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion véhicules</a>
        </div>
        <div>
            <a href="{{ route('piecesList.index') }}" class="btn green dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion pièces</a>
        </div>
        <div>
            <a href="{{ route('operationsList.index') }}" class="btn cyan dark-2 txt-white d-flex vcenter fx-center rounded-1 shadow-1 hoverable-1 h100 w100 mb-2">Gestion opérations</a>
        </div>
        <div>
            <a href="{{ route('getVehicules') }}" class="btn amaranth dark-1 hoverable-1 txt-white rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">API</a>
        </div>
    </div>
</div>

<!-- USER VIEW -->
@else
<div class="container home mt-3">
    <div class="grix xs1 gutter-xs5 md4 home">
        <div class="h100">
            <form class="form-material h100" method="POST" action="{{ route('interventions.store') }}">
                @csrf
                <button type="submit" class="btn green dark-1 txt-white hoverable-1 rounded-1 shadow-1 h100 w100">Nouvelle</button>
            </form>
        </div>
        <div class="h100">
            <a href="{{ route('interventions.index') }}" class="btn red dark-1 txt-white hoverable-1 rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">Liste complète</a>
        </div>
        <div class="h100">
            <a href="{{ route('joinIntervention') }}" class="btn cyan dark-1 txt-white hoverable-1 rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">Rejoindre</a>
        </div>
        <div class="h100">
            <a href="{{ route('resumeIntervention') }}" class="btn orange dark-1 hoverable-1 txt-white rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">Reprendre</a>
        </div>
    </div>
</div>
@endif



@endsection



@section('extra-js')

<script>
    let toast = new Axentix.Toast();
</script>

@if(session('error') == 'noadmin')
<script>
    toast.change("Vous n'avez pas accés à cette page", {
        classes: "rounded-1 red txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
@endsection