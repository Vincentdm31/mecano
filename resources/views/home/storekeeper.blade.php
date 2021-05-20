@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <p class="mb-5 pb-4 bd-b-solid bd-orange bd-3 bd-dark-1 txt-gl4 font-s8">Espace Magasinier</p>
    <div class="grix xs1 gutter-xs4 mt-5">
        <div>
            <a href="{{ route('piecesList.index') }}" class="btn blue txt-white d-flex vcenter fx-center rounded-1 shadow-1 w100 mb-2">Gestion pièces</a>
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