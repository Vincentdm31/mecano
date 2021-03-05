@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container shadow-1 grix xs1 md2 mt-5">
        <div class="p-3">
            <p>Nom : {{ $pieceList->name }}</p>
            <p>Ref : {{ $pieceList->ref }}</p>
            <p>Prix : {{ $pieceList->price }} €/u</p>
            <p>Quantité : {{ $pieceList->qte }}</p>
        </div>
        <img src="{{ asset('storage/images/'.$pieceList->path) }}" class="responsive-media p-3">
    </div>

</div>

@endsection