@extends('layouts.app')
@section('content')
<div class="container home mt-3">
    <p class="h5 mb-5 pb-2 bd-b-solid bd-orange bd-3 bd-dark-1 txt-airforce txt-dark-4">Espace Mécano</p>
    <div class="grix xs1 gutter-xs5 md4">
        <div class="h100">
            <form class="form-material h100" method="POST" action="{{ route('interventions.store') }}">
                @csrf
                <button type="submit" class="btn blue txt-white rounded-1 shadow-1 h100 w100">Nouvelle intervention</button>
            </form>
        </div>
        <div class="h100">
            <a href="{{ route('joinIntervention') }}" class="btn blue dark-3 txt-white rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">Rejoindre une intervention</a>
        </div>
        <div class="h100">
            <a href="{{ route('resumeIntervention') }}" class="btn blue dark-3 txt-white rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">Reprendre une intervention</a>
        </div>
        <div class="h100">
            <a href="{{ route('interventions.index') }}" class="btn blue dark-4 txt-white rounded-1 shadow-1 w100 h100 d-flex fx-center vcenter">Liste complète</a>
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